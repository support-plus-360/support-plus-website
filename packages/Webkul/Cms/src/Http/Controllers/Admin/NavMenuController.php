<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithNavMenuPayload;
use Webkul\Cms\DataGrids\NavMenuDataGrid;
use Webkul\Cms\Http\Requests\NavMenuRequest;
use Webkul\Cms\Repositories\NavMenuRepository;
use Webkul\Company\Models\Company;

class NavMenuController extends Controller
{
    use InteractsWithNavMenuPayload;

    public function __construct(protected NavMenuRepository $navMenuRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(NavMenuDataGrid::class)->process();
        }

        return view('cms::nav-menus.index');
    }

    public function create(): View
    {
        $companies = Company::select('id', 'name')->get();

        return view('cms::nav-menus.create', compact('companies'));
    }

    public function store(NavMenuRequest $request): RedirectResponse
    {
        Event::dispatch('cms.nav-menus.create.before');

        $menu = $this->navMenuRepository->create(
            $this->sanitizeNavMenuPayload($request->validated())
        );

        Event::dispatch('cms.nav-menus.create.after', $menu);

        session()->flash('success', trans('cms::app.nav-menus.messages.create-success'));

        return redirect()->route('admin.cms.nav-menus.index');
    }

    public function edit(int $id): View
    {
        $navMenu = $this->navMenuRepository->findOrFail($id);
        $companies = Company::select('id', 'name')->get();

        return view('cms::nav-menus.edit', compact('navMenu', 'companies'));
    }

    public function update(NavMenuRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.nav-menus.update.before', $id);

        $menu = $this->navMenuRepository->update(
            $this->sanitizeNavMenuPayload($request->validated()),
            $id
        );

        Event::dispatch('cms.nav-menus.update.after', $menu);

        session()->flash('success', trans('cms::app.nav-menus.messages.update-success'));

        return redirect()->route('admin.cms.nav-menus.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $navMenu = $this->navMenuRepository->findOrFail($id);

        Event::dispatch('cms.nav-menus.delete.before', $id);

        $navMenu?->delete();

        Event::dispatch('cms.nav-menus.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.nav-menus.messages.delete-success'),
        ]);
    }

    public function restore(int $id): JsonResponse
    {
        $navMenu = $this->navMenuRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.nav-menus.restore.before', $id);

        $navMenu?->restore();

        Event::dispatch('cms.nav-menus.restore.after', $id);

        return response()->json([
            'message' => trans('cms::app.nav-menus.messages.restore-success'),
        ]);
    }

    public function forceDelete(int $id): JsonResponse
    {
        $navMenu = $this->navMenuRepository->getModel()->withTrashed()->findOrFail($id);

        Event::dispatch('cms.nav-menus.forceDelete.before', $id);

        $navMenu?->forceDelete();

        Event::dispatch('cms.nav-menus.forceDelete.after', $id);

        return response()->json([
            'message' => trans('cms::app.nav-menus.messages.forceDelete-success'),
        ]);
    }
}
