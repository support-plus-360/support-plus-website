<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCmsCompanyTabs;
use Webkul\Cms\Concerns\InteractsWithPagePayload;
use Webkul\Cms\DataGrids\PageDataGrid;
use Webkul\Cms\Http\Requests\PageRequest;
use Webkul\Cms\Repositories\PageRepository;
use Webkul\Company\Models\Company;

class PageController extends Controller
{
    use InteractsWithCmsCompanyTabs, InteractsWithPagePayload;

    public function __construct(protected PageRepository $pageRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(PageDataGrid::class)->process();
        }

        return view('cms::pages.index', $this->cmsCompanyTabs());
    }

    public function create(): View
    {
        $locales = $this->supportedLocales();

        $companies = Company::select('id', 'name')->get();
        return view('cms::pages.create', compact('locales', 'companies'));
    }

    public function store(PageRequest $request): RedirectResponse
    {
        Event::dispatch('cms.pages.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        $page = $this->pageRepository->create($data);

        Event::dispatch('cms.pages.create.after', $page);

        session()->flash('success', trans('cms::app.pages.messages.create-success'));

        return redirect()->route('admin.cms.pages.index');
    }

    public function edit(int $id): View
    {
        $page = $this->pageRepository->findOrFail($id);

        $page->loadMissing('translations');

        $locales = $this->supportedLocales();

        $companies = Company::select('id', 'name')->get();
        return view('cms::pages.edit', compact('page', 'locales', 'companies'));
    }

    public function update(PageRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.pages.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $page = $this->pageRepository->update($data, $id);

        Event::dispatch('cms.pages.update.after', $page);

        session()->flash('success', trans('cms::app.pages.messages.update-success'));

        return redirect()->route('admin.cms.pages.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $page = $this->pageRepository->findOrFail($id);

        Event::dispatch('cms.pages.delete.before', $id);

        $page?->delete();

        Event::dispatch('cms.pages.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.pages.messages.delete-success'),
        ]);
    }

public function restore(int $id): JsonResponse
{
    $page = $this->pageRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.pages.restore.before', $id);

    $page?->restore();

    Event::dispatch('cms.pages.restore.after', $id);

    return response()->json([
        'message' => trans('cms::app.pages.messages.restore-success'),
    ]);
}

// force delete company
public function forceDelete(int $id): JsonResponse
{
    $page = $this->pageRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.pages.forceDelete.before', $id);

    $page?->forceDelete();


    Event::dispatch('cms.pages.forceDelete.after', $id);

    return response()->json([
        'message' => trans('cms::app.pages.messages.forceDelete-success'),
    ]);
}

}

