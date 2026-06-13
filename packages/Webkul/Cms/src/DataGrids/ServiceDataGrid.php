<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\Cms\Concerns\FiltersDataGridByCompany;
use Webkul\DataGrid\DataGrid;

class ServiceDataGrid extends DataGrid
{
    use FiltersDataGridByCompany;

    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

        $queryBuilder = DB::table('cms_services')
            ->leftJoin('cms_service_translations as st', function ($join) use ($locale) {
                $join->on('cms_services.id', '=', 'st.cms_service_id')
                    ->where('st.locale', '=', $locale);
            })
            ->leftJoin('companies as c', function ($join) {
                $join->on('cms_services.company_id', '=', 'c.id');
            })
            ->leftJoin('cms_service_types as stype', function ($join) {
                $join->on('cms_services.cms_service_type_id', '=', 'stype.id');
            })
            ->addSelect(
                'cms_services.id',
                'cms_services.is_active',
                'cms_services.order',
                'cms_services.deleted_at',
                'cms_services.company_id',
                DB::raw('COALESCE(st.title, "") as title'),
                DB::raw('COALESCE(c.name, "") as company_name'),
                DB::raw('COALESCE(stype.name, "") as service_type_name'),
            );

        $this->addFilter('id', 'cms_services.id');
        $this->addFilter('title', 'st.title');
        $this->addFilter('is_active', 'cms_services.is_active');
        $this->addFilter('deleted_at', 'cms_services.deleted_at');
        $this->addFilter('company_id', 'cms_services.company_id');

        return $this->applyCompanyTabScope($queryBuilder, 'cms_services.company_id');
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.services.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('cms::app.services.datagrid.title'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'service_type_name',
            'label'      => trans('cms::app.services.datagrid.service_type'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.services.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.services.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.services.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.services.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.services.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.services.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.services.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.services.delete', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.services.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.services.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.services.restore', $row->id) : null,
            ]);
        }

        if (bouncer()->hasPermission('cms.services.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.services.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.services.forceDelete', $row->id) : null,
            ]);
        }
    }
}
