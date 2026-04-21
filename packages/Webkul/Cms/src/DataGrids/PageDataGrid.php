<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class PageDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

        $queryBuilder = DB::table('cms_pages')
            ->leftJoin('cms_page_translations as cpt', function ($join) use ($locale) {
                $join->on('cms_pages.id', '=', 'cpt.cms_page_id')
                    ->where('cpt.locale', '=', $locale);
            })
            ->addSelect(
                'cms_pages.id',
                'cms_pages.slug',
                'cms_pages.name',
                'cms_pages.type',
                'cms_pages.status',
                'cms_pages.is_active',
                'cms_pages.order',
                'cms_pages.published_at',
                DB::raw('COALESCE(cpt.title, "") as title')
            );

        $this->addFilter('id', 'cms_pages.id');
        $this->addFilter('slug', 'cms_pages.slug');
        $this->addFilter('name', 'cms_pages.name');
        $this->addFilter('type', 'cms_pages.type');
        $this->addFilter('status', 'cms_pages.status');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.pages.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('cms::app.pages.datagrid.title'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'slug',
            'label'      => trans('cms::app.pages.datagrid.slug'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'type',
            'label'      => trans('cms::app.pages.datagrid.type'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('cms::app.pages.datagrid.status'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.pages.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.pages.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.pages.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => route('admin.cms.pages.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.pages.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.pages.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => route('admin.cms.pages.delete', $row->id),
            ]);
        }
    }
}

