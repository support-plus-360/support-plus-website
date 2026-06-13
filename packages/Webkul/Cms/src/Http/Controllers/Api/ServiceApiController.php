<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithServicePayload;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Http\Requests\ServiceRequest;
use Webkul\Cms\Repositories\ServiceRepository;

class ServiceApiController extends Controller
{
    use InteractsWithCompanyDomain;
    use InteractsWithServicePayload;

    public function __construct(protected ServiceRepository $serviceRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);
        $companyId = $request->input('company_id');
        $serviceTypeId = $request->input('service_type_id');

        $query = $this->serviceRepository->getModel()
            ->newQuery()
            ->with(['translations', 'serviceType', 'media'])
            ->orderBy('order')
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        } elseif ($companyId !== null && $companyId !== '') {
            $query->where('company_id', (int) $companyId);
        }

        if ($serviceTypeId !== null && $serviceTypeId !== '') {
            $query->where('cms_service_type_id', (int) $serviceTypeId);
        }

        return response()->json($query->paginate($perPage));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $service = $this->serviceRepository->findOrFail($id);

        $service->loadMissing('translations', 'serviceType', 'media');

        return response()->json($service);
    }

	// show service by slug
	public function showBySlug(Request $request, string $slug): JsonResponse
	{
		$resolvedCompanyId = $this->resolvedCompanyId($request);
		if ($request->header('Domain') && ! $resolvedCompanyId) {
			return $this->invalidDomainResponse();
		}
		$service = $this->serviceRepository->findBySlug($slug);
		$service->loadMissing('translations', 'serviceType', 'media');
		return response()->json($service);
	}

    public function getByServiceTypeId(Request $request, int $serviceTypeId): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $query = $this->serviceRepository->getModel()
            ->newQuery()
            ->with(['translations', 'serviceType', 'media'])
            ->where('cms_service_type_id', $serviceTypeId)
            ->orderBy('order')
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        }

        return response()->json($query->paginate($perPage));
    }

    public function store(ServiceRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.services.create.before');

        $data = $this->sanitizePayload($request->validated());

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $service = $this->serviceRepository->create($data);

        Event::dispatch('cms.services.create.after', $service);

        $service->loadMissing('translations', 'serviceType', 'media');

        return response()->json($service, 201);
    }

    public function update(ServiceRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.services.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $service = $this->serviceRepository->update($data, $id);

        Event::dispatch('cms.services.update.after', $service);

        $service->loadMissing('translations', 'serviceType', 'media');

        return response()->json($service);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $service = $this->serviceRepository->findOrFail($id);

        Event::dispatch('cms.services.delete.before', $id);

        $service?->delete();

        Event::dispatch('cms.services.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.services.messages.delete-success'),
        ]);
    }
}
