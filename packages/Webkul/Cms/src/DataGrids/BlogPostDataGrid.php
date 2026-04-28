<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class BlogPostDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

        $bcpFirst = DB::table('cms_blog_category_post')
            ->select(
                'cms_blog_post_id',
                DB::raw('MIN(cms_blog_category_id) as min_cms_blog_category_id')
            )
            ->groupBy('cms_blog_post_id');

        $queryBuilder = DB::table('cms_blog_posts')
            ->leftJoin('cms_blog_post_translations as cbt', function ($join) use ($locale) {
                $join->on('cms_blog_posts.id', '=', 'cbt.cms_blog_post_id')
                    ->where('cbt.locale', '=', $locale);
            })
            ->leftJoin('companies as c', function ($join) {
                $join->on('cms_blog_posts.company_id', '=', 'c.id');
            })
            ->leftJoinSub($bcpFirst, 'bcp_first', 'cms_blog_posts.id', '=', 'bcp_first.cms_blog_post_id')
            ->leftJoin('cms_blog_categories as bcat', 'bcp_first.min_cms_blog_category_id', '=', 'bcat.id')
            ->addSelect(
                'cms_blog_posts.id',
                'cms_blog_posts.slug',
                'cms_blog_posts.status',
                'cms_blog_posts.published_at',
                'cms_blog_posts.views_count',
                'cms_blog_posts.is_active',
                'cms_blog_posts.is_featured',
                'cms_blog_posts.deleted_at',
                'cms_blog_posts.company_id',
                DB::raw('COALESCE(cbt.title, "") as title'),
                DB::raw('COALESCE(c.name, "") as company_name'),
                DB::raw('COALESCE(bcat.name, "") as category_name'),
            );

        $this->addFilter('id', 'cms_blog_posts.id');
        $this->addFilter('slug', 'cms_blog_posts.slug');
        $this->addFilter('status', 'cms_blog_posts.status');
        $this->addFilter('published_at', 'cms_blog_posts.published_at');
        $this->addFilter('views_count', 'cms_blog_posts.views_count');
        $this->addFilter('is_active', 'cms_blog_posts.is_active');
        $this->addFilter('is_featured', 'cms_blog_posts.is_featured');
        $this->addFilter('deleted_at', 'cms_blog_posts.deleted_at');
        $this->addFilter('company_id', 'cms_blog_posts.company_id');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.blog-posts.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'title',
            'label'      => trans('cms::app.blog-posts.datagrid.title'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'slug',
            'label'      => trans('cms::app.blog-posts.datagrid.slug'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'category_name',
            'label'      => trans('cms::app.blog-posts.datagrid.category'),
            'type'       => 'string',
            'filterable' => false,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'status',
            'label'      => trans('cms::app.blog-posts.datagrid.status'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'published_at',
            'label'      => trans('cms::app.blog-posts.datagrid.published_at'),
            'type'       => 'datetime',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'views_count',
            'label'      => trans('cms::app.blog-posts.datagrid.views'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.blog-posts.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_featured',
            'label'      => trans('cms::app.blog-posts.datagrid.featured'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('cms::app.blog-posts.datagrid.active'),
            'type'       => 'boolean',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.blog-posts.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('cms::app.blog-posts.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.blog-posts.edit', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.blog-posts.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.blog-posts.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.cms.blog-posts.delete', $row->id),
            ]);
        }

        if (bouncer()->hasPermission('cms.blog-posts.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('cms::app.blog-posts.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.blog-posts.restore', $row->id) : null,
            ]);
        }

        if (bouncer()->hasPermission('cms.blog-posts.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('cms::app.blog-posts.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.cms.blog-posts.forceDelete', $row->id) : null,
            ]);
        }
    }
}
