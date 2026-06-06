<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\Cms\Concerns\FiltersDataGridByCompany;
use Webkul\DataGrid\DataGrid;

class LinkDataGrid extends DataGrid
{
    use FiltersDataGridByCompany;
    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

            $queryBuilder = DB::table('cms_links')
 	           ->leftJoin('cms_link_translations as clt', function ($join) use ($locale) {
                $join->on('cms_links.id', '=', 'clt.cms_link_id')
                    ->where('clt.locale', '=', $locale);
            }) ->leftJoin('companies as c', function ($join) {
                $join->on('cms_links.company_id', '=', 'c.id');
            })
             ->leftJoin('cms_sections as cs', function ($join) {
                $join->on('cms_links.linkable_id', '=', 'cs.id');
            })
            ->addSelect(
                'cms_links.id',
                'cms_links.linkable_id',
                'cms_links.linkable_type',
                'cms_links.link',
                'cms_links.icon',
                'cms_links.target',
                'cms_links.order',
                'cms_links.is_active',
                'cms_links.deleted_at',
		'cms_links.deleted_at',
		'cms_links.company_id',
		DB::raw('COALESCE(c.name, "") as company_name'),
		DB::raw('COALESCE(cs.name, "") as section_name'),
		DB::raw('COALESCE(clt.name, "") as name'),

            )
           ;

        $this->addFilter('id', 'cms_links.id');
        $this->addFilter('linkable_id', 'cms_links.linkable_id');
        $this->addFilter('linkable_type', 'cms_links.linkable_type');
        $this->addFilter('link', 'cms_links.link');
        $this->addFilter('icon', 'cms_links.icon');
        $this->addFilter('target', 'cms_links.target');
        $this->addFilter('order', 'cms_links.order');
        $this->addFilter('is_active', 'cms_links.is_active');
        $this->addFilter('deleted_at', 'cms_links.deleted_at');
        $this->addFilter('company_id', 'cms_links.company_id');

        return $this->applyCompanyTabScope($queryBuilder, 'cms_links.company_id');
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.links.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('cms::app.links.datagrid.name'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'section_name',
            'label'      => trans('cms::app.links.datagrid.linkable'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.links.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'linkable_type',
            'label'      => trans('cms::app.links.datagrid.type'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.links.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.links.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.links.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.links.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.links.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.links.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.links.delete', $row->id),
            ]);
        }

//         if (bouncer()->hasPermission('cms.items.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.links.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.links.restore', $row->id) : null,
            ]);
//         }

//         if (bouncer()->hasPermission('cms.links.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.links.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.links.forceDelete', $row->id) : null,
            ]);
//         }
    }
}
