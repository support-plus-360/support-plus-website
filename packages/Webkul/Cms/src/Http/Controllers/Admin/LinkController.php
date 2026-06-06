<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCmsCompanyTabs;
use Webkul\Cms\Concerns\InteractsWithLinkPayload;
use Webkul\Cms\DataGrids\LinkDataGrid;
use Webkul\Cms\Http\Requests\LinkRequest;
use Webkul\Cms\Models\Item;
use Webkul\Cms\Models\Link;
use Webkul\Cms\Models\Page;
use Webkul\Cms\Models\Section;
use Webkul\Cms\Repositories\LinkRepository;
use Webkul\Company\Models\Company;

class LinkController extends Controller
{
    use InteractsWithCmsCompanyTabs, InteractsWithLinkPayload;

    public function __construct(protected LinkRepository $linkRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(LinkDataGrid::class)->process();
        }

        return view('cms::links.index', $this->cmsCompanyTabs());
    }

    public function create(): View
    {
        $locales = $this->supportedLocales();

        $companies = Company::query()->select('id', 'name')->get();

        $linkableOptionsUrl = route('admin.cms.api.linkable-options');

        return view('cms::links.create', compact('locales', 'companies', 'linkableOptionsUrl'));
    }

    public function store(LinkRequest $request): RedirectResponse
    {
        Event::dispatch('cms.links.create.before');

        $data = $this->sanitizePayload($request->validated(), false);

        $link = $this->linkRepository->create($data);

        Event::dispatch('cms.links.create.after', $link);

        session()->flash('success', trans('cms::app.links.messages.create-success'));

        return redirect()->route('admin.cms.links.index');
    }

    public function edit(int $id): View
    {
        $link = $this->linkRepository->findOrFail($id);

        $link->loadMissing(['translations', 'linkable']);

        $locales = $this->supportedLocales();

        $companies = Company::query()->select('id', 'name')->get();

        $linkableOptionsUrl = route('admin.cms.api.linkable-options');

        $currentLinkable = $this->resolveCurrentLinkable($link);

        return view('cms::links.edit', compact('link', 'locales', 'companies', 'linkableOptionsUrl', 'currentLinkable'));
    }

    public function update(LinkRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.links.update.before', $id);

        $data = $this->sanitizePayload($request->validated(), false);

        $link = $this->linkRepository->update($data, $id);

        Event::dispatch('cms.links.update.after', $link);

        session()->flash('success', trans('cms::app.links.messages.update-success'));

        return redirect()->route('admin.cms.links.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $link = $this->linkRepository->findOrFail($id);

        Event::dispatch('cms.links.delete.before', $id);

        $link?->delete();

        Event::dispatch('cms.links.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.links.messages.delete-success'),
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $link = $this->linkRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.links.restore.before', $id);

        $link?->restore();

        Event::dispatch('cms.links.restore.after', $id);

        return response()->json([
            'message' => trans('cms::app.links.messages.restore-success'),
        ]);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $link = $this->linkRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.links.forceDelete.before', $id);

        $link?->forceDelete();

        Event::dispatch('cms.links.forceDelete.after', $id);

        return response()->json([
            'message' => trans('cms::app.links.messages.forceDelete-success'),
        ]);
    }

    /**
     * @return array{type: string, id: int, name: string}|null
     */
    private function resolveCurrentLinkable(Link $link): ?array
    {
        if (! $link->getKey()) {
            return null;
        }

        $type = (string) $link->getAttribute('linkable_type');
        $rid = (int) $link->getAttribute('linkable_id');
        if ($type === '' || $rid < 1) {
            return null;
        }

        $label = (string) $rid;
        if ($link->linkable) {
            $m = $link->linkable;
            $label = match (true) {
                $m instanceof Page => (string) $m->name,
                $m instanceof Section => (string) $m->name,
                $m instanceof Item => (string) ($m->translate('en', false)?->title
                    ?? $m->translate('ar', false)?->title
                    ?? $rid),
                default => (string) $rid,
            };
        }

        return [
            'type' => $type,
            'id'   => $rid,
            'name' => $label,
        ];
    }
}
