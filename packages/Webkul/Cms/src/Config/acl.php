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
        'route' => [
            'admin.cms.pages.edit',
            'admin.cms.pages.update',
            'admin.cms.pages.builder',
            'admin.cms.pages.builder.update',
            'admin.cms.builder.layout-preview',
            'admin.cms.api.pages.update',
            'admin.cms.api.pages.builder',
        ],
        'sort'  => 3,
    ], [
        'key'   => 'cms.pages.delete',
        'name'  => 'cms::app.acl.delete',
        'route' => ['admin.cms.pages.delete', 'admin.cms.api.pages.destroy'],
        'sort'  => 4,
    ],
    [
        'key'   => 'cms.blog-posts',
        'name'  => 'cms::app.menu.blog-posts',
        'route' => 'admin.cms.blog-posts.index',
        'sort'  => 10,
    ],
    [
        'key'   => 'cms.blog-posts.create',
        'name'  => 'cms::app.acl.create',
        'route' => ['admin.cms.blog-posts.create', 'admin.cms.blog-posts.store'],
        'sort'  => 1,
    ],
    [
        'key'   => 'cms.blog-posts.edit',
        'name'  => 'cms::app.acl.edit',
        'route' => ['admin.cms.blog-posts.edit', 'admin.cms.blog-posts.update'],
        'sort'  => 2,
    ],
    [
        'key'   => 'cms.blog-posts.delete',
        'name'  => 'cms::app.acl.delete',
        'route' => ['admin.cms.blog-posts.delete', 'admin.cms.blog-posts.restore', 'admin.cms.blog-posts.forceDelete'],
        'sort'  => 3,
    ],
    [
        'key'   => 'cms.blog-posts.restore',
        'name'  => 'cms::app.acl.restore',
        'route' => 'admin.cms.blog-posts.restore',
        'sort'  => 4,
    ],
    [
        'key'   => 'cms.blog-posts.forceDelete',
        'name'  => 'cms::app.acl.forceDelete',
        'route' => 'admin.cms.blog-posts.forceDelete',
        'sort'  => 5,
    ],
];
