<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCaseStudyCategoryPayload;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Http\Requests\CaseStudyCategoryRequest;
use Webkul\Cms\Repositories\CaseStudyCategoryRepository;

class CaseStudyCategoryApiController extends Controller
{
    use InteractsWithCompanyDomain;
    use InteractsWithCaseStudyCategoryPayload;

    public function __construct(protected CaseStudyCategoryRepository $caseStudyCategoryRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);
        $companyId = $request->input('company_id');

        $query = $this->caseStudyCategoryRepository->getModel()
            ->newQuery()
            ->orderByDesc('id');

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

        $caseStudyCategory = $this->caseStudyCategoryRepository->findOrFail($id);

        return response()->json($caseStudyCategory);
    }

    public function store(CaseStudyCategoryRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.case-study-categories.create.before');

        $data = $this->sanitizePayload($request->validated());

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $caseStudyCategory = $this->caseStudyCategoryRepository->create($data);

        Event::dispatch('cms.case-study-categories.create.after', $caseStudyCategory);

        return response()->json($caseStudyCategory, 201);
    }

    public function update(CaseStudyCategoryRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.case-study-categories.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $caseStudyCategory = $this->caseStudyCategoryRepository->update($data, $id);

        Event::dispatch('cms.case-study-categories.update.after', $caseStudyCategory);

        return response()->json($caseStudyCategory);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $caseStudyCategory = $this->caseStudyCategoryRepository->findOrFail($id);

        Event::dispatch('cms.case-study-categories.delete.before', $id);

        $caseStudyCategory?->delete();

        Event::dispatch('cms.case-study-categories.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.case-study-categories.messages.delete-success'),
        ]);
    }
}
