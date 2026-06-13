<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithServiceTypePayload;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Http\Requests\ServiceTypeRequest;
use Webkul\Cms\Repositories\ServiceTypeRepository;

class ServiceTypeApiController extends Controller
{
    use InteractsWithCompanyDomain;
    use InteractsWithServiceTypePayload;

    public function __construct(protected ServiceTypeRepository $serviceTypeRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);
        $companyId = $request->input('company_id');

        $query = $this->serviceTypeRepository->getModel()
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

        $serviceType = $this->serviceTypeRepository->findOrFail($id);

        return response()->json($serviceType);
    }

    public function store(ServiceTypeRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.service-types.create.before');

        $data = $this->sanitizePayload($request->validated());

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $serviceType = $this->serviceTypeRepository->create($data);

        Event::dispatch('cms.service-types.create.after', $serviceType);

        return response()->json($serviceType, 201);
    }

    public function update(ServiceTypeRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.service-types.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $serviceType = $this->serviceTypeRepository->update($data, $id);

        Event::dispatch('cms.service-types.update.after', $serviceType);

        return response()->json($serviceType);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $serviceType = $this->serviceTypeRepository->findOrFail($id);

        Event::dispatch('cms.service-types.delete.before', $id);

        $serviceType?->delete();

        Event::dispatch('cms.service-types.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.service-types.messages.delete-success'),
        ]);
    }
}
