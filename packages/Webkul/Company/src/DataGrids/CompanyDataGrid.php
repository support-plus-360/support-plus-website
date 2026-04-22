<?php

namespace Webkul\Company\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class CompanyDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $locale = app()->getLocale();

        $queryBuilder = DB::table('companies')
            ->addSelect(
                'companies.id',
                'companies.name',
                'companies.created_at',
                'companies.updated_at',
                'companies.deleted_at',
                'companies.is_active',
                'companies.configs',
            );

        $this->addFilter('id', 'companies.id');
        $this->addFilter('name', 'companies.name');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('company::app.companies.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('company::app.companies.datagrid.name'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

       

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('company::app.companies.datagrid.created_at'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'is_active',
            'label'      => trans('company::app.companies.datagrid.active'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'configs',
            'label'      => trans('company::app.companies.datagrid.configs'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
//         if (bouncer()->hasPermission('company.edit')) {
            $this->addAction([
                'index'  => 'edit',
                'icon'   => 'icon-edit',
                'title'  => trans('company::app.companies.datagrid.edit'),
                'method' => 'GET',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.company.edit', $row->id),
            ]);
//         }

//         if (bouncer()->hasPermission('company.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('company::app.companies.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? null : route('admin.company.delete', $row->id),
            ]);
//         }

//         if (bouncer()->hasPermission('company.restore')) {
            $this->addAction([
                'index'  => 'restore',
                'icon'   => 'icon-restore',
                'title'  => trans('company::app.companies.datagrid.restore'),
                'method' => 'POST',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.company.restore', $row->id) : null,
            ]);
//         }

//         if (bouncer()->hasPermission('company.forceDelete')) {
            $this->addAction([
                'index'  => 'forceDelete',
                'icon'   => 'icon-forceDelete',
                'title'  => trans('company::app.companies.datagrid.forceDelete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => $row->deleted_at ? route('admin.company.forceDelete', $row->id) : null,
            ]);
//         }
    }
}

