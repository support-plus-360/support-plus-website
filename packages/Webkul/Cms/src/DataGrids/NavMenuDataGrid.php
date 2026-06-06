<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\Cms\Concerns\FiltersDataGridByCompany;
use Webkul\DataGrid\DataGrid;

class NavMenuDataGrid extends DataGrid
{
    use FiltersDataGridByCompany;
    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('cms_nav_menus')
            ->leftJoin('companies as c', 'cms_nav_menus.company_id', '=', 'c.id')
            ->select(
                'cms_nav_menus.id',
                'cms_nav_menus.name',
                'cms_nav_menus.key',
                'cms_nav_menus.company_id',
                'cms_nav_menus.deleted_at',
                DB::raw('COALESCE(c.name, "") as company_name'),
            );

        $this->addFilter('id', 'cms_nav_menus.id');
        $this->addFilter('name', 'cms_nav_menus.name');
        $this->addFilter('key', 'cms_nav_menus.key');
        $this->addFilter('company_id', 'cms_nav_menus.company_id');
        $this->addFilter('deleted_at', 'cms_nav_menus.deleted_at');

        return $this->applyCompanyTabScope($queryBuilder, 'cms_nav_menus.company_id');
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.nav-menus.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('cms::app.nav-menus.datagrid.name'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'key',
            'label'      => trans('cms::app.nav-menus.datagrid.key'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.nav-menus.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.nav-menus.edit')) {
            $this->addAction([
                'index'  => 'items',
                'icon'   => 'icon-menu',
                'title'  => trans('cms::app.nav-menus.datagrid.items'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.nav-menus.items.index', $row->id),
            ]);

            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.nav-menus.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.nav-menus.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.nav-menus.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.nav-menus.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.nav-menus.delete', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.nav-menus.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.nav-menus.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.nav-menus.restore', $row->id) : null,
            ]);
        }

        if (bouncer()->hasPermission('cms.nav-menus.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.nav-menus.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.nav-menus.forceDelete', $row->id) : null,
            ]);
        }
    }
}
