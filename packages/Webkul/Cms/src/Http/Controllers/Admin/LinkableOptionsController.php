<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Models\Item;
use Webkul\Cms\Models\Page;
use Webkul\Cms\Models\Section;

class LinkableOptionsController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'linkable_type' => ['required', 'string', Rule::in([Page::class, Section::class, Item::class])],
            'company_id'    => ['nullable', 'integer', 'exists:companies,id'],
        ]);

        $type = (string) $validated['linkable_type'];
        $companyId = isset($validated['company_id']) ? (int) $validated['company_id'] : null;

        $rows = match ($type) {
            Page::class    => $this->pageRows(),
            Section::class => $this->sectionRows(),
            Item::class    => $this->itemRows(),
            default        => [],
        };

        if ($companyId !== null) {
            $rows = array_values(array_filter(
                $rows,
                static fn (array $r): bool => isset($r['company_id']) && (int) $r['company_id'] === $companyId
            ));
        }

        return response()->json(['data' => $rows]);
    }

    /**
     * @return list<array{id: int, name: string, company_id: int|null}>
     */
    private function pageRows(): array
    {
        return Page::query()
            ->orderBy('name')
            ->get(['id', 'name', 'company_id'])
            ->map(function (Page $p): array {
                $cid = $p->company_id;

                return [
                    'id'         => (int) $p->id,
                    'company_id' => $cid !== null ? (int) $cid : null,
                    'name'       => (string) $p->name,
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return list<array{id: int, name: string, company_id: int|null}>
     */
    private function sectionRows(): array
    {
        return Section::query()
            ->with(['page' => function ($q): void {
                $q->select('id', 'company_id');
            }])
            ->orderBy('name')
            ->get(['id', 'name', 'company_id', 'page_id'])
            ->map(function (Section $s): array {
                $cid = $s->company_id ?? $s->page?->company_id;

                return [
                    'id'         => (int) $s->id,
                    'company_id' => $cid !== null ? (int) $cid : null,
                    'name'       => (string) $s->name,
                ];
            })
            ->values()
            ->all();
    }

    /**
     * @return list<array{id: int, name: string, company_id: int|null}>
     */
    private function itemRows(): array
    {
        return Item::query()
            ->with([
                'section' => function ($q): void {
                    $q->select('id', 'name', 'company_id', 'page_id');
                },
                'section.page' => function ($q): void {
                    $q->select('id', 'company_id');
                },
                'translations' => function ($q): void {
                    $q->whereIn('locale', ['en', 'ar']);
                },
            ])
            ->orderByDesc('id')
            ->get()
            ->map(function (Item $item): array {
                $label = (string) ($item->translate('en', false)?->title
                    ?? $item->translate('ar', false)?->title
                    ?? (string) $item->id);

                $cid = $item->company_id
                    ?? $item->section?->company_id
                    ?? $item->section?->page?->company_id;

                return [
                    'id'         => (int) $item->id,
                    'company_id' => $cid !== null ? (int) $cid : null,
                    'name'       => $label,
                ];
            })
            ->values()
            ->all();
    }
}
