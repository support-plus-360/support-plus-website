<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Concerns\InteractsWithPagePayload;
use Webkul\Cms\Http\Requests\PageBuilderRequest;
use Webkul\Cms\Http\Requests\PageRequest;
use Webkul\Cms\Http\Resources\PageResource;
use Webkul\Cms\Repositories\PageRepository;
use Webkul\Cms\Services\PageBuilderService;

class PageApiController extends Controller
{
    use InteractsWithCompanyDomain;
    use InteractsWithPagePayload;

    public function __construct(
        protected PageRepository $pageRepository,
        protected PageBuilderService $pageBuilderService,
    ) {}

    /**
     * @return array<int|string, mixed>
     */
    protected function pageNestedRelations(): array
    {
        return [
            'translations',
            'sections' => fn ($q) => $q->orderBy('order')->with([
                'media',
                'translations',
                'items' => fn ($iq) => $iq->orderBy('order')->with([
                    'media',
                    'translations',
                    'links' => fn ($lq) => $lq->orderBy('order')->with('translations'),
                ]),
                'links' => fn ($lq) => $lq->orderBy('order')->with('translations'),
            ]),
            'links' => fn ($lq) => $lq->orderBy('order')->with('translations'),
        ];
    }

    public function index(Request $request)
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $companyId = $request->input('company_id');

        // if ($this->isCompanyMismatch($resolvedCompanyId, $companyId)) {
        //     return $this->companyMismatchResponse();
        // }

        $query = $this->pageRepository->getModel()
            ->newQuery()
            ->where('is_active', true)
            ->with($this->pageNestedRelations())
            ->orderBy('order', 'asc');

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        } elseif ($companyId !== null && $companyId !== '') {
            $query->where('company_id', (int) $companyId);
        }

        return PageResource::collection($query->paginate($perPage));
    }

    public function show(Request $request, int $id): PageResource|JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $page = $this->pageRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $page->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $page->loadMissing($this->pageNestedRelations());

        return new PageResource($page);
    }

    public function syncBuilder(PageBuilderRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.pages.update.before', $id);

        $page = $this->pageRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $page->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $validated = $request->validated();

        $pagePayload = Arr::except($validated, [
            'sync_sections',
            'sync_page_links',
            'prune_sections',
            'prune_page_links',
            'sections',
            'page_links',
        ]);

        $data = $this->sanitizePayload($pagePayload);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? $page->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $page = $this->pageRepository->update($data, $id);

        $structure = [];
        if ($request->boolean('sync_page_links')) {
            $structure['page_links'] = $validated['page_links'] ?? [];
            $structure['prune_page_links'] = $request->boolean('prune_page_links');
        }
        if ($request->boolean('sync_sections')) {
            $structure['sections'] = $validated['sections'] ?? [];
            $structure['prune_sections'] = $request->boolean('prune_sections');
        }

        if ($structure !== []) {
            $this->pageBuilderService->syncStructure($page->fresh(), $structure, $request);
        }

        Event::dispatch('cms.pages.update.after', $page->fresh());

        $page = $page->fresh();
        $page?->load($this->pageNestedRelations());

        return new PageResource($page);
    }

    public function store(PageRequest $request): PageResource|JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.pages.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? null)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $page = $this->pageRepository->create($data);

        Event::dispatch('cms.pages.create.after', $page);

        $page->loadMissing('translations');

        return (new PageResource($page))->response()->setStatusCode(201);
    }

    public function update(PageRequest $request, int $id): PageResource|JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.pages.update.before', $id);

        $page = $this->pageRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $page->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $data = $this->sanitizePayload($request->validated());

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? $page->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $page = $this->pageRepository->update($data, $id);

        Event::dispatch('cms.pages.update.after', $page);

        $page->loadMissing('translations');

        return new PageResource($page);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $page = $this->pageRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $page->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        Event::dispatch('cms.pages.delete.before', $id);

        $page?->delete();

        Event::dispatch('cms.pages.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.pages.messages.delete-success'),
        ]);
    }
}