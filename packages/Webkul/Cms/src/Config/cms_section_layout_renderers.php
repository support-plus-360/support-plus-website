<?php

/**
 * Page builder: live-preview markup templates + reference images per section layout.
 *
 * Edit `preview_caption`, `preview_image`, and the `templates` strings here (or merge
 * config in your app). Layout `label` / `description` for the dropdown live in
 * `section_layouts.php`. Keys must match that file’s layout keys.
 * layout keys — they are stored on `cms_sections.section_layout`.
 *
 * Placeholders (replaced at runtime; user fields are HTML-escaped in JS):
 * - Body: {{TITLE}}, {{SUBTITLE_SECTION}}, {{DESCRIPTION_SECTION}}, {{LINKS_SECTION}}, {{ITEMS}},
 *   {{SECTION_MAIN_IMAGE_MARKUP}} (section main image &lt;img&gt; or empty)
 * - Link row: {{LINK_URL}}, {{LINK_LABEL}}
 * - Item: {{ITEM_TITLE}}, {{ITEM_SUBTITLE_SECTION}}, {{ITEM_CONTENT_SECTION}}, {{ITEM_ICON_DISPLAY}}, {{ITEM_LINKS_SECTION}},
 *   {{ITEM_CARD_HREF}} (first item link URL or #), {{ITEM_IMAGE_MARKUP}} (item main image, else icon URL as img, else gradient)
 * - Item link row (optional): {{LINK_URL}}, {{LINK_LABEL}} inside item_link_row; wrapper uses {{ITEM_LINK_ROWS}}
 *
 * `preview_image`: basename only (e.g. `stacked.png`). The builder resolves, in order:
 * (1) `public/vendor/webkul/cms/builder-layout-previews/{file}` after publish,
 * (2) `packages/Webkul/Cms/src/Resources/assets/builder-layout-previews/{file}` in the package.
 * You may also use a full `https://` URL or an app path starting with `/` for `url()`.
 */
