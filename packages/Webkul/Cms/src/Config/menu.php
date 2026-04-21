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
];
