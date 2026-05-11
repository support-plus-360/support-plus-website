#!/usr/bin/env python3
"""
Sync missing CMS API routes from `packages/Webkul/Cms/src/Routes/api.php`
into `resources/swagger/openapi.json`.

Usage:
  python scripts/sync_cms_openapi.py
  python scripts/sync_cms_openapi.py --dry-run
  python scripts/sync_cms_openapi.py --exclude "/cms/api/links"
  python scripts/sync_cms_openapi.py --exclude "put /cms/api/links/{id}"
  python scripts/sync_cms_openapi.py --exclude "/cms/api/blog-posts#post"
"""

from __future__ import annotations

import argparse
import json
import re
from pathlib import Path
from typing import Dict, List, Set, Tuple


ROOT = Path(__file__).resolve().parents[1]
ROUTES_FILE = ROOT / "packages" / "Webkul" / "Cms" / "src" / "Routes" / "api.php"
OPENAPI_FILE = ROOT / "resources" / "swagger" / "openapi.json"

HTTP_METHODS = {"get", "post", "put", "patch", "delete"}


def normalize_path(path: str) -> str:
    path = (path or "").strip()
    if not path:
        return "/"
    if not path.startswith("/"):
        path = f"/{path}"
    path = re.sub(r"/{2,}", "/", path)
    if path != "/":
        path = path.rstrip("/")
    return path


def parse_route_groups(content: str) -> List[Tuple[str, str]]:
    """
    Extract tuples: (http_method, full_path) from grouped Route::prefix blocks.
    """
    results: List[Tuple[str, str]] = []
    group_pattern = re.compile(
        r"Route::prefix\('(?P<prefix>[^']+)'\)\s*->controller\([^)]+\)\s*->group\(function\s*\(\)\s*\{(?P<body>.*?)\}\);",
        re.DOTALL,
    )
    route_pattern = re.compile(r"Route::(?P<method>get|post|put|patch|delete)\('(?P<uri>[^']*)'")

    for group in group_pattern.finditer(content):
        prefix = group.group("prefix").strip("/")
        body = group.group("body")

        for route in route_pattern.finditer(body):
            method = route.group("method").lower()
            uri = route.group("uri").strip("/")
            full_path = f"/{prefix}" if not uri else f"/{prefix}/{uri}"
            full_path = normalize_path(full_path)
            results.append((method, full_path))

    return results


def normalize_excludes(values: List[str]) -> Tuple[Set[str], Set[Tuple[str, str]]]:
    """
    Supports:
      - "/cms/api/links"              => exclude entire path
      - "post /cms/api/links"         => exclude one method + path
      - "/cms/api/links#post"         => exclude one method + path
    """
    path_excludes: Set[str] = set()
    op_excludes: Set[Tuple[str, str]] = set()

    for raw in values:
        value = raw.strip()
        if not value:
            continue

        if "#" in value:
            path, method = value.split("#", 1)
            method = method.strip().lower()
            path = normalize_path(path)
            if method in HTTP_METHODS and path:
                op_excludes.add((method, path))
            continue

        m = re.match(r"^(get|post|put|patch|delete)\s+(.+)$", value, re.IGNORECASE)
        if m:
            method = m.group(1).lower()
            path = normalize_path(m.group(2))
            op_excludes.add((method, path))
            continue

        path_excludes.add(normalize_path(value))

    return path_excludes, op_excludes


def module_tag(path: str) -> str:
    seg = path.split("/")[3] if len(path.split("/")) > 3 else "cms"
    title = seg.replace("-", " ").title()
    if title.endswith("S"):
        title = title[:-1] + "s"
    return f"CMS — {title}"


def infer_id_parameter(path: str) -> List[Dict]:
    if "{id}" in path:
        return [
            {
                "name": "id",
                "in": "path",
                "required": True,
                "schema": {"type": "integer"},
            }
        ]
    return []