return [
    'home_hero' => [
        'preview_caption' => 'Home Hero — centered headline, two-column copy',
        'preview_image'   => 'home_hero.png',
        'templates'     => [
            'body' => <<<'HTML'
		<section class="section-fade relative overflow-hidden pt-10">
		<div class="absolute inset-0 z-0">
		<div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(14,165,233,0.22),transparent_34%),radial-gradient(circle_at_82%_12%,rgba(109,40,217,0.2),transparent_32%),linear-gradient(135deg,#07111f_0%,#0d1020_45%,#12183a_100%)]" aria-hidden="true"></div>
		<!-- <video autoplay loop muted playsinline class="absolute inset-0 h-full w-full object-cover opacity-[0.45]">
		<source src="/hero.webm" type="video/webm" />
		</video> -->
		<div class="animated-grid opacity-20" aria-hidden="true"></div>
		<div class="aurora-lane aurora-lane-one" aria-hidden="true"></div>
		<div class="aurora-lane aurora-lane-two" aria-hidden="true"></div>
		<div class="data-rain opacity-15" aria-hidden="true"></div>
		<div class="absolute inset-0 bg-gradient-to-r from-[#07111f]/85 via-[#0d1020]/65 to-[lab(9.36792% 7.19301 -23.381 / .5)]" aria-hidden="true"></div>
		</div>
		<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="grid items-center gap-12 md:grid-cols-2">
		<div class="animate-apple-fade">
		{{SUBTITLE_SECTION}}
		<h1 class="mb-6 text-black bg-clip-text text-xl font-bold leading-tight text-transparent">{{TITLE}}</h1>
		{{DESCRIPTION_SECTION}}
		{{LINKS_SECTION}}
		</div>
		</div>

		</div>
		</div>
		</div>
		</section>
		HTML,
			'subtitle_section_when' => '<div class="mb-5 inline-flex items-center gap-2 rounded-full border border-cyan-400/30 bg-white/[0.04] px-4 py-2 text-[12px] text-cyan-300 shadow-lg shadow-cyan-500/5 backdrop-blur-xl"><span class="text-base leading-none text-cyan-400" aria-hidden="true">✦</span><span>{{SUBTITLE}}</span></div>',
			'description_section_when' => '<p class="mb-8 text-[12px] font-light leading-relaxed">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mb-2 flex flex-wrap gap-4" aria-label="Hero actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center justify-center gap-2 rounded-full border border-cyan-400/40 px-8 py-3 text-sm font-semibold text-cyan-200 backdrop-blur-xl transition duration-300 hover:bg-cyan-400/10 first:border-transparent first:bg-gradient-to-r first:from-blue-600 first:to-cyan-500 first:text-white first:shadow-xl first:shadow-blue-600/25 rtl:flex-row-reverse" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-3 flex flex-wrap gap-x-3 gap-y-1 border-t border-white/10 pt-3 text-xs" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="font-medium text-cyan-300 underline hover:text-white" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item' => <<<'HTML'
		<div class="animate-metric-rise rounded-2xl border border-white/10 bg-white/[0.045] p-4 backdrop-blur-md">
		<div class="mb-2 flex items-center justify-between gap-2 text-sm">
		<span class="font-medium text-white/90">{{ITEM_TITLE}}</span>
		{{ITEM_SUBTITLE_SECTION}}
		</div>
		<div class="h-2 overflow-hidden rounded-full bg-white/5">
		<div class="metric-bar h-full w-3/4 rounded-full bg-gradient-to-r from-cyan-500 to-violet-600"></div>
		</div>
		{{ITEM_CONTENT_SECTION}}
		{{ITEM_LINKS_SECTION}}
		</div>
		HTML,
            'item_subtitle_section_when' => '<span class="font-bold text-cyan-400">{{ITEM_SUBTITLE}}</span>',
            'item_content_section_when' => '<p class="mt-2 text-[10px] leading-snug text-white/55">{{ITEM_CONTENT}}</p>',
        ],
    ],

    '3_items_in_row_section_style_1' => [
        'preview_caption' => '3 Items in Row Section Style 1 — centered headline, three-column cards',
        'preview_image'   => '3_items_in_row_section_style_1.png',
        'templates'     => [
            'body' => <<<'HTML'
	<section class="section-fade section-depth relative overflow-hidden py-6 sm:py-10">
	<div class="section-soft-glow absolute inset-0" aria-hidden="true"></div>
	<div class="animated-grid section-grid-soft" aria-hidden="true"></div>
	<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
	<div class="mb-6 text-center">
	<h2 class="mb-2 text-xl font-bold">{{TITLE}}</h2>
	{{SUBTITLE_SECTION}}
	{{DESCRIPTION_SECTION}}
	{{LINKS_SECTION}}
	</div>
	<div class="paper-stack-grid grid gap-6 md:grid-cols-3 lg:gap-8">{{ITEMS}}</div>
	</div>
	</section>
	HTML,
		'subtitle_section_when' => '<p class="mx-auto max-w-2xl text-[12px] text-gray-600 dark:text-gray-400">{{SUBTITLE}}</p>',
		'description_section_when' => '<div class="mx-auto mt-3 max-w-2xl text-[12px] leading-relaxed text-gray-600 dark:text-gray-400">{{DESCRIPTION}}</div>',
		'links_wrapper_when' => '<nav class="mx-auto mt-6 flex flex-wrap justify-center gap-x-4 gap-y-2 text-sm" aria-label="Links">{{LINK_ROWS}}</nav>',
		'link_row' => '<a class="font-normal text-blue-600 underline hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
		'item_links_wrapper_when' => '<nav class="mt-4 flex flex-wrap justify-center gap-x-3 gap-y-1 text-xs" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
		'item_link_row' => '<a class="font-normal text-blue-600 underline hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
		'item' => <<<'HTML'
	<div class="animated-border-card paper-card pro-card interactive-card group rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8 dark:border-gray-700 dark:bg-gray-900">
	<div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl border border-blue-500/30 bg-blue-500/10 text-lg font-semibold text-blue-700 transition duration-500 group-hover:scale-110 group-hover:rotate-3 dark:border-blue-400/30 dark:bg-blue-500/10 dark:text-blue-300">
	{{ITEM_ICON_DISPLAY}}
	</div>
	<h3 class="mb-3 text-[12px] font-bold text-gray-900 transition duration-300 group-hover:text-blue-600 dark:text-white dark:group-hover:text-blue-400">{{ITEM_TITLE}}</h3>
	{{ITEM_SUBTITLE_SECTION}}
	{{ITEM_CONTENT_SECTION}}
	{{ITEM_LINKS_SECTION}}
	</div>
	HTML,
            'item_subtitle_section_when' => '<p class="mb-2 text-[10px] text-gray-500 dark:text-gray-400">{{ITEM_SUBTITLE}}</p>',
            'item_content_section_when' => '<p class="font-light leading-relaxed text-gray-600 transition duration-300 group-hover:text-gray-900 dark:text-gray-300 dark:group-hover:text-gray-100">{{ITEM_CONTENT}}</p>',
        ],
    ],

    '3_items_in_row_section_style_2' => [
        'preview_caption' => '3 Items in Row Section Style 2 — image cards, title overlay, link wraps card',
        'preview_image'   => '3_items_in_row_section_style_2.png',
        'templates'     => [
            'body' => <<<'HTML'
		<section class="section-fade section-unified relative overflow-hidden py-6">
		<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
		<div class="stagger-item mb-16 text-center">
		<h2 class="mb-4 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 bg-clip-text text-2xl font-bold leading-tight text-transparent dark:from-white dark:via-gray-100 dark:to-white">{{TITLE}}</h2>
		{{SUBTITLE_SECTION}}
		{{DESCRIPTION_SECTION}}
		{{LINKS_SECTION}}
		</div>
		<div class="grid gap-6 md:grid-cols-3 lg:gap-8">{{ITEMS}}</div>
		</div>
		</section>
		HTML,
			'subtitle_section_when' => '<p class="mx-auto max-w-2xl text-[12px] font-light text-black">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="mx-auto mt-3 max-w-2xl text-[12px] text-black">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mx-auto mt-6 flex flex-wrap justify-center gap-x-4 gap-y-2 text-sm" aria-label="Links">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="font-normal text-black hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-3 flex flex-wrap justify-center gap-x-3 gap-y-1 text-xs" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="font-normal text-black hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item' => <<<'HTML'
		<a class="group interactive-card block stagger-item" href="{{ITEM_CARD_HREF}}">
		<div class="animated-border-card image-card clean-image-card relative h-72 overflow-hidden rounded-3xl border border-blue-600/30 shadow-lg transition-all duration-500 sm:h-80 group-hover:border-cyan-400/80 group-hover:shadow-2xl group-hover:shadow-cyan-500/30">
		{{ITEM_IMAGE_MARKUP}}
		<div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#07111f] via-[#07111f]/25 to-transparent transition duration-500 group-hover:from-[#07111f]/70" aria-hidden="true"></div>
		<div class="absolute bottom-6 start-6 end-6 transition duration-500">
		<h3 class="text-base font-bold text-black">{{ITEM_TITLE}}</h3>
		{{ITEM_SUBTITLE_SECTION}}
		</div>
		</div>
		{{ITEM_CONTENT_SECTION}}
		{{ITEM_LINKS_SECTION}}
		</a>
		HTML,
            'item_subtitle_section_when' => '<p class="mt-1 text-[10px] font-medium text-black">{{ITEM_SUBTITLE}}</p>',
            'item_content_section_when' => '<p class="mt-4 text-[10px] leading-relaxed text-black">{{ITEM_CONTENT}}</p>',
        ],
    ],

    'left_image_section_style_1' => [
        'preview_caption' => 'Left Image Section Style 1 — image left, steps + CTA right',
        'preview_image'   => 'left_image_section_style_1.png',
        'templates'     => [
            'body' => <<<'HTML'
	<section class="section-fade section-calm-blue relative overflow-hidden py-4">
	<div class="section-soft-glow absolute inset-0 opacity-60" aria-hidden="true"></div>
	<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
	<div class="grid items-center gap-12 md:grid-cols-2">
	<div class="animate-slide-in-left">
	<div class="animated-border-card image-card relative h-80 overflow-hidden rounded-3xl border border-white/10 sm:h-96">
	{{SECTION_MAIN_IMAGE_MARKUP}}
	<div class="pointer-events-none absolute inset-0 rounded-3xl bg-gradient-to-br from-blue-600/20 to-cyan-500/20 opacity-50" aria-hidden="true"></div>
	<div class="pointer-events-none absolute inset-0 rounded-3xl shadow-2xl shadow-blue-600/30" aria-hidden="true"></div>
	</div>
	</div>
	<div class="animate-slide-in-right">
	{{SUBTITLE_SECTION}}
	<h2 class="mb-8 bg-gradient-to-r from-blue-400 to-blue-400 bg-clip-text text-lg font-bold text-transparent md:text-5xl">{{TITLE}}</h2>
	{{DESCRIPTION_SECTION}}
	<div class="space-y-6">{{ITEMS}}</div>
	{{LINKS_SECTION}}
	</div>
	</div>
	</div>
	</section>
	HTML,
		'subtitle_section_when' => '<p class="mb-3 text-xs font-semibold uppercase tracking-wider text-cyan-300/90">{{SUBTITLE}}</p>',
		'description_section_when' => '<p class="mb-8 text-[12px] text-gray-600">{{DESCRIPTION}}</p>',
		'links_wrapper_when' => '<nav class="mt-8 flex flex-wrap gap-3" aria-label="Actions">{{LINK_ROWS}}</nav>',
		'link_row' => '<a class="premium-button magnetic-button inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 rtl:flex-row-reverse" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
		'item_links_wrapper_when' => '<nav class="mt-2 flex flex-wrap gap-x-3 gap-y-1 text-xs text-white/80" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
		'item_link_row' => '<a class="font-medium text-cyan-300 underline hover:text-white" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
		'item' => <<<'HTML'
	<div class="animate-fade-in-up flex gap-4">
	<div class="flex shrink-0 items-center justify-center rounded-md border border-blue-500/40 bg-gradient-to-r from-[#3b82f6] to-[#0ea5e9] px-3 py-1 text-sm font-bold text-black opacity-90 shadow-lg shadow-cyan-500/10">{{ITEM_COUNT}}</div>
	<div class="min-w-0">
	<h3 class="mb-2 font-bold text-black">{{ITEM_TITLE}}</h3>
	{{ITEM_SUBTITLE_SECTION}}
	{{ITEM_CONTENT_SECTION}}
	{{ITEM_LINKS_SECTION}}
	</div>
	</div>
	HTML,
            'item_subtitle_section_when' => '<p class="mb-1 text-sm text-black">{{ITEM_SUBTITLE}}</p>',
            'item_content_section_when' => '<p class="text-sm leading-relaxed text-gray-600">{{ITEM_CONTENT}}</p>',
        ],
    ],
];
