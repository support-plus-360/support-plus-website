<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\Cms\Concerns\FiltersDataGridByCompany;
use Webkul\DataGrid\DataGrid;

class CaseStudyDataGrid extends DataGrid
{
    use FiltersDataGridByCompany;

    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

        $queryBuilder = DB::table('cms_case_studies')
            ->leftJoin('cms_case_study_translations as cst', function ($join) use ($locale) {
                $join->on('cms_case_studies.id', '=', 'cst.cms_case_study_id')
                    ->where('cst.locale', '=', $locale);
            })
            ->leftJoin('companies as c', function ($join) {
                $join->on('cms_case_studies.company_id', '=', 'c.id');
            })
            ->leftJoin('cms_case_study_categories as cat', function ($join) {
                $join->on('cms_case_studies.cms_case_study_category_id', '=', 'cat.id');
            })
            ->addSelect(
                'cms_case_studies.id',
                'cms_case_studies.city',
                'cms_case_studies.rate',
                'cms_case_studies.is_active',
                'cms_case_studies.order',
                'cms_case_studies.deleted_at',
                'cms_case_studies.company_id',
                DB::raw('COALESCE(cst.title, "") as title'),
                DB::raw('COALESCE(c.name, "") as company_name'),
                DB::raw('COALESCE(cat.name, "") as category_name'),
            );

        $this->addFilter('id', 'cms_case_studies.id');
        $this->addFilter('title', 'cst.title');
        $this->addFilter('city', 'cms_case_studies.city');
        $this->addFilter('is_active', 'cms_case_studies.is_active');
        $this->addFilter('deleted_at', 'cms_case_studies.deleted_at');
        $this->addFilter('company_id', 'cms_case_studies.company_id');

        return $this->applyCompanyTabScope($queryBuilder, 'cms_case_studies.company_id');
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.case-studies.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('cms::app.case-studies.datagrid.title'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'category_name',
            'label'      => trans('cms::app.case-studies.datagrid.category'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'city',
            'label'      => trans('cms::app.case-studies.datagrid.city'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'rate',
            'label'      => trans('cms::app.case-studies.datagrid.rate'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.case-studies.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.case-studies.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.case-studies.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.case-studies.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.case-studies.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.case-studies.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.case-studies.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.case-studies.delete', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.case-studies.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.case-studies.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.case-studies.restore', $row->id) : null,
            ]);
        }

        if (bouncer()->hasPermission('cms.case-studies.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.case-studies.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.case-studies.forceDelete', $row->id) : null,
            ]);
        }
    }
}
