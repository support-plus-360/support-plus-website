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
    ], [
        'key'   => 'cms.nav-menus',
        'name'  => 'cms::app.menu.nav-menus',
        'route' => ['admin.cms.nav-menus.index', 'admin.cms.api.nav-menus.index', 'admin.cms.api.nav-menus.show'],
        'sort'  => 5,
    ], [
        'key'   => 'cms.nav-menus.create',
        'name'  => 'cms::app.acl.create',
        'route' => ['admin.cms.nav-menus.create', 'admin.cms.nav-menus.store'],
        'sort'  => 1,
    ], [
        'key'   => 'cms.nav-menus.edit',
        'name'  => 'cms::app.acl.edit',
        'route' => [
            'admin.cms.nav-menus.edit',
            'admin.cms.nav-menus.update',
            'admin.cms.nav-menus.items.index',
            'admin.cms.nav-menus.items.create',
            'admin.cms.nav-menus.items.store',
            'admin.cms.nav-menus.items.edit',
            'admin.cms.nav-menus.items.update',
        ],
        'sort'  => 2,
    ], [
        'key'   => 'cms.nav-menus.delete',
        'name'  => 'cms::app.acl.delete',
        'route' => [
            'admin.cms.nav-menus.delete',
            'admin.cms.nav-menus.items.delete',
        ],
        'sort'  => 3,
    ], [
        'key'   => 'cms.nav-menus.restore',
        'name'  => 'cms::app.acl.restore',
        'route' => [
            'admin.cms.nav-menus.restore',
            'admin.cms.nav-menus.items.restore',
        ],
        'sort'  => 4,
    ], [
        'key'   => 'cms.nav-menus.forceDelete',
        'name'  => 'cms::app.acl.forceDelete',
        'route' => [
            'admin.cms.nav-menus.forceDelete',
            'admin.cms.nav-menus.items.forceDelete',
        ],
        'sort'  => 5,
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
