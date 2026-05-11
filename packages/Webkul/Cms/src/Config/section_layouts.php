<?php

/**
 * Static section layouts for the page builder.
 * The selected key is persisted on cms_sections.section_layout.
 *
 * Live preview markup, captions, and reference images are defined in
 * `cms_section_layout_renderers.php` (config key `cms.section_layout_renderers`).
 * Run `php artisan vendor:publish --tag=cms-builder-layout-previews` to copy
 * default preview images into `public/vendor/webkul/cms/builder-layout-previews/`.
 */
return [
    'default' => 'home_hero',

    'layouts' => [
        'home_hero' => [
            'label'       => 'Home Hero',
            'description' => 'Home Hero section',
        ],
        '3_items_in_row_section_style_1' => [
            'label'       => '3 Items in Row Section Style 1',
            'description' => '3 Items in Row Section Style 1 section',
        ],
        '3_items_in_row_section_style_2' => [
            'label'       => '3 Items in Row Section Style 2',
            'description' => '3 Items in Row Section Style 2 section',
        ],
        'left_image_section_style_1' => [
            'label'       => 'Left Image Section Style 1',
            'description' => 'Left Image Section Style 1 section',
        ],
        'two_items_in_row_section_style_1' => [
            'label'       => 'Two Items in Row Section Style 1',
            'description' => 'Two Items in Row Section Style 1 section',
        ],
    ],
];
