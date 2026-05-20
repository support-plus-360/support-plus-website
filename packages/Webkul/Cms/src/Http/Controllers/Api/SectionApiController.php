<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCmsMedia;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Concerns\InteractsWithSectionPayload;
use Webkul\Cms\Http\Requests\SectionRequest;
use Webkul\Cms\Repositories\SectionRepository;

class SectionApiController extends Controller
{
    use InteractsWithCmsMedia;
    use InteractsWithCompanyDomain;
    use InteractsWithSectionPayload;

    public function __construct(protected SectionRepository $sectionRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $query = $this->sectionRepository->getModel()
            ->newQuery()
            ->with(['translations', 'media'])
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        }

        return response()->json($query->paginate($perPage));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $section = $this->sectionRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $section->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $section->loadMissing(['translations', 'media']);

        return response()->json($section);
    }

    // get sections by page id
    public function getSectionsByPageId(Request $request, int $pageId): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $sections = $this->sectionRepository->getModel()
            ->newQuery()
            ->where('page_id', $pageId)
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $sections->where('company_id', $resolvedCompanyId);
        }

        return response()->json($sections->paginate($perPage));
    }

    public function store(SectionRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.sections.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? null)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $section = $this->sectionRepository->create($data);
        $this->syncMediaFromRequest($request, $section);

        Event::dispatch('cms.sections.create.after', $section);

        $section->loadMissing(['translations', 'media']);

        return response()->json($section, 201);
    }

    public function update(SectionRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.sections.update.before', $id);

        $section = $this->sectionRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $section->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $data = $this->sanitizePayload($request->validated());

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? $section->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $section = $this->sectionRepository->update($data, $id);
        $this->syncMediaFromRequest($request, $section);

        Event::dispatch('cms.sections.update.after', $section);

        $section->loadMissing(['translations', 'media']);

        return response()->json($section);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $section = $this->sectionRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $section->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        Event::dispatch('cms.sections.delete.before', $id);

        $section?->delete();

        Event::dispatch('cms.sections.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.sections.messages.delete-success'),
        ]);
    }
}
