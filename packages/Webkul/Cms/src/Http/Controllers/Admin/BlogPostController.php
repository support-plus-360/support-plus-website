<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithBlogPostPayload;
use Webkul\Cms\DataGrids\BlogPostDataGrid;
use Webkul\Cms\Http\Requests\BlogPostRequest;
use Webkul\Cms\Repositories\BlogPostRepository;
use Webkul\Company\Models\Company;
use Webkul\Cms\Models\BlogCategory;
use Webkul\Cms\Models\BlogPost;

class BlogPostController extends Controller
{
    use InteractsWithBlogPostPayload;

    public function __construct(protected BlogPostRepository $blogPostRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(BlogPostDataGrid::class)->process();
        }

        return view('cms::blog-posts.index');
    }

    public function create(): View
    {
        $locales = $this->supportedLocales();

        $companies = Company::select('id', 'name')->get();
        $blogCategories = $this->blogCategoriesForForm();

        return view('cms::blog-posts.create', compact('locales', 'companies', 'blogCategories'));
    }

    public function store(BlogPostRequest $request): RedirectResponse
    {
        Event::dispatch('cms.blog-posts.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        $blogPost = $this->blogPostRepository->create($data);

        Event::dispatch('cms.blog-posts.create.after', $blogPost);

        session()->flash('success', trans('cms::app.blog-posts.messages.create-success'));

        return redirect()->route('admin.cms.blog-posts.index');
    }

    public function edit(int $id): View
    {
            $blogPost = $this->blogPostRepository->findOrFail($id);

        $blogPost->loadMissing('translations', 'blogCategories');

        $locales = $this->supportedLocales();

        $companies = Company::select('id', 'name')->get();
        $blogCategories = $this->blogCategoriesForForm();

        return view('cms::blog-posts.edit', compact('blogPost', 'locales', 'companies', 'blogCategories'));
    }

    public function update(BlogPostRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.blog-posts.update.before', $id);

        $validated = $request->validated();
        $categoryIds = $validated['cms_blog_category_ids'];
        $data = $this->sanitizePayload(Arr::except($validated, ['cms_blog_category_ids']));

        $blogPost = $this->blogPostRepository->update($data, $id);
        $blogPost->blogCategories()->sync($categoryIds);

        Event::dispatch('cms.blog-posts.update.after', $blogPost);

        session()->flash('success', trans('cms::app.blog-posts.messages.update-success'));

            return redirect()->route('admin.cms.blog-posts.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $blogPost = $this->blogPostRepository->findOrFail($id);

        Event::dispatch('cms.blog-posts.delete.before', $id);

        $blogPost?->delete();

        Event::dispatch('cms.blog-posts.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.blog-posts.messages.delete-success'),
        ]);
    }

public function restore(int $id): JsonResponse
{
    $blogPost = $this->blogPostRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.blog-posts.restore.before', $id);

    $blogPost?->restore();

    Event::dispatch('cms.blog-posts.restore.after', $id);

    return response()->json([
        'message' => trans('cms::app.blog-posts.messages.restore-success'),
    ]);
}

// force delete company
public function forceDelete(int $id): JsonResponse
{
    $blogPost = $this->blogPostRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.blog-posts.forceDelete.before', $id);

    $blogPost?->forceDelete();


    Event::dispatch('cms.blog-posts.forceDelete.after', $id);

    return response()->json([
        'message' => trans('cms::app.blog-posts.messages.forceDelete-success'),
    ]);
}

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, BlogCategory>
     */
    private function blogCategoriesForForm()
    {
        return BlogCategory::query()
            ->orderBy('order')
            ->orderBy('id')
            ->get(['id', 'name', 'slug']);
    }
}
