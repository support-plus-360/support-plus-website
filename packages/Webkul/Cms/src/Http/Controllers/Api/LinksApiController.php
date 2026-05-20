<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Concerns\InteractsWithLinkPayload;
use Webkul\Cms\Http\Requests\LinkRequest;
use Webkul\Cms\Repositories\LinkRepository;

class LinksApiController extends Controller
{
    use InteractsWithCompanyDomain;
    use InteractsWithLinkPayload;

    public function __construct(protected LinkRepository $linkRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $query = $this->linkRepository->getModel()
            ->newQuery()
            ->with('translations')
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

        $link = $this->linkRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $link->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $link->loadMissing('translations');

        return response()->json($link);
    }

    // get links by linkable type and linkable id
    public function getLinksByLinkableTypeAndLinkableId(Request $request, string $linkableType, int $linkableId): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $perPage = min(max((int) $request->input('per_page', 15), 1), 100);

        $links = $this->linkRepository->getModel()
            ->newQuery()
            ->where('linkable_type', $linkableType)
            ->where('linkable_id', $linkableId)
            ->orderByDesc('id');

        if ($resolvedCompanyId) {
            $links->where('company_id', $resolvedCompanyId);
        }

        return response()->json($links->paginate($perPage));
    }

    public function store(LinkRequest $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.links.create.before');

        $data = $this->sanitizePayload($request->validated(), true);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? null)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $link = $this->linkRepository->create($data);

        Event::dispatch('cms.links.create.after', $link);

        $link->loadMissing('translations');

        return response()->json($link, 201);
    }

    public function update(LinkRequest $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        Event::dispatch('cms.links.update.before', $id);

        $link = $this->linkRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $link->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        $data = $this->sanitizePayload($request->validated());

        // if ($this->isCompanyMismatch($resolvedCompanyId, $data['company_id'] ?? $link->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        if ($resolvedCompanyId) {
            $data['company_id'] = $resolvedCompanyId;
        }

        $link = $this->linkRepository->update($data, $id);

        Event::dispatch('cms.links.update.after', $link);

        $link->loadMissing('translations');

        return response()->json($link);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $link = $this->linkRepository->findOrFail($id);

        // if ($this->isCompanyMismatch($resolvedCompanyId, $link->company_id)) {
        //     return $this->companyMismatchResponse();
        // }

        Event::dispatch('cms.links.delete.before', $id);

        $link?->delete();

        Event::dispatch('cms.links.delete.after', $id);

        return response()->json([
            'message' => trans('cms::app.links.messages.delete-success'),
        ]);
    }
}
