<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithItemPayload;
use Webkul\Cms\Http\Requests\ItemRequest;
use Webkul\Cms\Repositories\ItemRepository;

class ItemApiController extends Controller
{
    use InteractsWithItemPayload;

    public function __construct(protected ItemRepository $itemRepository) {}

    public function index(Request $request): JsonResponse
    {

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $query = $this->itemRepository->getModel()
            ->newQuery()
            ->with('translations')
            ->orderByDesc('id');

        return response()->json($query->paginate($perPage));
    }

    public function show(int $id): JsonResponse
    {

        $item = $this->itemRepository->findOrFail($id);
        $item->loadMissing('translations');

        return response()->json($item);
    }

    public function store(ItemRequest $request): JsonResponse
    {

        Event::dispatch('cms.items.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        $item = $this->itemRepository->create($data);

        Event::dispatch('cms.items.create.after', $item);

        $item->loadMissing('translations');

        return response()->json($item, 201);
    }

    public function update(ItemRequest $request, int $id): JsonResponse
    {

        Event::dispatch('cms.items.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $item = $this->itemRepository->update($data, $id);

        Event::dispatch('cms.items.update.after', $item);

        $item->loadMissing('translations');

        return response()->json($item);
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
}
