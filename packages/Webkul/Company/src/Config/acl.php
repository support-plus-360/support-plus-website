<?php

return [
    [
        'key'   => 'company',
        'name'  => 'Company',
        'route' => 'admin.company.index',
        'sort'  => 2
    ],
    [
        'key'   => 'company.create',
        'name'  => 'Create',
        'route' => ['admin.company.create', 'admin.company.store'],
        'sort'  => 1,
    ],
    [
        'key'   => 'company.edit',
        'name'  => 'Edit',
        'route' => ['admin.company.edit', 'admin.company.update'],
        'sort'  => 2,
    ],
    [
        'key'   => 'company.delete',
        'name'  => 'Delete',
        'route' => 'admin.company.delete',
        'sort'  => 3,
    ],
    [
        'key'   => 'company.restore',
        'name'  => 'Restore',
        'route' => 'admin.company.restore',
        'sort'  => 4,
    ],
    [
        'key'   => 'company.forceDelete',
        'name'  => 'Force Delete',
        'route' => 'admin.company.forceDelete',
        'sort'  => 5,
    ]
];
