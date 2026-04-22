<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class SectionDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

        $queryBuilder = DB::table('cms_sections')
            ->leftJoin('cms_section_translations as cst', function ($join) use ($locale) {
                $join->on('cms_sections.id', '=', 'cst.cms_section_id')
                    ->where('cst.locale', '=', $locale);
            })
            ->leftJoin('cms_pages as cp', function ($join) {
                $join->on('cms_sections.page_id', '=', 'cp.id');
            })
            ->addSelect(
                'cms_sections.id',
                'cms_sections.page_id',
                'cms_sections.type',
                'cms_sections.template',
                'cms_sections.settings',
                'cms_sections.order',
                'cms_sections.is_active',
                'cms_sections.company_id',
                DB::raw('COALESCE(cst.title, "") as title'),
                DB::raw('COALESCE(cp.name, "") as page_name')
            )
            ->leftJoin('companies as c', function ($join) {
                $join->on('cms_sections.company_id', '=', 'c.id');
            })
            ->orderBy('cms_sections.order', 'asc');

        $this->addFilter('id', 'cms_sections.id');
        $this->addFilter('page_name', 'cms_sections.page_name');
        $this->addFilter('type', 'cms_sections.type');
        $this->addFilter('template', 'cms_sections.template');
        $this->addFilter('settings', 'cms_sections.settings');
        $this->addFilter('order', 'cms_sections.order');
        $this->addFilter('is_active', 'cms_sections.is_active');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.sections.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

	$this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.sections.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('cms::app.sections.datagrid.title'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'page_name',
            'label'      => trans('cms::app.sections.datagrid.page'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'type',
            'label'      => trans('cms::app.sections.datagrid.type'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'order',
            'label'      => trans('cms::app.sections.datagrid.order'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.sections.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.sections.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.sections.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => route('admin.cms.sections.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.sections.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.sections.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => route('admin.cms.sections.delete', $row->id),
            ]);
        }
    }
}

