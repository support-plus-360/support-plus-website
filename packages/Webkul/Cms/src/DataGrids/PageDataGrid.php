<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\Cms\Concerns\FiltersDataGridByCompany;
use Webkul\DataGrid\DataGrid;

class PageDataGrid extends DataGrid
{
    use FiltersDataGridByCompany;
    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

        $queryBuilder = DB::table('cms_pages')
            ->leftJoin('cms_page_translations as cpt', function ($join) use ($locale) {
                $join->on('cms_pages.id', '=', 'cpt.cms_page_id')
                    ->where('cpt.locale', '=', $locale);
            })
            ->leftJoin('cms_sections as cs', function ($join) {
                $join->on('cms_pages.id', '=', 'cs.page_id')
                    ->whereNull('cs.deleted_at');
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
		'cms_pages.company_id',
		'cms_pages.deleted_at',
                DB::raw('COALESCE(cpt.title, "") as title'),
		DB::raw('COALESCE(c.name, "") as company_name'),
                DB::raw('COUNT(cs.id) as sections_count')
            )
            ->leftJoin('companies as c', function ($join) {
                $join->on('cms_pages.company_id', '=', 'c.id');
            })
            ->groupBy(
                'cms_pages.id',
                'cms_pages.slug',
                'cms_pages.name',
                'cms_pages.type',
                'cms_pages.status',
                'cms_pages.is_active',
                'cms_pages.order',
                'cms_pages.published_at',
                'cms_pages.company_id',
                'cms_pages.deleted_at',
                'cpt.title',
                'c.name'
            );

        $this->addFilter('id', 'cms_pages.id');
        $this->addFilter('slug', 'cms_pages.slug');
        $this->addFilter('name', 'cms_pages.name');
        $this->addFilter('type', 'cms_pages.type');
        $this->addFilter('status', 'cms_pages.status');
        $this->addFilter('company_id', 'cms_pages.company_id');

        return $this->applyCompanyTabScope($queryBuilder, 'cms_pages.company_id');
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
            'index'      => 'company_name',
            'label'      => trans('cms::app.pages.datagrid.company'),
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
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.pages.edit', $row->id),
            ]);

            $this->addAction([
                'index'  => 'builder',
                'icon'   => 'icon-folder',
                'title'  => trans('cms::app.pages.builder.open-btn'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.pages.builder', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.pages.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.pages.datagrid.delete'),
                'method' => 'DELETE',
                'disabled' => true,
                'disabled_title' => trans('cms::app.pages.messages.cannot-delete-has-sections'),
                'url'    => fn ($row) => $row->deleted_at || ((int) ($row->sections_count ?? 0) > 0) ? null : route('admin.cms.pages.delete', $row->id),
            ]);
        }


//         if (bouncer()->hasPermission('cms.pages.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.pages.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.pages.restore', $row->id) : null,
            ]);
//         }

//         if (bouncer()->hasPermission('cms.pages.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.pages.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.pages.forceDelete', $row->id) : null,
            ]);
//         }
    }
}

