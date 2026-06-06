<?php

namespace Webkul\Cms\Concerns;

use Webkul\Company\Models\Company;

trait InteractsWithCmsCompanyTabs
{
    /**
     * @return array{companies: \Illuminate\Support\Collection, activeCompanyId: int|null}
     */
    protected function cmsCompanyTabs(): array
    {
        $companies = Company::query()
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $activeCompanyId = request()->integer('company_id');

        if ($activeCompanyId <= 0 && $companies->isNotEmpty()) {
            $activeCompanyId = (int) $companies->first()->id;
        }

        return [
            'companies'       => $companies,
            'activeCompanyId' => $activeCompanyId > 0 ? $activeCompanyId : null,
        ];
    }

    /**
     * @return array<string, int>
     */
    protected function cmsCompanyQueryParams(?int $companyId = null): array
    {
        $companyId ??= request()->integer('company_id');

        if ($companyId <= 0) {
            $tabs = $this->cmsCompanyTabs();
            $companyId = $tabs['activeCompanyId'];
        }

        return $companyId ? ['company_id' => $companyId] : [];
    }
}
