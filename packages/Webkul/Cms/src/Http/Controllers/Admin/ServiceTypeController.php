<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithServiceTypePayload;
use Webkul\Cms\Concerns\InteractsWithCmsCompanyTabs;
use Webkul\Cms\DataGrids\ServiceTypeDataGrid;
use Webkul\Cms\Http\Requests\ServiceTypeRequest;
use Webkul\Cms\Repositories\ServiceTypeRepository;
use Webkul\Company\Models\Company;

class ServiceTypeController extends Controller
{
    use InteractsWithServiceTypePayload, InteractsWithCmsCompanyTabs;

    public function __construct(protected ServiceTypeRepository $serviceTypeRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(ServiceTypeDataGrid::class)->process();
        }

        return view('cms::service-types.index', $this->cmsCompanyTabs());
    }

    public function create(): View
    {
        $companies = Company::select('id', 'name')->get();

        return view('cms::service-types.create', compact('companies'));
    }

    public function store(ServiceTypeRequest $request): RedirectResponse
    {
        Event::dispatch('cms.service-types.create.before');

        $data = $this->sanitizePayload($request->validated());

        $serviceType = $this->serviceTypeRepository->create($data);

        Event::dispatch('cms.service-types.create.after', $serviceType);

        session()->flash('success', trans('cms::app.service-types.messages.create-success'));

        return redirect()->route('admin.cms.service-types.index');
    }

    public function edit(int $id): View
    {
        $serviceType = $this->serviceTypeRepository->findOrFail($id);

        $companies = Company::select('id', 'name')->get();

        return view('cms::service-types.edit', compact('serviceType', 'companies'));
    }

    public function update(ServiceTypeRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.service-types.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $serviceType = $this->serviceTypeRepository->update($data, $id);

        Event::dispatch('cms.service-types.update.after', $serviceType);

        session()->flash('success', trans('cms::app.service-types.messages.update-success'));

        return redirect()->route('admin.cms.service-types.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $serviceType = $this->serviceTypeRepository->findOrFail($id);

        Event::dispatch('cms.service-types.delete.before', $id);

        $serviceType?->delete();

        Event::dispatch('cms.service-types.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.service-types.messages.delete-success'),
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $serviceType = $this->serviceTypeRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.service-types.restore.before', $id);

        $serviceType?->restore();

        Event::dispatch('cms.service-types.restore.after', $id);

        return response()->json([
            'message' => trans('cms::app.service-types.messages.restore-success'),
        ]);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $serviceType = $this->serviceTypeRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.service-types.forceDelete.before', $id);

        $serviceType?->forceDelete();

        Event::dispatch('cms.service-types.forceDelete.after', $id);

        return response()->json([
            'message' => trans('cms::app.service-types.messages.forceDelete-success'),
        ]);
    }
}
