<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithServicePayload;
use Webkul\Cms\Concerns\InteractsWithCmsCompanyTabs;
use Webkul\Cms\Concerns\InteractsWithCmsMedia;
use Webkul\Cms\DataGrids\ServiceDataGrid;
use Webkul\Cms\Http\Requests\ServiceRequest;
use Webkul\Cms\Models\ServiceType;
use Webkul\Cms\Repositories\ServiceRepository;
use Webkul\Company\Models\Company;

class ServiceController extends Controller
{
    use InteractsWithServicePayload, InteractsWithCmsCompanyTabs, InteractsWithCmsMedia;

    public function __construct(protected ServiceRepository $serviceRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(ServiceDataGrid::class)->process();
        }

        return view('cms::services.index', $this->cmsCompanyTabs());
    }

    public function create(): View
    {
        $locales = $this->supportedLocales();
        $companies = Company::select('id', 'name')->get();
        $serviceTypes = $this->serviceTypesForForm();

        return view('cms::services.create', compact('locales', 'companies', 'serviceTypes'));
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        Event::dispatch('cms.services.create.before');

        $data = $this->sanitizePayload($request->validated());

        $service = $this->serviceRepository->create($data);
        $this->syncServiceMediaFromRequest($request, $service);

        Event::dispatch('cms.services.create.after', $service);

        session()->flash('success', trans('cms::app.services.messages.create-success'));

        return redirect()->route('admin.cms.services.index');
    }

    public function edit(int $id): View
    {
        $service = $this->serviceRepository->findOrFail($id);

        $service->loadMissing('translations', 'serviceType');

        $locales = $this->supportedLocales();
        $companies = Company::select('id', 'name')->get();
        $serviceTypes = $this->serviceTypesForForm();

        return view('cms::services.edit', compact('service', 'locales', 'companies', 'serviceTypes'));
    }

    public function update(ServiceRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.services.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $service = $this->serviceRepository->update($data, $id);
        $this->syncServiceMediaFromRequest($request, $service);

        Event::dispatch('cms.services.update.after', $service);

        session()->flash('success', trans('cms::app.services.messages.update-success'));

        return redirect()->route('admin.cms.services.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $service = $this->serviceRepository->findOrFail($id);

        Event::dispatch('cms.services.delete.before', $id);

        $service?->delete();

        Event::dispatch('cms.services.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.services.messages.delete-success'),
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $service = $this->serviceRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.services.restore.before', $id);

        $service?->restore();

        Event::dispatch('cms.services.restore.after', $id);

        return response()->json([
            'message' => trans('cms::app.services.messages.restore-success'),
        ]);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $service = $this->serviceRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.services.forceDelete.before', $id);

        $service?->clearMediaCollection('main_media');
        $service?->clearMediaCollection('icon_media');
        $service?->forceDelete();

        Event::dispatch('cms.services.forceDelete.after', $id);

        return response()->json([
            'message' => trans('cms::app.services.messages.forceDelete-success'),
        ]);
    }

  /**
     * @return \Illuminate\Database\Eloquent\Collection<int, ServiceType>
     */
    private function serviceTypesForForm()
    {
        return ServiceType::query()
            ->orderBy('name')
            ->orderBy('id')
            ->get(['id', 'name']);
    }
}
