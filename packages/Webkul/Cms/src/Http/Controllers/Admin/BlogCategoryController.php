<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCmsCompanyTabs;
use Webkul\Cms\Concerns\InteractsWithBlogCategoryPayload;
use Webkul\Cms\Concerns\InteractsWithCmsMedia;
use Webkul\Cms\DataGrids\BlogCategoryDataGrid;
use Webkul\Cms\Http\Requests\BlogCategoryRequest;
use Webkul\Cms\Repositories\BlogCategoryRepository;
use Webkul\Company\Models\Company;
use Webkul\Cms\Models\BlogCategory;

class BlogCategoryController extends Controller
{
    use InteractsWithBlogCategoryPayload, InteractsWithCmsCompanyTabs, InteractsWithCmsMedia;

    public function __construct(protected BlogCategoryRepository $blogCategoryRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(BlogCategoryDataGrid::class)->process();
        }

        return view('cms::blog-categories.index', $this->cmsCompanyTabs());
    }

    public function create(): View
    {
        $locales = $this->supportedLocales();

        $companies = Company::select('id', 'name')->get();
        return view('cms::blog-categories.create', compact('locales', 'companies'));
    }

    public function store(BlogCategoryRequest $request): RedirectResponse
    {
        Event::dispatch('cms.blog-categories.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        $blogCategory = $this->blogCategoryRepository->create($data);
        $this->syncMediaFromRequest($request, $blogCategory);

        Event::dispatch('cms.blog-categories.create.after', $blogCategory);

        session()->flash('success', trans('cms::app.blog-categories.messages.create-success'));

        return redirect()->route('admin.cms.blog-categories.index');
    }

    public function edit(int $id): View
    {
            $blogCategory = $this->blogCategoryRepository->findOrFail($id);

        $blogCategory->loadMissing('translations');

        $locales = $this->supportedLocales();

        $companies = Company::select('id', 'name')->get();
        return view('cms::blog-categories.edit', compact('blogCategory', 'locales', 'companies'));
    }

    public function update(BlogCategoryRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.blog-categories.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $blogCategory = $this->blogCategoryRepository->update($data, $id);
        $this->syncMediaFromRequest($request, $blogCategory);

        Event::dispatch('cms.blog-categories.update.after', $blogCategory);

        session()->flash('success', trans('cms::app.blog-categories.messages.update-success'));

            return redirect()->route('admin.cms.blog-categories.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $blogCategory = $this->blogCategoryRepository->findOrFail($id);

        Event::dispatch('cms.blog-categories.delete.before', $id);

        $blogCategory?->delete();

        Event::dispatch('cms.blog-categories.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.blog-categories.messages.delete-success'),
        ]);
    }

public function restore(int $id): JsonResponse
{
    $blogCategory = $this->blogCategoryRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.blog-categories.restore.before', $id);

    $blogCategory?->restore();

    Event::dispatch('cms.blog-categories.restore.after', $id);

    return response()->json([
        'message' => trans('cms::app.blog-categories.messages.restore-success'),
    ]);
}

// force delete company
public function forceDelete(int $id): JsonResponse
{
    $blogCategory = $this->blogCategoryRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.blog-categories.forceDelete.before', $id);

    $blogCategory?->clearMediaCollection('main_media');
    $blogCategory?->clearMediaCollection('gallery');
    $blogCategory?->forceDelete();


    Event::dispatch('cms.blog-categories.forceDelete.after', $id);

    return response()->json([
        'message' => trans('cms::app.blog-categories.messages.forceDelete-success'),
    ]);


}
}