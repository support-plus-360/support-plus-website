<?php

return [
    'menu' => [
        'cms'   => 'CMS',
        'pages' => 'Pages',
        'sections' => 'Sections',
	'items' => 'Items',
    ],

    'acl' => [
        'cms'    => 'CMS',
        'pages'  => 'Pages',
        'sections' => 'Sections',
	'items' => 'Items',
        'create' => 'Create',
        'edit'   => 'Edit',
        'delete' => 'Delete',
	'restore' => 'Restore',
	'forceDelete' => 'Force Delete',
    ],

    'pages' => [
        'index' => [
            'title'      => 'Pages',
            'create-btn' => 'Create Page',
        ],

        'create' => [
            'title'    => 'Create Page',
            'save-btn' => 'Save Page',
        ],

        'edit' => [
            'title'    => 'Edit Page',
            'save-btn' => 'Save Page',
        ],

        'form' => [
            'general'          => 'General',
            'translations'     => 'Translations',
            'slug'             => 'Slug',
            'name'             => 'Internal Name',
            'type'             => 'Type',
            'status'           => 'Status',
            'active'           => 'Active',
            'order'            => 'Order',
            'published_at'     => 'Published At',
            'author_id'        => 'Author',
            'company'          => 'Company',
            'title'            => 'Title',
            'meta_description' => 'Meta Description',
            'meta_keywords'    => 'Meta Keywords',
        ],

        'datagrid' => [
            'id'     => 'ID',
            'title'  => 'Title',
            'slug'   => 'Slug',
            'type'   => 'Type',
            'status' => 'Status',
            'active' => 'Active',
            'edit'   => 'Edit',
            'delete' => 'Delete',
            'company' => 'Company',
        ],

        'messages' => [
            'create-success' => 'Page created successfully.',
            'update-success' => 'Page updated successfully.',
            'delete-success' => 'Page deleted successfully.',
            'cannot-delete-has-sections' => 'This page has sections. Delete sections first.',
        ],
    ],

    'sections' => [
        'index' => [
            'title'      => 'Sections',
            'create-btn' => 'Create Section',
        ],

        'create' => [
            'title'    => 'Create Section',
            'save-btn' => 'Save Section',
        ],

        'edit' => [
            'title'    => 'Edit Section',
            'save-btn' => 'Save Section',
        ],

        'form' => [
            'general'          => 'General',
            'translations'     => 'Translations',
            'name'             => 'Name',
            'type'             => 'Type',
            'template'         => 'Template',
            'settings'         => 'Settings',
            'active'           => 'Active',
            'order'            => 'Order',
	'company'          => 'Company',
	'page'             => 'Page',
	'title_en'         => 'Title (English)',
	'subtitle_en'      => 'Subtitle (English)',
	'description_en'   => 'Description (English)',
	'title_ar'         => 'Title (Arabic)',
	'subtitle_ar'      => 'Subtitle (Arabic)',
	'description_ar'   => 'Description (Arabic)',
        ],

        'datagrid' => [
          'id'     => 'ID',
          'name'   => 'Name',
	'title'  => 'Title',
	'slug'   => 'Slug',
	'page'   => 'Page',
	'order'  => 'Order',
          'type'   => 'Type',
          'template' => 'Template',
          'settings' => 'Settings',
	'active' => 'Active',
	'order' => 'Order',
	'edit' => 'Edit',
	'delete' => 'Delete',
	'company' => 'Company',
        ],

        'messages' => [
            'create-success' => 'Section created successfully.',
            'update-success' => 'Section updated successfully.',
            'delete-success' => 'Section deleted successfully.',
            'cannot-delete-has-items' => 'This section has items. Delete items first.',
        ],
    ],

	'items' => [
		'index' => [
			'title' => 'Items',
			'create-btn' => 'Create Item',
		],
		'create' => [
			'title' => 'Create Item',
			'save-btn' => 'Save Item',
		],
		'edit' => [
			'title' => 'Edit Item',
			'save-btn' => 'Save Item',
		],
		'form' => [
			'general' => 'General',
			'translations' => 'Translations',
			'section' => 'Section',
			'type' => 'Type',
			'active' => 'Active',
			'order' => 'Order',
			'company' => 'Company',
			'title' => 'Title',
			'sub_title' => 'Sub Title',
			'content' => 'Content',
			'icon' => 'Icon',
		],
		'datagrid' => [
			'id' => 'ID',
			'title' => 'Title',
			'slug' => 'Slug',
			'type' => 'Type',
			'active' => 'Active',
			'edit' => 'Edit',
			'delete' => 'Delete',
			'company' => 'Company',
			'section' => 'Section',
		],
		'messages' => [
			'create-success' => 'Item created successfully.',
			'update-success' => 'Item updated successfully.',
			'delete-success' => 'Item deleted successfully.',
		],
	],
];