def method_template(method: str, path: str) -> Dict:
    is_collection = "{id}" not in path
    noun = path.split("/")[3] if len(path.split("/")) > 3 else "resource"
    summary_noun = noun.replace("-", " ")

    if method == "get" and is_collection:
        summary = f"List {summary_noun}"
    elif method == "get":
        summary = f"Get {summary_noun.rstrip('s')}"
    elif method == "post":
        summary = f"Create {summary_noun.rstrip('s')}"
    elif method in {"put", "patch"}:
        summary = f"Update {summary_noun.rstrip('s')}"
    else:
        summary = f"Delete {summary_noun.rstrip('s')}"

    operation: Dict = {
        "tags": [module_tag(path)],
        "summary": summary,
        "responses": {},
    }

    params = infer_id_parameter(path)
    if params:
        operation["parameters"] = params

    if method == "get" and is_collection:
        operation["parameters"] = operation.get("parameters", []) + [
            {
                "name": "per_page",
                "in": "query",
                "schema": {"type": "integer", "minimum": 1, "maximum": 100, "default": 15},
            }
        ]
        operation["responses"]["200"] = {"description": "Success"}
    elif method == "get":
        operation["responses"]["200"] = {"description": "Success"}
        operation["responses"]["404"] = {"$ref": "#/components/responses/NotFound"}
    elif method in {"post", "put", "patch"}:
        operation["requestBody"] = {
            "required": True,
            "content": {"application/json": {"schema": {"type": "object", "additionalProperties": True}}},
        }
        operation["responses"]["200" if method != "post" else "201"] = {"description": "Success"}
        operation["responses"]["422"] = {"$ref": "#/components/responses/ValidationError"}
    else:
        operation["responses"]["200"] = {"description": "Deleted"}

    return operation


def main() -> int:
    parser = argparse.ArgumentParser(description="Sync missing CMS APIs to OpenAPI JSON.")
    parser.add_argument("--routes", default=str(ROUTES_FILE), help="Path to CMS api.php")
    parser.add_argument("--openapi", default=str(OPENAPI_FILE), help="Path to openapi.json")
    parser.add_argument("--exclude", action="append", default=[], help="Exclude path or operation")
    parser.add_argument("--dry-run", action="store_true", help="Print changes without writing file")
    args = parser.parse_args()

    routes_path = Path(args.routes)
    openapi_path = Path(args.openapi)

    routes_content = routes_path.read_text(encoding="utf-8")
    route_entries = parse_route_groups(routes_content)

    openapi = json.loads(openapi_path.read_text(encoding="utf-8"))
    paths = openapi.setdefault("paths", {})

    path_excludes, op_excludes = normalize_excludes(args.exclude)

    # Build normalized lookup for existing paths to prevent duplicates
    normalized_existing_paths: Dict[str, str] = {}
    for existing_path in list(paths.keys()):
        normalized_existing_paths[normalize_path(existing_path)] = existing_path

    added = []
    for method, path in route_entries:
        method = method.lower()
        path = normalize_path(path)

        if path in path_excludes:
            continue
        if (method, path) in op_excludes:
            continue

        real_path_key = normalized_existing_paths.get(path, path)
        path_item = paths.setdefault(real_path_key, {})
        existing_methods = {k.lower() for k in path_item.keys()}
        if method in existing_methods:
            continue

        path_item[method] = method_template(method, path)
        added.append(f"{method.upper()} {path}")
        normalized_existing_paths[path] = real_path_key

    if args.dry_run:
        print("Dry run. Would add:")
        for line in added:
            print(f"  - {line}")
        print(f"Total: {len(added)}")
        return 0

    openapi_path.write_text(json.dumps(openapi, indent=2, ensure_ascii=False) + "\n", encoding="utf-8")
    print(f"Added {len(added)} operation(s) to {openapi_path}")
    for line in added:
        print(f"  - {line}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

