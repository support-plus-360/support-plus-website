<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithNavItemPayload;
use Webkul\Cms\DataGrids\NavItemDataGrid;
use Webkul\Cms\Http\Requests\NavItemRequest;
use Webkul\Cms\Models\NavItem;
use Webkul\Cms\Models\Page;
use Webkul\Cms\Repositories\NavItemRepository;
use Webkul\Cms\Repositories\NavMenuRepository;

class NavItemController extends Controller
{
    use InteractsWithNavItemPayload;

    public function __construct(
        protected NavItemRepository $navItemRepository,
        protected NavMenuRepository $navMenuRepository,
    ) {}

    public function index(int $menuId): View|JsonResponse
    {
        $navMenu = $this->navMenuRepository->findOrFail($menuId);

        if (request()->ajax()) {
            return datagrid(NavItemDataGrid::class)->process();
        }

        return view('cms::nav-items.index', compact('navMenu'));
    }

    public function create(int $menuId): View
    {
        $navMenu = $this->navMenuRepository->findOrFail($menuId);

        return view('cms::nav-items.create', [
            'navMenu'       => $navMenu,
            'locales'       => $this->supportedLocales(),
            'pages'         => $this->pagesForMenu($navMenu),
            'parentOptions' => $this->parentOptions($menuId),
        ]);
    }

    public function store(NavItemRequest $request, int $menuId): RedirectResponse
    {
        Event::dispatch('cms.nav-items.create.before');

        $data = $this->sanitizeNavItemPayload($request->validated());
        $data['menu_id'] = $menuId;

        $item = $this->navItemRepository->create($data);

        Event::dispatch('cms.nav-items.create.after', $item);

        session()->flash('success', trans('cms::app.nav-items.messages.create-success'));

        return redirect()->route('admin.cms.nav-menus.items.index', $menuId);
    }

    public function edit(int $menuId, int $id): View
    {
        $navMenu = $this->navMenuRepository->findOrFail($menuId);
        $navItem = $this->navItemRepository->findOrFail($id);
        $navItem->loadMissing('translations');

        abort_if((int) $navItem->menu_id !== $menuId, 404);

        return view('cms::nav-items.edit', [
            'navMenu'       => $navMenu,
            'navItem'       => $navItem,
            'locales'       => $this->supportedLocales(),
            'pages'         => $this->pagesForMenu($navMenu),
            'parentOptions' => $this->parentOptions($menuId, $id),
        ]);
    }

    public function update(NavItemRequest $request, int $menuId, int $id): RedirectResponse
    {
        Event::dispatch('cms.nav-items.update.before', $id);

        $navItem = $this->navItemRepository->findOrFail($id);

        abort_if((int) $navItem->menu_id !== $menuId, 404);

        $data = $this->sanitizeNavItemPayload($request->validated());
        $data['menu_id'] = $menuId;

        $item = $this->navItemRepository->update($data, $id);

        Event::dispatch('cms.nav-items.update.after', $item);

        session()->flash('success', trans('cms::app.nav-items.messages.update-success'));

        return redirect()->route('admin.cms.nav-menus.items.index', $menuId);
    }

    public function destroy(int $menuId, int $id): JsonResponse
    {
        $navItem = $this->navItemRepository->findOrFail($id);

        abort_if((int) $navItem->menu_id !== $menuId, 404);

        Event::dispatch('cms.nav-items.delete.before', $id);

        $navItem?->delete();

        Event::dispatch('cms.nav-items.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.nav-items.messages.delete-success'),
        ]);
    }

    public function restore(int $menuId, int $id): JsonResponse
    {
        $navItem = $this->navItemRepository->getModel()->withTrashed()->findOrFail($id);

        abort_if((int) $navItem->menu_id !== $menuId, 404);

        Event::dispatch('cms.nav-items.restore.before', $id);

        $navItem?->restore();

        Event::dispatch('cms.nav-items.restore.after', $id);

        return response()->json([
            'message' => trans('cms::app.nav-items.messages.restore-success'),
        ]);
    }

    public function forceDelete(int $menuId, int $id): JsonResponse
    {
        $navItem = $this->navItemRepository->getModel()->withTrashed()->findOrFail($id);

        abort_if((int) $navItem->menu_id !== $menuId, 404);

        Event::dispatch('cms.nav-items.forceDelete.before', $id);

        $navItem?->forceDelete();

        Event::dispatch('cms.nav-items.forceDelete.after', $id);

        return response()->json([
            'message' => trans('cms::app.nav-items.messages.forceDelete-success'),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, Page>
     */
    protected function pagesForMenu($navMenu)
    {
        $query = Page::query()
            ->with('translations')
            ->where('is_active', true)
            ->orderBy('order');

        if ($navMenu->company_id) {
            $query->where('company_id', $navMenu->company_id);
        }

        return $query->get();
    }

    /**
     * @return \Illuminate\Support\Collection<int, NavItem>
     */
    protected function parentOptions(int $menuId, ?int $excludeId = null)
    {
        $query = NavItem::query()
            ->where('menu_id', $menuId)
            ->whereNull('parent_id')
            ->orderBy('order');

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->with(['translations', 'page.translations'])->get();
    }
}
