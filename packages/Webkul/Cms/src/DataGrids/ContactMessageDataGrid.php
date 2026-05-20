<?php

namespace Webkul\Cms\DataGrids;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class ContactMessageDataGrid extends DataGrid
{
    public function prepareQueryBuilder(): Builder
    {
        $queryBuilder = DB::table('cms_contact_messages')
            ->leftJoin('companies as c', 'cms_contact_messages.company_id', '=', 'c.id')
            ->addSelect(
                'cms_contact_messages.id',
                'cms_contact_messages.company_id',
                'cms_contact_messages.name',
                'cms_contact_messages.email',
                'cms_contact_messages.phone',
                'cms_contact_messages.message',
                'cms_contact_messages.created_at',
                DB::raw('COALESCE(c.name, "") as company_name'),
            );

        $this->addFilter('id', 'cms_contact_messages.id');
        $this->addFilter('company_id', 'cms_contact_messages.company_id');
        $this->addFilter('name', 'cms_contact_messages.name');
        $this->addFilter('email', 'cms_contact_messages.email');
        $this->addFilter('phone', 'cms_contact_messages.phone');
        $this->addFilter('created_at', 'cms_contact_messages.created_at');

        return $queryBuilder;
    }

    public function prepareColumns(): void
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('cms::app.contact-messages.datagrid.id'),
            'type'       => 'integer',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'company_name',
            'label'      => trans('cms::app.contact-messages.datagrid.company'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('cms::app.contact-messages.datagrid.name'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'email',
            'label'      => trans('cms::app.contact-messages.datagrid.email'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'phone',
            'label'      => trans('cms::app.contact-messages.datagrid.phone'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => true,
        ]);

        $this->addColumn([
            'index'      => 'message',
            'label'      => trans('cms::app.contact-messages.datagrid.message'),
            'type'       => 'string',
            'filterable' => true,
            'sortable'   => false,
        ]);

        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('cms::app.contact-messages.datagrid.created_at'),
            'type'       => 'datetime',
            'filterable' => true,
            'sortable'   => true,
        ]);
    }

    public function prepareActions(): void
    {
        if (bouncer()->hasPermission('cms.contact-messages.delete')) {
            $this->addAction([
                'index'  => 'delete',
                'icon'   => 'icon-delete',
                'title'  => trans('cms::app.contact-messages.datagrid.delete'),
                'method' => 'DELETE',
                'url'    => fn ($row) => route('admin.cms.contact-messages.delete', $row->id),
            ]);
        }
    }
}
