<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\Cms\Concerns\FiltersDataGridByCompany;
use Webkul\DataGrid\DataGrid;

class CaseStudyCategoryDataGrid extends DataGrid
{
    use FiltersDataGridByCompany;

    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('cms_case_study_categories')
            ->leftJoin('companies as c', function ($join) {
                $join->on('cms_case_study_categories.company_id', '=', 'c.id');
            })
            ->addSelect(
                'cms_case_study_categories.id',
                'cms_case_study_categories.name',
                'cms_case_study_categories.description',
                'cms_case_study_categories.is_active',
                'cms_case_study_categories.deleted_at',
                'cms_case_study_categories.company_id',
                DB::raw('COALESCE(c.name, "") as company_name'),
            );

        $this->addFilter('id', 'cms_case_study_categories.id');
        $this->addFilter('name', 'cms_case_study_categories.name');
        $this->addFilter('is_active', 'cms_case_study_categories.is_active');
        $this->addFilter('deleted_at', 'cms_case_study_categories.deleted_at');
        $this->addFilter('company_id', 'cms_case_study_categories.company_id');

        return $this->applyCompanyTabScope($queryBuilder, 'cms_case_study_categories.company_id');
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.case-study-categories.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('cms::app.case-study-categories.datagrid.name'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.case-study-categories.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.case-study-categories.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.case-study-categories.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.case-study-categories.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.case-study-categories.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.case-study-categories.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.case-study-categories.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.case-study-categories.delete', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.case-study-categories.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.case-study-categories.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.case-study-categories.restore', $row->id) : null,
            ]);
        }

        if (bouncer()->hasPermission('cms.case-study-categories.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.case-study-categories.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.case-study-categories.forceDelete', $row->id) : null,
            ]);
        }
    }
}
