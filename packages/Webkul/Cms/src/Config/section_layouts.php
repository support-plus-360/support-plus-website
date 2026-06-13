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
    'default' => 'hero_section_style_1',

    'layouts' => [
        'hero_section_style_1' => [
            'label'       => 'Hero Section Style 1',
            'description' => 'Hero Section Style 1 section',
        ],
        '3_items_in_row_section_style_1' => [
            'label'       => '3 Items in Row Section Style 1',
            'description' => '3 Items in Row Section Style 1 section',
        ],
        '3_items_in_row_section_style_2' => [
            'label'       => '3 Items in Row Section Style 2',
            'description' => '3 Items in Row Section Style 2 section',
        ],

	'3_items_in_row_section_style_3' => [
            'label'       => '3 Items in Row Section Style 3',
            'description' => '3 Items in Row Section Style 3 section',
        ],

	'3_items_in_row_section_style_4' => [
            'label'       => '3 Items in Row Section Style 4',
            'description' => '3 Items in Row Section Style 4 section',
        ],

	'3_items_in_row_section_style_5' => [
            'label'       => '3 Items in Row Section Style 5',
            'description' => '3 Items in Row Section Style 5 section',
        ],

        'left_image_section_style_1' => [
            'label'       => 'Left Image Section Style 1',
            'description' => 'Left Image Section Style 1 section',
        ],
        'two_items_in_row_section_style_1' => [
            'label'       => 'Two Items in Row Section Style 1',
            'description' => 'Two Items in Row Section Style 1 section',
        ],
	'info_section' => [
            'label'       => 'Info Section',
            'description' => 'Info Section section',
        ],
	'right_image_section_style_1' => [
            'label'       => 'Right Image Section Style 1',
            'description' => 'Right Image Section Style 1 section',
        ],
	'right_testimonial_section' => [
            'label'       => 'Right Testimoial Section',
            'description' => 'Right Testimoial Section ',
        ],
	'left_image_section_style_2' => [
            'label'       => 'Left Image Section Style 2',
            'description' => 'Left Image Section Style 2 section',
        ],
	'testimonials_section_style_1' => [
            'label'       => 'Testimonials Section Style 1',
            'description' => 'Testimonials Section Style 1 section',
        ],

    	'testimonials_section_style_2' => [
            'label'       => 'Testimonials Section Style 2',
            'description' => 'Testimonials Section Style 2 section',
        ],

	'list_in_columns_section_style_1' => [
            'label'       => 'List in Columns Section Style 1',
            'description' => 'List in Columns Section Style 1 section',
        ],
	'list_in_columns_section_style_2' => [
            'label'       => 'List in Columns Section Style 2',
            'description' => 'List in Columns Section Style 2 section',
        ],

	'list_in_columns_section_style_3' => [
            'label'       => 'List in Columns Section Style 3',
            'description' => 'List in Columns Section Style 3 section',
        ],
    'list_in_columns_section_style_4' => [
            'label'       => 'List in Columns Section Style 4',
            'description' => 'List in Columns Section Style 4 section',
        ],

	'steps_section_style_1' => [
            'label'       => 'Steps Section Style 1',
            'description' => 'Steps Section Style 1 section',
        ],

    '4_items_in_row_section' => [
            'label'       => '4 Items in Row Section',
            'description' => '4 Items in Row Section section',
        ],

    'bundles_section' => [
            'label'       => 'Bundles Section',
            'description' => 'Bundles Section section',
        ],

         'case_study_section_style_1' => [
            'label'       => 'Case Study Section Style 1',
            'description' => 'Case Study Section Style 1 section',
        ],

	'contact_form_section_style_1' => [
		'label'       => 'Contact Form Section Style 1',
		'description' => 'Contact Form Section Style 1 section',
	],









	'mena_info_section_style_1' => [
		'label'       => 'Mena Info Section Style 1',
		'description' => 'Centered hero card with eyebrow badge, headline, description, and two CTAs',
	],

    'mena_info_section_style_2' => [
		'label'       => 'Mena Info Section Style 2',
		'description' => 'Case studies hero with background image, headline, description, and 3 stats',
	],

    'mena_info_section_style_3' => [
		'label'       => 'Mena Info Section Style 3',
		'description' => 'Mena Info Section Style 3 section',
	],

    'mena_info_section_style_4' => [
		'label'       => 'Mena Info Section Style 4',
		'description' => 'Mena Info Section Style 4 section',
	],

    'mena_3_items_in_column_section_style_3' => [
		'label'       => 'Mena 3 Items in Column Section Style 3',
		'description' => '3 items in column section',
	],

	'mena_3_items_in_row_section_style_1' => [
            'label'       => 'Mena 3 Items in Row Section Style 1',
            'description' => 'Centered stats headline with three icon cards (value, label, description)',
        ],

    'mena_3_items_in_row_section_style_2' => [
            'label'       => 'Mena 3 Items in Row Section Style 2',
            'description' => 'Mena 3 Items in Row Section Style 2 section',
        ],

    'mena_4_items_in_row_section_style_1' => [
            'label'       => 'Mena 4 Items in Row Section Style 1',
            'description' => 'Mena 4 Items in Row Section Style 1 section',
        ],

    'mena_4_items_in_row_section_style_2' => [
            'label'       => 'Mena 4 Items in Row Section Style 2',
            'description' => 'Mena 4 Items in Row Section Style 2 section',
        ],

    'mena_5_items_in_row_section_style_1' => [
            'label'       => 'Mena 5 Items in Row Section Style 1',
            'description' => 'Mena 5 Items in Row Section Style 1 section',
        ],

	'mena_testimonials_section_style_1' => [
		'label'       => 'Mena Testimonials Section Style 1',
		'description' => 'Testimonials slider with featured center card, prev/next controls, and quote cards',
	],
    
    'mena_faqs_section_style_1' => [
	'label'       => 'Mena FAQs Section Style 1',
		'description' => 'FAQs with question and answer',
    ],

    ],
];