import re
from pathlib import Path


def clean_type(typ: str) -> str:
    typ = re.sub(r"\s+CHARACTER SET.*", "", typ, flags=re.I)
    typ = re.sub(r"\s+COLLATE.*", "", typ, flags=re.I)
    typ = typ.replace("UNSIGNED", "").strip()
    typ = re.sub(r"\s+DEFAULT\s+.*", "", typ, flags=re.I)
    typ = re.sub(r"\s+NOT NULL", "", typ, flags=re.I)
    typ = re.sub(r"\s+NULL", "", typ, flags=re.I)
    typ = re.sub(r"\s+CHECK\s*\(.*\)", "", typ, flags=re.I)
    return typ.strip()


def main() -> None:
    root = Path(__file__).resolve().parents[1]
    sql_path = root / "krayin.sql"
    out_path = root / "docs" / "krayin-erd.md"
    out_path.parent.mkdir(parents=True, exist_ok=True)

    sql = sql_path.read_text(encoding="utf-8", errors="ignore")

    create_pat = re.compile(
        r"CREATE TABLE\s+`(?P<name>[^`]+)`\s+\((?P<body>.*?)\)\s+ENGINE=",
        re.S | re.I,
    )
    col_pat = re.compile(r"^\s*`(?P<col>[^`]+)`\s+(?P<type>[^,]+)", re.M)
    fk_pat = re.compile(
        r"ALTER TABLE\s+`(?P<table>[^`]+)`\s+ADD CONSTRAINT\s+`[^`]+`\s+FOREIGN KEY\s+\(`(?P<col>[^`]+)`\)\s+REFERENCES\s+`(?P<ref_table>[^`]+)`\s+\(`(?P<ref_col>[^`]+)`\)",
        re.I,
    )

    tables: dict[str, list[tuple[str, str]]] = {}
    for m in create_pat.finditer(sql):
        name = m.group("name")
        body = m.group("body")
        cols: list[tuple[str, str]] = []
        for cm in col_pat.finditer(body):
            cols.append((cm.group("col"), cm.group("type").strip()))
        tables[name] = cols

    fks = sorted(
        {
            (m.group("table"), m.group("col"), m.group("ref_table"), m.group("ref_col"))
            for m in fk_pat.finditer(sql)
        }
    )

    # Keep diagram readable: show key-ish columns only.
    key_name_re = re.compile(r"(^id$|_id$|_at$|^code$|^slug$|^email$|^name$)", re.I)

    lines: list[str] = ["```mermaid", "erDiagram"]

    for t in sorted(tables.keys()):
        cols = tables[t]
        show = [c for c in cols if key_name_re.search(c[0])][:14]
        lines.append(f"  {t} {{")
        for col, typ in show:
            lines.append(f"    {clean_type(typ)} {col}")
        lines.append("  }")

    for table, col, rt, rc in fks:
        # Parent (referenced) to child (referencing) is 1-to-many
        lines.append(f"  {rt} ||--o{{ {table} : {col}")

    lines.append("```")

    out_path.write_text("\n".join(lines) + "\n", encoding="utf-8")
    print(f"Wrote {out_path} (tables={len(tables)}, foreign_keys={len(fks)})")


if __name__ == "__main__":
    main()

