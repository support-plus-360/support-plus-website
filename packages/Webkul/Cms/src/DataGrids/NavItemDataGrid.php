<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class NavItemDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();
        $menuId = (int) request()->route('menuId');

        $queryBuilder = DB::table('cms_nav_items')
            ->leftJoin('cms_nav_item_translations as nit', function ($join) use ($locale) {
                $join->on('cms_nav_items.id', '=', 'nit.cms_nav_item_id')
                    ->where('nit.locale', '=', $locale);
            })
            ->leftJoin('cms_pages as p', 'cms_nav_items.cms_page_id', '=', 'p.id')
            ->leftJoin('cms_page_translations as pt', function ($join) use ($locale) {
                $join->on('p.id', '=', 'pt.cms_page_id')
                    ->where('pt.locale', '=', $locale);
            })
            ->leftJoin('cms_nav_items as parent', 'cms_nav_items.parent_id', '=', 'parent.id')
            ->where('cms_nav_items.menu_id', $menuId)
            ->select(
                'cms_nav_items.id',
                'cms_nav_items.menu_id',
                'cms_nav_items.parent_id',
                'cms_nav_items.url',
                'cms_nav_items.order',
                'cms_nav_items.is_active',
                'cms_nav_items.open_in_new_tab',
                'cms_nav_items.deleted_at',
                DB::raw('COALESCE(nit.label, pt.title, p.name, "") as label'),
                DB::raw('COALESCE(p.slug, "") as page_slug'),
                DB::raw('parent.id as parent_exists'),
            );

        $this->addFilter('id', 'cms_nav_items.id');
        $this->addFilter('label', DB::raw('COALESCE(nit.label, pt.title, p.name, "")'));
        $this->addFilter('is_active', 'cms_nav_items.is_active');
        $this->addFilter('order', 'cms_nav_items.order');
        $this->addFilter('deleted_at', 'cms_nav_items.deleted_at');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $menuId = (int) request()->route('menuId');

        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.nav-items.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'label',
            'label'      => trans('cms::app.nav-items.datagrid.label'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'page_slug',
            'label'      => trans('cms::app.nav-items.datagrid.page'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'url',
            'label'      => trans('cms::app.nav-items.datagrid.url'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'parent_id',
            'label'      => trans('cms::app.nav-items.datagrid.parent'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
            'closure'    => fn ($row) => $row->parent_id ? '#'.$row->parent_id : '—',
        ]);

        $this->addColumn([
            'index'      => 'order',
            'label'      => trans('cms::app.nav-items.datagrid.order'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.nav-items.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        $menuId = (int) request()->route('menuId');

        if (bouncer()->hasPermission('cms.nav-menus.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.nav-items.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.nav-menus.items.edit', [$menuId, $row->id]),
            ]);
        }

        if (bouncer()->hasPermission('cms.nav-menus.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.nav-items.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.nav-menus.items.delete', [$menuId, $row->id]),
            ]);
        }

        if (bouncer()->hasPermission('cms.nav-menus.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.nav-items.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.nav-menus.items.restore', [$menuId, $row->id]) : null,
            ]);
        }

        if (bouncer()->hasPermission('cms.nav-menus.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.nav-items.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.nav-menus.items.forceDelete', [$menuId, $row->id]) : null,
            ]);
        }
    }
}
