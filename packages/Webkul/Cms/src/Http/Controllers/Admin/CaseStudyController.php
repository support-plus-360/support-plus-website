<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCaseStudyPayload;
use Webkul\Cms\Concerns\InteractsWithCmsCompanyTabs;
use Webkul\Cms\Concerns\InteractsWithCmsMedia;
use Webkul\Cms\DataGrids\CaseStudyDataGrid;
use Webkul\Cms\Http\Requests\CaseStudyRequest;
use Webkul\Cms\Models\CaseStudyCategory;
use Webkul\Cms\Repositories\CaseStudyRepository;
use Webkul\Company\Models\Company;

class CaseStudyController extends Controller
{
    use InteractsWithCaseStudyPayload, InteractsWithCmsCompanyTabs, InteractsWithCmsMedia;

    public function __construct(protected CaseStudyRepository $caseStudyRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(CaseStudyDataGrid::class)->process();
        }

        return view('cms::case-studies.index', $this->cmsCompanyTabs());
    }

    public function create(): View
    {
        $locales = $this->supportedLocales();
        $companies = Company::select('id', 'name')->get();
        $caseStudyCategories = $this->caseStudyCategoriesForForm();

        return view('cms::case-studies.create', compact('locales', 'companies', 'caseStudyCategories'));
    }

    public function store(CaseStudyRequest $request): RedirectResponse
    {
        Event::dispatch('cms.case-studies.create.before');

        $data = $this->sanitizePayload($request->validated());

        $caseStudy = $this->caseStudyRepository->create($data);
        $this->syncMediaFromRequest($request, $caseStudy);

        Event::dispatch('cms.case-studies.create.after', $caseStudy);

        session()->flash('success', trans('cms::app.case-studies.messages.create-success'));

        return redirect()->route('admin.cms.case-studies.index');
    }

    public function edit(int $id): View
    {
        $caseStudy = $this->caseStudyRepository->findOrFail($id);

        $caseStudy->loadMissing('translations', 'category');

        $locales = $this->supportedLocales();
        $companies = Company::select('id', 'name')->get();
        $caseStudyCategories = $this->caseStudyCategoriesForForm();

        return view('cms::case-studies.edit', compact('caseStudy', 'locales', 'companies', 'caseStudyCategories'));
    }

    public function update(CaseStudyRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.case-studies.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $caseStudy = $this->caseStudyRepository->update($data, $id);
        $this->syncMediaFromRequest($request, $caseStudy);

        Event::dispatch('cms.case-studies.update.after', $caseStudy);

        session()->flash('success', trans('cms::app.case-studies.messages.update-success'));

        return redirect()->route('admin.cms.case-studies.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $caseStudy = $this->caseStudyRepository->findOrFail($id);

        Event::dispatch('cms.case-studies.delete.before', $id);

        $caseStudy?->delete();

        Event::dispatch('cms.case-studies.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.case-studies.messages.delete-success'),
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $caseStudy = $this->caseStudyRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.case-studies.restore.before', $id);

        $caseStudy?->restore();

        Event::dispatch('cms.case-studies.restore.after', $id);

        return response()->json([
            'message' => trans('cms::app.case-studies.messages.restore-success'),
        ]);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $caseStudy = $this->caseStudyRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.case-studies.forceDelete.before', $id);

        $caseStudy?->clearMediaCollection('main_media');
        $caseStudy?->clearMediaCollection('gallery');
        $caseStudy?->forceDelete();

        Event::dispatch('cms.case-studies.forceDelete.after', $id);

        return response()->json([
            'message' => trans('cms::app.case-studies.messages.forceDelete-success'),
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, CaseStudyCategory>
     */
    private function caseStudyCategoriesForForm()
    {
        return CaseStudyCategory::query()
            ->orderBy('name')
            ->orderBy('id')
            ->get(['id', 'name']);
    }
}
