<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class BlogCategoryDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

        $queryBuilder = DB::table('cms_blog_categories')
 	->leftJoin('cms_blog_category_translations as cbt', function ($join) use ($locale) {
                $join->on('cms_blog_categories.id', '=', 'cbt.cms_blog_category_id')
                    ->where('cbt.locale', '=', $locale);
            }) ->leftJoin('companies as c', function ($join) {
                $join->on('cms_blog_categories.company_id', '=', 'c.id');
            })
            ->addSelect(
                'cms_blog_categories.id',
'cms_blog_categories.name',
                'cms_blog_categories.slug',
                'cms_blog_categories.is_active',
                'cms_blog_categories.order',
		'cms_blog_categories.deleted_at',
		'cms_blog_categories.company_id',
		DB::raw('COALESCE(c.name, "") as company_name'),
		DB::raw('COALESCE(cbt.title, "") as title'),

            )
           ;

        $this->addFilter('id', 'cms_blog_categories.id');
        $this->addFilter('name', 'cms_blog_categories.name');
        $this->addFilter('slug', 'cms_blog_categories.slug');
        $this->addFilter('is_active', 'cms_blog_categories.is_active');
        $this->addFilter('order', 'cms_blog_categories.order');
        $this->addFilter('deleted_at', 'cms_blog_categories.deleted_at');
        $this->addFilter('company_id', 'cms_blog_categories.company_id');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.blog-categories.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('cms::app.blog-categories.datagrid.name'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('cms::app.blog-categories.datagrid.title'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.blog-categories.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.blog-categories.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.blog-categories.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.blog-categories.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.blog-categories.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.blog-categories.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.blog-categories.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.blog-categories.delete', $row->id),
            ]);
        }

            if (bouncer()->hasPermission('cms.blog-categories.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.blog-categories.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.blog-categories.restore', $row->id) : null,
            ]);
        }

            if (bouncer()->hasPermission('cms.blog-categories.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.blog-categories.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.blog-categories.forceDelete', $row->id) : null,
            ]);
        }
    }
}
