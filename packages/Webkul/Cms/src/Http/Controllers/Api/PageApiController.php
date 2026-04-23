<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithPagePayload;
use Webkul\Cms\Http\Requests\PageRequest;
use Webkul\Cms\Repositories\PageRepository;

class PageApiController extends Controller
{
    use InteractsWithPagePayload;

    public function __construct(protected PageRepository $pageRepository) {}

    public function index(Request $request): JsonResponse
    {

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $companyId = $request->input('company_id');

        $query = $this->pageRepository->getModel()
            ->newQuery()
            ->with('translations')
            ->orderByDesc('id');

        if ($companyId !== null && $companyId !== '') {
            $query->where('company_id', (int) $companyId);
        }

        return response()->json($query->paginate($perPage));
    }

    public function show(int $id): JsonResponse
    {

        $page = $this->pageRepository->findOrFail($id);
        $page->loadMissing('translations');

        return response()->json($page);
    }

    public function store(PageRequest $request): JsonResponse
    {

        Event::dispatch('cms.pages.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        $page = $this->pageRepository->create($data);

        Event::dispatch('cms.pages.create.after', $page);

        $page->loadMissing('translations');

        return response()->json($page, 201);
    }

    public function update(PageRequest $request, int $id): JsonResponse
    {

        Event::dispatch('cms.pages.update.before', $id);

        $data = $this->sanitizePayload($request->validated());

        $page = $this->pageRepository->update($data, $id);

        Event::dispatch('cms.pages.update.after', $page);

        $page->loadMissing('translations');

        return response()->json($page);
    }

    public function destroy(int $id): JsonResponse
    {

        $page = $this->pageRepository->findOrFail($id);

        Event::dispatch('cms.pages.delete.before', $id);

        $page?->delete();

        Event::dispatch('cms.pages.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.pages.messages.delete-success'),
        ]);
    }
}
