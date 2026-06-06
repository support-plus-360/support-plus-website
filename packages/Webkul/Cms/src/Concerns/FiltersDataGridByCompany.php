<?php

namespace Webkul\Cms\Concerns;

use Illuminate\Database\Query\Builder;

trait FiltersDataGridByCompany
{
    protected function applyCompanyTabScope(Builder $queryBuilder, string $qualifiedColumn): Builder
    {
        $companyId = request()->integer('company_id');

        if ($companyId > 0) {
            $queryBuilder->where($qualifiedColumn, $companyId);
        }

        return $queryBuilder;
    }
}
