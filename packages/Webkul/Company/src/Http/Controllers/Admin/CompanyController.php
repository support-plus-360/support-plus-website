<?php

namespace Webkul\Company\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Company\Concerns\InteractsWithCompanyPayload;
use Webkul\Company\Http\Requests\CompanyRequest;
use Webkul\Company\Repositories\CompanyRepository;
use Webkul\Company\DataGrids\CompanyDataGrid;

class CompanyController extends Controller
{
    use InteractsWithCompanyPayload;

    public function __construct(protected CompanyRepository $companyRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(CompanyDataGrid::class)->process();
        }

        return view('company::companies.index');
    }

    public function create(): View
    {
        return view('company::companies.create');
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        Event::dispatch('company.create.before');

        $data = $this->sanitizePayload($request->validated());

        $company = $this->companyRepository->create($data);

        Event::dispatch('company.create.after', $company);

        session()->flash('success', trans('company::app.companies.messages.create-success'));

        return redirect()->route('admin.company.index');
    }

    public function edit(int $id): View
    {
        $company = $this->companyRepository->findOrFail($id);

        return view('company::companies.edit', compact('company'));
    }

    public function update(CompanyRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('company.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $company = $this->companyRepository->update($data, $id);

        Event::dispatch('company.update.after', $company);

        session()->flash('success', trans('company::app.companies.messages.update-success'));

        return redirect()->route('admin.company.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $company = $this->companyRepository->findOrFail($id);

        Event::dispatch('company.delete.before', $id);

        $company?->delete();

        Event::dispatch('company.delete.after', $id);

        return response()->json([
            'message' => trans('company::app.companies.messages.delete-success'),
        ]);
    }

public function restore(int $id): JsonResponse
{
    $company = $this->companyRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('company.restore.before', $id);

    $company?->restore();

    Event::dispatch('company.restore.after', $id);

    return response()->json([
        'message' => trans('company::app.companies.messages.restore-success'),
    ]);
}

// force delete company
public function forceDelete(int $id): JsonResponse
{
    $company = $this->companyRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('company.forceDelete.before', $id);

    $company?->forceDelete();


    Event::dispatch('company.forceDelete.after', $id);

    return response()->json([
        'message' => trans('company::app.companies.messages.forceDelete-success'),
    ]);


}  

}




