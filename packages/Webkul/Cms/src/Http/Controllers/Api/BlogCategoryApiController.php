<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Concerns\InteractsWithBlogCategoryPayload;
use Webkul\Cms\Http\Requests\BlogCategoryRequest;
use Webkul\Cms\Repositories\BlogCategoryRepository;

class BlogCategoryApiController extends Controller
{
    use InteractsWithCompanyDomain;
    use InteractsWithBlogCategoryPayload;

    public function __construct(protected BlogCategoryRepository $blogCategoryRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $companyId = $request->input('company_id');

        $query = $this->blogCategoryRepository->getModel()
            ->newQuery()
            ->with('translations')
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

        $blogCategory = $this->blogCategoryRepository->findOrFail($id);

        if ($this->isCompanyMismatch($resolvedCompanyId, $blogCategory->company_id)) {
            return $this->companyMismatchResponse();
        }

        $blogCategory->loadMissing('translations');

        return response()->json($blogCategory);
    }

    public function store(BlogCategoryRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.blog-categories.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? null)) {
            return $this->companyMismatchResponse();
        }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $blogCategory = $this->blogCategoryRepository->create($data);

        Event::dispatch('cms.blog-categories.create.after', $blogCategory);

        $blogCategory->loadMissing('translations');

        return response()->json($blogCategory, 201);
    }

    public function update(BlogCategoryRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.blog-categories.update.before', $id);

        $blogCategory = $this->blogCategoryRepository->findOrFail($id);

        if ($this->isCompanyMismatch($resolvedCompanyId, $blogCategory->company_id)) {
            return $this->companyMismatchResponse();
        }

        $data = $this->sanitizePayload($request->validated());

        if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? $blogCategory->company_id)) {
            return $this->companyMismatchResponse();
        }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $blogCategory = $this->blogCategoryRepository->update($data, $id);

        Event::dispatch('cms.blog-categories.update.after', $blogCategory);

        $blogCategory->loadMissing('translations');

        return response()->json($blogCategory);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $blogCategory = $this->blogCategoryRepository->findOrFail($id);

        if ($this->isCompanyMismatch($resolvedCompanyId, $blogCategory->company_id)) {
            return $this->companyMismatchResponse();
        }

        Event::dispatch('cms.blog-categories.delete.before', $id);

        $blogCategory?->delete();

        Event::dispatch('cms.blog-categories.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.blog-categories.messages.delete-success'),
        ]);
    }
}
