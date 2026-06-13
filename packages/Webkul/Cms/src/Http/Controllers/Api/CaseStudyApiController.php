<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCaseStudyPayload;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Http\Requests\CaseStudyRequest;
use Webkul\Cms\Repositories\CaseStudyRepository;

class CaseStudyApiController extends Controller
{
    use InteractsWithCompanyDomain;
    use InteractsWithCaseStudyPayload;

    public function __construct(protected CaseStudyRepository $caseStudyRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);
        $companyId = $request->input('company_id');
        $categoryId = $request->input('category_id');

        $query = $this->caseStudyRepository->getModel()
            ->newQuery()
            ->with(['translations', 'category', 'media'])
            ->orderBy('order')
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        } elseif ($companyId !== null && $companyId !== '') {
            $query->where('company_id', (int) $companyId);
        }

        if ($categoryId !== null && $categoryId !== '') {
            $query->where('cms_case_study_category_id', (int) $categoryId);
        }

        return response()->json($query->paginate($perPage));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $caseStudy = $this->caseStudyRepository->findOrFail($id);

        $caseStudy->loadMissing('translations', 'category', 'media');

        return response()->json($caseStudy);
    }

	public function showBySlug(Request $request, string $slug): JsonResponse
	{
		$resolvedCompanyId = $this->resolvedCompanyId($request);
		if ($request->header('Domain') && ! $resolvedCompanyId) {
			return $this->invalidDomainResponse();
		}
		
		$caseStudy = $this->caseStudyRepository->findBySlug($slug);
	
		$caseStudy->loadMissing('translations', 'category', 'media');

		return response()->json($caseStudy);
	}

    public function getByCategoryId(Request $request, int $categoryId): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $query = $this->caseStudyRepository->getModel()
            ->newQuery()
            ->with(['translations', 'category', 'media'])
            ->where('cms_case_study_category_id', $categoryId)
            ->orderBy('order')
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        }

        return response()->json($query->paginate($perPage));
    }

    public function store(CaseStudyRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.case-studies.create.before');

        $data = $this->sanitizePayload($request->validated());

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $caseStudy = $this->caseStudyRepository->create($data);

        Event::dispatch('cms.case-studies.create.after', $caseStudy);

        $caseStudy->loadMissing('translations', 'category', 'media');

        return response()->json($caseStudy, 201);
    }

    public function update(CaseStudyRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.case-studies.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $caseStudy = $this->caseStudyRepository->update($data, $id);

        Event::dispatch('cms.case-studies.update.after', $caseStudy);

        $caseStudy->loadMissing('translations', 'category', 'media');

        return response()->json($caseStudy);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $caseStudy = $this->caseStudyRepository->findOrFail($id);

        Event::dispatch('cms.case-studies.delete.before', $id);

        $caseStudy?->delete();

        Event::dispatch('cms.case-studies.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.case-studies.messages.delete-success'),
        ]);
    }
}
