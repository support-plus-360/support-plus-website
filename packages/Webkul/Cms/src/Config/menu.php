<?php

return [
    [
        'key'        => 'cms',
        'name'       => 'cms::app.menu.cms',
        'route'      => 'admin.cms.pages.index',
        'sort'       => 2,
        'icon-class' => 'icon-cms',
    ], [
        'key'        => 'cms.pages',
        'name'       => 'cms::app.menu.pages',
        'route'      => 'admin.cms.pages.index',
        'sort'       => 1,
        'icon-class' => 'icon-file',
    ],
    [
        'key'        => 'cms.sections',
        'name'       => 'cms::app.menu.sections',
        'route'      => 'admin.cms.sections.index',
        'sort'       => 2,
        'icon-class' => 'icon-file',
    ],
	[
		'key'        => 'cms.items',
		'name'       => 'cms::app.menu.items',
		'route'      => 'admin.cms.items.index',
		'sort'       => 3,
		'icon-class' => 'icon-file',
	],
	[
		'key'        => 'cms.links',
		'name'       => 'cms::app.menu.links',
		'route'      => 'admin.cms.links.index',
		'sort'       => 4,
		'icon-class' => 'icon-file',
	],
	[
		'key'        => 'cms.blog-categories',
		'name'       => 'cms::app.menu.blog-categories',
		'route'      => 'admin.cms.blog-categories.index',
		'sort'       => 5,
		'icon-class' => 'icon-file',
	],
];
