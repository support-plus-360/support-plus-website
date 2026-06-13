<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\Cms\Concerns\FiltersDataGridByCompany;
use Webkul\DataGrid\DataGrid;

class ServiceTypeDataGrid extends DataGrid
{
    use FiltersDataGridByCompany;

    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('cms_service_types')
            ->leftJoin('companies as c', function ($join) {
                $join->on('cms_service_types.company_id', '=', 'c.id');
            })
            ->addSelect(
                'cms_service_types.id',
                'cms_service_types.name',
                'cms_service_types.is_active',
                'cms_service_types.deleted_at',
                'cms_service_types.company_id',
                DB::raw('COALESCE(c.name, "") as company_name'),
            );

        $this->addFilter('id', 'cms_service_types.id');
        $this->addFilter('name', 'cms_service_types.name');
        $this->addFilter('is_active', 'cms_service_types.is_active');
        $this->addFilter('deleted_at', 'cms_service_types.deleted_at');
        $this->addFilter('company_id', 'cms_service_types.company_id');

        return $this->applyCompanyTabScope($queryBuilder, 'cms_service_types.company_id');
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.service-types.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('cms::app.service-types.datagrid.name'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.service-types.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.service-types.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.service-types.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.service-types.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.service-types.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.service-types.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.service-types.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.service-types.delete', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.service-types.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.service-types.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.service-types.restore', $row->id) : null,
            ]);
        }

        if (bouncer()->hasPermission('cms.service-types.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.service-types.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.service-types.forceDelete', $row->id) : null,
            ]);
        }
    }
}
