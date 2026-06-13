<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Concerns\InteractsWithBlogPostPayload;
use Webkul\Cms\Http\Requests\BlogPostRequest;
use Webkul\Cms\Repositories\BlogPostRepository;

class BlogPostApiController extends Controller
{
    use InteractsWithCompanyDomain;
    use InteractsWithBlogPostPayload;

    public function __construct(protected BlogPostRepository $blogPostRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $companyId = $request->input('company_id');

        $query = $this->blogPostRepository->getModel()
            ->newQuery()
            ->with(['translations', 'media'])
            ->orderByDesc('id');

        if ($this->isCompanyMismatch($resolvedCompanyId, $companyId)) {
            return $this->companyMismatchResponse();
        }

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        } elseif ($companyId !== null && $companyId !== '') {
            $query->where('company_id', (int) $companyId);
        }

        return response()->json($query->paginate($perPage));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $blogPost = $this->blogPostRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $blogPost->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $blogPost->loadMissing('translations', 'media');

        return response()->json($blogPost);
    }

    public function showBySlug(Request $request, string $slug): JsonResponse
    {
        $blogPost = $this->blogPostRepository->getModel()
            ->newQuery()
            ->with(['translations', 'media'])
            ->where('slug', $slug)
            ->first();

        if (! $blogPost) {
            return response()->json([
                'message' => 'Blog post not found',
            ], 404);
        }

        $blogPost->loadMissing('translations', 'media');

        return response()->json($blogPost);
    }

    // get blog posts by category id
    public function getBlogPostsByCategoryId(Request $request, int $categoryId): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $blogPosts = $this->blogPostRepository->getModel()
            ->newQuery()
            ->with(['translations', 'media'])
            ->whereHas('blogCategories', function ($query) use ($categoryId) {
                $query->where('cms_blog_categories.id', $categoryId);
            })
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $blogPosts->where('company_id', $resolvedCompanyId);
        }

        return response()->json($blogPosts->paginate($perPage));
    }

    public function store(BlogPostRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.blog-posts.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? null)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $blogPost = $this->blogPostRepository->create($data);

        Event::dispatch('cms.blog-posts.create.after', $blogPost);

        $blogPost->loadMissing('translations', 'media');

        return response()->json($blogPost, 201);
    }

    public function update(BlogPostRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.blog-posts.update.before', $id);

        $blogPost = $this->blogPostRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $blogPost->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $data = $this->sanitizePayload($request->validated());

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? $blogPost->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $blogPost = $this->blogPostRepository->update($data, $id);

        Event::dispatch('cms.blog-posts.update.after', $blogPost);

        $blogPost->loadMissing('translations', 'media');

        return response()->json($blogPost);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $blogPost = $this->blogPostRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $blogPost->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        Event::dispatch('cms.blog-posts.delete.before', $id);

        $blogPost?->delete();

        Event::dispatch('cms.blog-posts.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.blog-posts.messages.delete-success'),
        ]);
    }
}
