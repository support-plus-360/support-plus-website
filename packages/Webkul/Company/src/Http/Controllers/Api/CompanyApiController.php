<?php

namespace Webkul\Company\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Company\Concerns\InteractsWithCompanyPayload;
use Webkul\Company\Http\Requests\CompanyRequest;
use Webkul\Company\Repositories\CompanyRepository;

class CompanyApiController extends Controller
{
    use InteractsWithCompanyPayload;

    public function __construct(protected CompanyRepository $companyRepository) {}

    public function index(Request $request): JsonResponse
    {

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $query = $this->companyRepository->getModel()
            ->newQuery()
            ->with('translations')
            ->orderByDesc('id');

        return response()->json($query->paginate($perPage));
    }

    public function show(int $id): JsonResponse
    {

        $company = $this->companyRepository->findOrFail($id);
        $company->loadMissing('translations');

        return response()->json($company);
    }

    public function store(CompanyRequest $request): JsonResponse
    {

        Event::dispatch('company.companies.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        $company = $this->companyRepository->create($data);

        Event::dispatch('company.companies.create.after', $company);

        $company->loadMissing('translations');

        return response()->json($company, 201);
    }

    public function update(CompanyRequest $request, int $id): JsonResponse
    {

        Event::dispatch('company.companies.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $company = $this->companyRepository->update($data, $id);

        Event::dispatch('company.companies.update.after', $company);

        $company->loadMissing('translations');

        return response()->json($company);
    }

    public function destroy(int $id): JsonResponse
    {

        $company = $this->companyRepository->findOrFail($id);

        Event::dispatch('company.companies.delete.before', $id);

        $company?->delete();

        Event::dispatch('company.companies.delete.after', $id);

        return response()->json([
            'message' => trans('company::app.companies.messages.delete-success'),
        ]);
    }
}
