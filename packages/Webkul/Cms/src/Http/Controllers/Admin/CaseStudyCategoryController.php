<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCaseStudyCategoryPayload;
use Webkul\Cms\Concerns\InteractsWithCmsCompanyTabs;
use Webkul\Cms\DataGrids\CaseStudyCategoryDataGrid;
use Webkul\Cms\Http\Requests\CaseStudyCategoryRequest;
use Webkul\Cms\Repositories\CaseStudyCategoryRepository;
use Webkul\Company\Models\Company;

class CaseStudyCategoryController extends Controller
{
    use InteractsWithCaseStudyCategoryPayload, InteractsWithCmsCompanyTabs;

    public function __construct(protected CaseStudyCategoryRepository $caseStudyCategoryRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(CaseStudyCategoryDataGrid::class)->process();
        }

        return view('cms::case-study-categories.index', $this->cmsCompanyTabs());
    }

    public function create(): View
    {
        $companies = Company::select('id', 'name')->get();

        return view('cms::case-study-categories.create', compact('companies'));
    }

    public function store(CaseStudyCategoryRequest $request): RedirectResponse
    {
        Event::dispatch('cms.case-study-categories.create.before');

        $data = $this->sanitizePayload($request->validated());

        $caseStudyCategory = $this->caseStudyCategoryRepository->create($data);

        Event::dispatch('cms.case-study-categories.create.after', $caseStudyCategory);

        session()->flash('success', trans('cms::app.case-study-categories.messages.create-success'));

        return redirect()->route('admin.cms.case-study-categories.index');
    }

    public function edit(int $id): View
    {
        $caseStudyCategory = $this->caseStudyCategoryRepository->findOrFail($id);

        $companies = Company::select('id', 'name')->get();

        return view('cms::case-study-categories.edit', compact('caseStudyCategory', 'companies'));
    }

    public function update(CaseStudyCategoryRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.case-study-categories.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $caseStudyCategory = $this->caseStudyCategoryRepository->update($data, $id);

        Event::dispatch('cms.case-study-categories.update.after', $caseStudyCategory);

        session()->flash('success', trans('cms::app.case-study-categories.messages.update-success'));

        return redirect()->route('admin.cms.case-study-categories.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $caseStudyCategory = $this->caseStudyCategoryRepository->findOrFail($id);

        Event::dispatch('cms.case-study-categories.delete.before', $id);

        $caseStudyCategory?->delete();

        Event::dispatch('cms.case-study-categories.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.case-study-categories.messages.delete-success'),
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $caseStudyCategory = $this->caseStudyCategoryRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.case-study-categories.restore.before', $id);

        $caseStudyCategory?->restore();

        Event::dispatch('cms.case-study-categories.restore.after', $id);

        return response()->json([
            'message' => trans('cms::app.case-study-categories.messages.restore-success'),
        ]);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $caseStudyCategory = $this->caseStudyCategoryRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.case-study-categories.forceDelete.before', $id);

        $caseStudyCategory?->forceDelete();

        Event::dispatch('cms.case-study-categories.forceDelete.after', $id);

        return response()->json([
            'message' => trans('cms::app.case-study-categories.messages.forceDelete-success'),
        ]);
    }
}
