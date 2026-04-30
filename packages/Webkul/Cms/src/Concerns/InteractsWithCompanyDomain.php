<?php

namespace Webkul\Cms\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Webkul\Company\Models\Company;

trait InteractsWithCompanyDomain
{
    protected function resolvedCompanyId(Request $request): ?int
    {
        if ($request->attributes->has('_resolved_company_id')) {
            return $request->attributes->get('_resolved_company_id');
        }

        $domainHeader = $request->header('Domain');

        if (! $domainHeader) {
            $request->attributes->set('_resolved_company_id', null);

            return null;
        }

        $domain = $this->normalizeDomain($domainHeader);

        if (! $domain) {
            $request->attributes->set('_resolved_company_id', null);

            return null;
        }

        $companyId = Company::query()
            ->get(['id', 'website'])
            ->first(function (Company $company) use ($domain) {
                return $this->normalizeDomain((string) $company->website) === $domain;
            })
            ?->id;

        $request->attributes->set('_resolved_company_id', $companyId);

        return $companyId;
    }

    protected function invalidDomainResponse(): JsonResponse
    {
        return response()->json([
            'message' => 'Domain is not mapped to any company.',
        ], 403);
    }

    protected function companyMismatchResponse(): JsonResponse
    {
        return response()->json([
            'message' => 'Resource company does not match request domain.',
        ], 403);
    }

    protected function isCompanyMismatch(?int $resolvedCompanyId, mixed $resourceCompanyId): bool
    {
        if (! $resolvedCompanyId) {
            return false;
        }

        return (int) ($resourceCompanyId ?? 0) !== $resolvedCompanyId;
    }

    private function normalizeDomain(string $value): ?string
    {
        $value = trim(strtolower($value));

        if ($value === '') {
            return null;
        }

        if (! str_contains($value, '://')) {
            $value = 'http://' . $value;
        }

        $host = parse_url($value, PHP_URL_HOST);

        if (! is_string($host) || $host === '') {
            return null;
        }

        return preg_replace('/^www\./', '', strtolower($host));
    }
}

