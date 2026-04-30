<?php

namespace Webkul\Cms\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCmsMedia;
use Webkul\Cms\Concerns\InteractsWithItemPayload;
use Webkul\Cms\DataGrids\ItemDataGrid;
use Webkul\Cms\Http\Requests\ItemRequest;
use Webkul\Cms\Repositories\ItemRepository;
use Webkul\Company\Models\Company;
use Webkul\Cms\Models\Section;

class ItemController extends Controller
{
    use InteractsWithCmsMedia, InteractsWithItemPayload;

    public function __construct(protected ItemRepository $itemRepository) {}

    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return datagrid(ItemDataGrid::class)->process();
        }

        return view('cms::items.index');
    }

    public function create(): View
    {
        $locales = $this->supportedLocales();

        $companies = Company::select('id', 'name')->get();
	$sections = Section::select('id', 'name')->get();
        return view('cms::items.create', compact('locales', 'companies', 'sections'));
    }

    public function store(ItemRequest $request): RedirectResponse
    {
        Event::dispatch('cms.items.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        $item = $this->itemRepository->create($data);
        $this->syncMediaFromRequest($request, $item);

        Event::dispatch('cms.items.create.after', $item);

        session()->flash('success', trans('cms::app.items.messages.create-success'));

        return redirect()->route('admin.cms.items.index');
    }

    public function edit(int $id): View
    {
        $item = $this->itemRepository->findOrFail($id);

        $item->loadMissing('translations');

        $locales = $this->supportedLocales();

        $companies = Company::select('id', 'name')->get();
	$sections = Section::select('id', 'name')->get();
        return view('cms::items.edit', compact('item', 'locales', 'companies', 'sections'));
    }

    public function update(ItemRequest $request, int $id): RedirectResponse
    {
        Event::dispatch('cms.items.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $item = $this->itemRepository->update($data, $id);
        $this->syncMediaFromRequest($request, $item);

        Event::dispatch('cms.items.update.after', $item);

        session()->flash('success', trans('cms::app.items.messages.update-success'));

        return redirect()->route('admin.cms.items.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $item = $this->itemRepository->findOrFail($id);

        Event::dispatch('cms.items.delete.before', $id);

        $item?->delete();

        Event::dispatch('cms.items.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.items.messages.delete-success'),
        ]);
    }

public function restore(int $id): JsonResponse
{
    $item = $this->itemRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.items.restore.before', $id);

    $item?->restore();

    Event::dispatch('cms.items.restore.after', $id);

    return response()->json([
        'message' => trans('cms::app.items.messages.restore-success'),
    ]);
}

// force delete company
public function forceDelete(int $id): JsonResponse
{
    $item = $this->itemRepository->getModel()->withTrashed()->findOrFail($id);

    Event::dispatch('cms.items.forceDelete.before', $id);

    $item?->clearMediaCollection('main_media');
    $item?->clearMediaCollection('gallery');
    $item?->forceDelete();


    Event::dispatch('cms.items.forceDelete.after', $id);

    return response()->json([
        'message' => trans('cms::app.items.messages.forceDelete-success'),
    ]);


}  
}

