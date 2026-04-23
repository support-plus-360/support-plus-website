<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class ItemDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

        $queryBuilder = DB::table('cms_items')
 	->leftJoin('cms_item_translations as cit', function ($join) use ($locale) {
                $join->on('cms_items.id', '=', 'cit.cms_item_id')
                    ->where('cit.locale', '=', $locale);
            }) ->leftJoin('companies as c', function ($join) {
                $join->on('cms_items.company_id', '=', 'c.id');
            })
             ->leftJoin('cms_sections as cs', function ($join) {
                $join->on('cms_items.section_id', '=', 'cs.id');
            })
            ->addSelect(
                'cms_items.id',
                'cms_items.section_id',
                'cms_items.type',
                'cms_items.is_active',
                'cms_items.order',
		'cms_items.deleted_at',
		'cms_items.company_id',
		DB::raw('COALESCE(c.name, "") as company_name'),
		DB::raw('COALESCE(cs.name, "") as section_name'),
		DB::raw('COALESCE(cit.title, "") as title'),
		
            )
           ;

        $this->addFilter('id', 'cms_items.id');
        $this->addFilter('section_id', 'cms_items.section_id');
        $this->addFilter('type', 'cms_items.type');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.items.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('cms::app.items.datagrid.title'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'section_name',
            'label'      => trans('cms::app.items.datagrid.section'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.items.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'type',
            'label'      => trans('cms::app.items.datagrid.type'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.items.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.items.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.items.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.items.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.items.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.items.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.items.delete', $row->id),
            ]);
        }

//         if (bouncer()->hasPermission('cms.items.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.items.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.items.restore', $row->id) : null,
            ]);
//         }

//         if (bouncer()->hasPermission('cms.items.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.items.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.items.forceDelete', $row->id) : null,
            ]);
//         }
    }
}

