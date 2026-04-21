<?php

return [
    [
        'key'   => 'cms',
        'name'  => 'cms::app.acl.cms',
        'route' => 'admin.cms.pages.index',
        'sort'  => 2,
    ], [
        'key'   => 'cms.pages',
        'name'  => 'cms::app.acl.pages',
        'route' => ['admin.cms.pages.index', 'admin.cms.api.pages.index', 'admin.cms.api.pages.show'],
        'sort'  => 1,
    ], [
        'key'   => 'cms.pages.create',
        'name'  => 'cms::app.acl.create',
        'route' => ['admin.cms.pages.create', 'admin.cms.pages.store', 'admin.cms.api.pages.store'],
        'sort'  => 2,
    ], [
        'key'   => 'cms.pages.edit',
        'name'  => 'cms::app.acl.edit',
        'route' => ['admin.cms.pages.edit', 'admin.cms.pages.update', 'admin.cms.api.pages.update'],
        'sort'  => 3,
    ], [
        'key'   => 'cms.pages.delete',
        'name'  => 'cms::app.acl.delete',
        'route' => ['admin.cms.pages.delete', 'admin.cms.api.pages.destroy'],
        'sort'  => 4,
    ],
];
