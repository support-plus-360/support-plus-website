<?php

namespace Webkul\Cms\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Cms\Concerns\InteractsWithCompanyDomain;
use Webkul\Cms\Http\Resources\NavMenuResource;
use Webkul\Cms\Repositories\NavMenuRepository;

class NavMenuApiController extends Controller
{
    use InteractsWithCompanyDomain;

    public function __construct(protected NavMenuRepository $navMenuRepository) {}

    public function index(Request $request): JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $companyId = $request->input('company_id');

        if ($this->isCompanyMismatch($resolvedCompanyId, $companyId)) {
            return $this->companyMismatchResponse();
        }

        $query = $this->navMenuRepository->getModel()->newQuery()->orderBy('key');

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        } elseif ($companyId !== null && $companyId !== '') {
            $query->where('company_id', (int) $companyId);
        }

        return response()->json($query->get(['id', 'key', 'name', 'company_id']));
    }

    public function showByKey(Request $request, string $key): NavMenuResource|JsonResponse
    {
        $resolvedCompanyId = $this->resolvedCompanyId($request);

        if ($request->header('Domain') && ! $resolvedCompanyId) {
            return $this->invalidDomainResponse();
        }

        $key = strtolower($key);

        if (! in_array($key, ['header', 'footer'], true)) {
            return response()->json(['message' => 'Invalid menu key.'], 404);
        }

        $companyId = $request->input('company_id');

        if ($this->isCompanyMismatch($resolvedCompanyId, $companyId)) {
            return $this->companyMismatchResponse();
        }

        $query = $this->navMenuRepository->getModel()
            ->newQuery()
            ->where('key', $key);

        if ($resolvedCompanyId) {
            $query->where('company_id', $resolvedCompanyId);
        } elseif ($companyId !== null && $companyId !== '') {
            $query->where('company_id', (int) $companyId);
        }

        $menu = $query->first();

        if (! $menu) {
            return response()->json(['message' => 'Navigation menu not found.'], 404);
        }

        $menu->load([
            'items' => fn ($q) => $q
                ->where('is_active', true)
                ->orderBy('order')
                ->with([
                    'translations',
                    'page.translations',
                ]),
        ]);

        return new NavMenuResource($menu);
    }
}
