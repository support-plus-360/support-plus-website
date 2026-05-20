<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCmsMedia;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Concerns\InteractsWithItemPayload;
use Webkul\Cms\Http\Requests\ItemRequest;
use Webkul\Cms\Repositories\ItemRepository;

class ItemApiController extends Controller
{
    use InteractsWithCmsMedia;
    use InteractsWithCompanyDomain;
    use InteractsWithItemPayload;

    public function __construct(protected ItemRepository $itemRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $query = $this->itemRepository->getModel()
            ->newQuery()
            ->with(['translations', 'media'])
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        }

        return response()->json($query->paginate($perPage));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $item = $this->itemRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $item->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $item->loadMissing(['translations', 'media']);

        return response()->json($item);
    }

    // get items by section id
    public function getItemsBySectionId(Request $request, int $sectionId): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $items = $this->itemRepository->getModel()
            ->newQuery()
            ->where('section_id', $sectionId)
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $items->where('company_id', $resolvedCompanyId);
        }

        return response()->json($items->paginate($perPage));
    }

    public function store(ItemRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.items.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? null)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $item = $this->itemRepository->create($data);
        $this->syncMediaFromRequest($request, $item);

        Event::dispatch('cms.items.create.after', $item);

        $item->loadMissing(['translations', 'media']);

        return response()->json($item, 201);
    }

    public function update(ItemRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.items.update.before', $id);

        $item = $this->itemRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $item->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $data = $this->sanitizePayload($request->validated());

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? $item->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $item = $this->itemRepository->update($data, $id);
        $this->syncMediaFromRequest($request, $item);

        Event::dispatch('cms.items.update.after', $item);

        $item->loadMissing(['translations', 'media']);

        return response()->json($item);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $item = $this->itemRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $item->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        Event::dispatch('cms.items.delete.before', $id);

        $item?->delete();

        Event::dispatch('cms.items.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.items.messages.delete-success'),
        ]);
    }
}
