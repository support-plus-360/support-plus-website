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
 * - Item: {{ITEM_TITLE}}, {{ITEM_SUBTITLE_SECTION}}, {{ITEM_CONTENT_SECTION}}, {{ITEM_ICON_DISPLAY}}, {{ITEM_ICON_MARKUP}}, {{ITEM_LINKS_SECTION}},
 *   {{ITEM_CARD_HREF}} (first item link URL or #), {{ITEM_IMAGE_MARKUP}} (item main image, else icon URL as img, else gradient)
 * - Item link row (optional): {{LINK_URL}}, {{LINK_LABEL}} inside item_link_row; wrapper uses {{ITEM_LINK_ROWS}}
 *
 * `preview_image`: path under `builder-layout-previews/v1/` (e.g. `v1/hero_section_style_1.png`
 * or `hero_section_style_1.png` — bare filenames are prefixed with `v1/` automatically).
 * Resolved from `public/vendor/webkul/cms/builder-layout-previews/v1/` after publish, or package assets.
 * You may also use a full `https://` URL or an app path starting with `/` for `url()`.
 */
return [
	'hero_section_style_1' => [
	'preview_caption' => 'Hero Section Style 1 — centered headline, two-column copy',
	'preview_image'   => 'v1/hero_section_style_1.png',
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
	'preview_image'   => 'v1/3_items_in_row_section_style_1.png',
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
	'preview_image'   => 'v1/3_items_in_row_section_style_2.png',
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

	'3_items_in_row_section_style_3' => [
		'preview_caption' => '3 Items in Row Section Style 3 — specialization cards with feature lists',
		'preview_image'   => 'v1/3_items_in_row_section_style_3.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-20">
			<div class="absolute inset-0 bg-gradient-to-b from-[#0f0f1e] via-[#16172d] to-[#0f0f1e]"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<h2 class="mb-12 text-center text-4xl font-bold animate-fade-in-up">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			<div class="grid gap-8 md:grid-cols-3">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="-mt-8 mb-12 text-center text-lg text-gray-400">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="-mt-8 mb-12 text-center text-sm text-gray-500">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-auto flex flex-wrap gap-3 pt-2" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="inline-flex items-center gap-2 text-cyan-400 transition hover:gap-3" href="{{LINK_URL}}">{{LINK_LABEL}} <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>',
			'item' => <<<'HTML'
			<div class="animated-border-card group flex animate-fade-in-up flex-col rounded-xl border border-blue-500/20 bg-[#1a1b2e] p-8 transition duration-300 hover:border-cyan-400/50">
			<h3 class="mb-4 text-normal font-bold text-black transition group-hover:text-cyan-400">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			{{ITEM_LINKS_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="mb-8">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<ul class="text-sm text-gray-400 list-disc list-inside">{{ITEM_CONTENT}}</ul>',
			'item_content_raw' => true,
		],
	],

	'3_items_in_row_section_style_4' => [
		'preview_caption' => '3 Items in Row Section Style 4 — case study cards with feature lists',
		'preview_image'   => 'v1/3_items_in_row_section_style_4.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-20">
			<div class="absolute inset-0 bg-gradient-to-b from-[#0f0f1e] via-[#16172d] to-[#0f0f1e]"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<h2 class="mb-12 text-center text-4xl font-bold animate-fade-in-up">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			<div class="grid gap-8 md:grid-cols-3">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="-mt-8 mb-12 text-center text-lg text-gray-400">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="-mt-8 mb-12 text-center text-sm text-gray-500">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-auto flex flex-wrap gap-3 pt-2" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="inline-flex items-center gap-2 text-cyan-400 transition hover:gap-3" href="{{LINK_URL}}">{{LINK_LABEL}} <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>',
			'item' => <<<'HTML'
			<div class="animated-border-card group flex animate-fade-in-up flex-col rounded-xl border border-blue-500/20 bg-[#1a1b2e] p-8 transition duration-300 hover:border-cyan-400/50">
			<h3 class="mb-4 text-normal font-bold text-black transition group-hover:text-cyan-400">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			{{ITEM_LINKS_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="mb-8">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<ul class="text-sm text-gray-400 list-disc list-inside">{{ITEM_CONTENT}}</ul>',
			'item_content_raw' => true,
		],
	],

	'3_items_in_row_section_style_5' => [
		'preview_caption' => '3 Items in Row Section Style 5 — platform cards with icon, description & feature list',
		'preview_image'   => 'v1/3_items_in_row_section_style_5.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-20">
			<div class="absolute inset-0 bg-gradient-to-b from-[#0f0f1e] via-[#16172d] to-[#0f0f1e]"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<h2 class="animate-fade-in-up mb-12 text-center text-4xl font-bold">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			<div class="grid gap-6 md:grid-cols-3">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="-mt-8 mb-12 text-center text-lg text-gray-400">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="-mt-8 mb-12 text-center text-sm text-gray-500">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-auto flex flex-wrap gap-3 pt-4" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="inline-flex items-center gap-2 text-cyan-400 transition hover:gap-3" href="{{LINK_URL}}">{{LINK_LABEL}} <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>',
			'item' => <<<'HTML'
			<div class="animated-border-card group animate-fade-in-up flex flex-col rounded-xl border border-blue-500/20 bg-[#1a1b2e] p-8 transition duration-300 hover:border-cyan-400/50 hover:shadow-lg hover:shadow-blue-600/10">
			<div class="mb-6 flex h-12 w-12 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-cyan-500">
			<svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
			</div>
			<h3 class="mb-4 text-2xl font-bold text-white transition group-hover:text-cyan-400">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			{{ITEM_LINKS_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="mb-6 text-sm text-gray-400">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<ul class="space-y-2">{{ITEM_CONTENT}}</ul>',
			'item_content_raw' => true,
		],
	],

	'left_image_section_style_1' => [
	'preview_caption' => 'Left Image Section Style 1 — image left, steps + CTA right',
	'preview_image'   => 'v1/left_image_section_style_1.png',
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

	'two_items_in_row_section_style_1' => [
		'preview_caption' => 'Two Items in Row Section Style 1 — success cases grid with image cards',
		'preview_image'   => 'v1/two_items_in_row_section_style_1.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade section-unified relative overflow-hidden py-8">
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="mb-16 text-center animate-fade-in-up">
			<h2 class="mb-4 text-4xl font-bold md:text-5xl">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			</div>
			<div class="grid gap-8 md:grid-cols-2">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="text-lg text-gray-500">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="mt-2 text-sm text-gray-400">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/25" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-3 flex flex-wrap gap-3" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="text-sm font-medium text-cyan-300 underline hover:text-white" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item' => <<<'HTML'
			<div class="animated-border-card image-card clean-image-card group relative animate-fade-in-up overflow-hidden rounded-3xl border border-white/10">
			<div class="absolute inset-0 h-96 overflow-hidden">
			{{ITEM_IMAGE_MARKUP}}
			<div class="absolute inset-0 bg-gradient-to-t from-[#07111f] via-transparent to-transparent group-hover:from-[#07111f]/80"></div>
			</div>
			<div class="relative flex h-96 flex-col justify-end p-8">
			<h3 class="mb-2 text-xl font-bold text-black">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			{{ITEM_LINKS_SECTION}}
			</div>
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="text-2xl font-bold text-grey">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<p class="mt-2 text-sm leading-relaxed text-gray-300">{{ITEM_CONTENT}}</p>',
		],
	],

	'info_section' => [
		'preview_caption' => 'Info Section — centered CTA with radial gradient background',
		'preview_image'   => 'v1/info_section.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-16 sm:py-20">
			<div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(14,165,233,0.22),transparent_36%),linear-gradient(90deg,#12183a,#07111f,#0d1020)]"></div>
			<div class="aurora-lane aurora-lane-two opacity-60"></div>
			<div class="animated-grid opacity-20"></div>
			<div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center animate-fade-in-up">
			<h2 class="mb-6 bg-gradient-to-r from-white via-blue-400 to-cyan-400 bg-clip-text text-4xl font-bold text-transparent md:text-5xl">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="mx-auto mb-8 max-w-2xl text-lg text-gray-400">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="mx-auto mb-6 max-w-2xl text-sm text-gray-500">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<div class="flex flex-wrap justify-center gap-4">{{LINK_ROWS}}</div>',
			'link_row' => '<a class="premium-button magnetic-button inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-8 py-4 font-semibold text-white shadow-lg shadow-blue-600/25 rtl:flex-row-reverse" href="{{LINK_URL}}">{{LINK_LABEL}} <svg class="h-5 w-5 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>',
			'item_links_wrapper_when' => '',
			'item_link_row' => '',
			'item' => '',
			'item_subtitle_section_when' => '',
			'item_content_section_when' => '',
		],
	],

	'right_image_section_style_1' => [
		'preview_caption' => 'Right Image Section Style 1 — numbered steps left, image right (Synergy)',
		'preview_image'   => 'v1/right_image_section_style_1.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-20">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="grid items-center gap-12 md:grid-cols-2">
			<div class="animate-slide-in-left">
			<h2 class="mb-2 text-4xl font-bold md:text-5xl">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			<div class="space-y-6">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			<div class="relative h-96 animate-fade-in-up">
			{{SECTION_MAIN_IMAGE_MARKUP}}
			</div>
			</div>
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="mb-8 text-lg text-gray-500">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="mb-8 text-sm leading-relaxed text-gray-400">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-10 flex flex-wrap gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="premium-button magnetic-button inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 rtl:flex-row-reverse" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-2 flex flex-wrap gap-3 text-xs" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="font-medium text-blue-500 underline hover:text-blue-700" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item' => <<<'HTML'
			<div class="flex gap-6">
			<div class="relative">
			<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border-2 border-blue-500/50 font-bold text-blue-500">{{ITEM_COUNT}}</div>
			</div>
			<div class="min-w-0 flex-1">
			<h3 class="mb-2 text-lg font-bold">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			{{ITEM_LINKS_SECTION}}
			</div>
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="mb-1 text-sm font-medium text-gray-700">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<p class="leading-relaxed text-gray-500">{{ITEM_CONTENT}}</p>',
		],
	],

	'right_testimonial_section' => [
		'preview_caption' => 'Right Testimonial Section — elite checklist left, testimonial card right',
		'preview_image'   => 'v1/right_testimonial_section.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade section-depth relative overflow-hidden py-16 sm:py-20">
			<div class="section-soft-glow absolute inset-0" aria-hidden="true"></div>
			<div class="animated-grid section-grid-soft" aria-hidden="true"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="grid items-center gap-12 md:grid-cols-2">
			<div class="animate-slide-in-left">
			<h2 class="mb-8 text-lg font-bold">
			<span class="text-black">{{TITLE}}</span><br>
			{{SUBTITLE_SECTION}}
			</h2>
			<div class="space-y-6">{{ITEMS}}</div>
			</div>
			<div class="animated-border-card paper-card pro-card animate-fade-in-up rounded-3xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8 dark:border-gray-700 dark:bg-gray-900">
			<div class="flex items-start gap-4">
				<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-cyan-400/20 bg-gradient-to-br from-blue-600/20 to-cyan-500/20 text-cyan-400">
				<svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
				</div>
				<div class="min-w-0 flex-1">
				{{TESTIMONIAL_ITEM_SECTION}}
				</div>
			</div>
			</div>
			</div>
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<span class="bg-gradient-to-r from-blue-600 via-cyan-400 to-blue-400 bg-clip-text text-transparent">{{SUBTITLE}}</span>',
			'description_section_when' => '',
			'links_wrapper_when' => '',
			'link_row' => '',
			'testimonial_item' => <<<'HTML'
			{{ITEM_CONTENT_SECTION}}
			<p class="font-bold text-cyan-400">{{ITEM_TITLE}}</p>
			{{ITEM_SUBTITLE_SECTION}}
			HTML,
			'testimonial_item_subtitle_section_when' => '<p class="text-sm text-gray-400">{{ITEM_SUBTITLE}}</p>',
			'testimonial_item_content_section_when' => '<p class="mb-4 italic text-black">{{ITEM_CONTENT}}</p>',
			'testimonial_item_content_raw' => true,
			'item_links_wrapper_when' => '',
			'item_link_row' => '',
			'item' => <<<'HTML'
			<div class="flex animate-fade-in-up gap-4">
			<svg class="mt-0.5 h-6 w-6 shrink-0 text-cyan-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
			<div class="min-w-0">
			<h3 class="mb-1 font-bold text-black">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			</div>
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="text-sm text-gray-400">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<p class="text-sm text-gray-400">{{ITEM_CONTENT}}</p>',
		],
	],

	// show image on left and numbered steps on right
	'left_image_section_style_2' => [
		'preview_caption' => 'Left Image Section Style 2 — numbered steps left, image right (Synergy)',
		'preview_image'   => 'v1/left_image_section_style_2.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-20">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="grid items-center gap-12 md:grid-cols-2">
			<div class="relative h-96 animate-fade-in-up">
			{{SECTION_MAIN_IMAGE_MARKUP}}
			</div>
			<div class="animate-slide-in-right">
			<h2 class="mb-2 text-4xl font-bold md:text-5xl">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			<div class="space-y-6">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</div>
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="mb-8 text-lg text-gray-500">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="mb-8 text-sm leading-relaxed text-gray-400">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-10 flex flex-wrap gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="premium-button magnetic-button inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 rtl:flex-row-reverse" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-2 flex flex-wrap gap-3 text-xs" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="font-medium text-blue-500 underline hover:text-blue-700" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item' => <<<'HTML'
			<div class="flex gap-6">
			<div class="relative">
			<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full border-2 border-blue-500/50 font-bold text-blue-500">{{ITEM_COUNT}}</div>
			</div>
			<div class="min-w-0 flex-1">
			<h3 class="mb-2 text-lg font-bold">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			{{ITEM_LINKS_SECTION}}
			</div>
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="mb-1 text-sm font-medium text-gray-700">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<p class="leading-relaxed text-gray-500">{{ITEM_CONTENT}}</p>',
		],
	],

	'testimonials_section_style_1' => [
		'preview_caption' => 'Testimonials Section Style 1 — quote cards in 3-column grid',
		'preview_image'   => 'v1/testimonials_section_style_1.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade section-depth relative overflow-hidden py-20">
			<div class="section-soft-glow absolute inset-0 opacity-80" aria-hidden="true"></div>
			<div class="absolute top-20 end-0 h-80 w-80 rounded-full bg-gradient-to-bl from-indigo-500/15 to-transparent blur-3xl" aria-hidden="true"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="mb-16 text-center animate-fade-in-up">
			<h2 class="mb-4 text-4xl font-bold md:text-5xl">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			</div>
			<div class="grid gap-8 md:grid-cols-3">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="text-lg text-gray-500">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="mt-2 text-sm text-gray-400">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="premium-button magnetic-button inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 rtl:flex-row-reverse" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-4 flex flex-wrap gap-3 text-xs" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="font-medium text-blue-500 underline hover:text-blue-700" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item' => <<<'HTML'
			<div class="animated-border-card group relative animate-fade-in-up rounded-2xl border border-blue-500/30 p-4 backdrop-blur-sm transition duration-300 hover:border-cyan-400/50 md:p-1">
			<div class="pointer-events-none absolute inset-0 -z-10 rounded-2xl bg-gradient-to-br from-blue-600/5 to-indigo-500/5" aria-hidden="true"></div>
			<div class="mb-4 font-serif text-sm text-blue-500/20" aria-hidden="true">&ldquo;</div>
			{{ITEM_CONTENT_SECTION}}
			<div class="mt-8 flex items-center gap-4">
			{{ITEM_AVATAR_MARKUP}}
			<div class="min-w-0">
			<p class="font-bold">{{ITEM_TITLE}}</p>
			{{ITEM_SUBTITLE_SECTION}}
			</div>
			</div>
			{{ITEM_LINKS_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="text-sm text-gray-500">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<p class="text-normal font-light italic leading-relaxed">{{ITEM_CONTENT}}</p>',
		],
	],

    'testimonials_section_style_2' => [
		'preview_caption' => 'Testimonials Section Style 2 — calm blue “why” quotes; with 3 items, center card uses darker green gradient, softer opacity, and avatar',
		'preview_image'   => 'v1/testimonials_section_style_2.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade section-calm-blue relative overflow-hidden py-20">
			<div class="section-soft-glow absolute inset-0 opacity-60" aria-hidden="true"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="animate-fade-in-up mb-16 text-center">
			<h2 class="mb-4 text-4xl font-bold md:text-5xl">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			</div>
			<div class="grid gap-8 md:grid-cols-3">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="text-lg text-gray-400">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="mt-2 text-sm text-gray-500">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="premium-button magnetic-button inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/25 rtl:flex-row-reverse" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<nav class="mt-4 flex flex-wrap gap-3 text-xs" aria-label="Item links">{{ITEM_LINK_ROWS}}</nav>',
			'item_link_row' => '<a class="font-medium text-cyan-400 underline hover:text-cyan-300" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item' => <<<'HTML'
			<div class="animated-border-card group relative animate-fade-in-up border p-8 transition duration-300 hover:border-cyan-400/50 {{ITEM_CARD_SKIN}}">
			{{ITEM_CONTENT_SECTION}}
			<div class="mt-6 flex items-center gap-3">
			<div class="shrink-0 empty:hidden">{{ITEM_AVATAR_MARKUP}}</div>
			<div class="min-w-0 flex-1">
			<h4 class="font-bold text-white">{{ITEM_TITLE}}</h4>
			{{ITEM_SUBTITLE_SECTION}}
			</div>
			</div>
			{{ITEM_LINKS_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="text-sm text-cyan-400">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<p class="mb-6 text-base font-light italic leading-relaxed text-gray-400">{{ITEM_CONTENT}}</p>',
		],
	],

	'list_in_columns_section_style_1' => [
		'preview_caption' => 'List in Columns Section Style 1 — two-column card with benefits & KPIs',
		'preview_image'   => 'v1/list_in_columns_section_style_1.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-20">
			<div class="absolute inset-0 bg-gradient-to-b from-[#16172d] via-[#0f0f1e] to-[#16172d]"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="animated-border-card animate-fade-in-up rounded-xl border border-blue-500/20 bg-[#1a1b2e] p-12">
			<div class="grid gap-8 md:grid-cols-2">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '',
			'description_section_when' => '',
			'links_wrapper_when' => '<nav class="mt-10 flex flex-wrap gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '',
			'item_link_row' => '',
			'item' => <<<'HTML'
			<div>
			<h3 class="mb-6 text-lg font-bold text-black">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="mb-4 text-sm font-medium text-gray-300">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<div class="space-y-3 text-gray-400 [&_ul]:list-none [&_ul]:space-y-3 [&_li]:flex [&_li]:items-start [&_li]:gap-3">{{ITEM_CONTENT}}</div>',
			'item_content_raw' => true,
		],
	],

	'list_in_columns_section_style_2' => [
		'preview_caption' => 'List in Columns Section Style 2 — two-column card with benefits & KPIs',
		'preview_image'   => 'v1/list_in_columns_section_style_2.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-20">
			<div class="absolute inset-0 bg-gradient-to-b from-[#16172d] via-[#0f0f1e] to-[#16172d]"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<h2 class="mb-4 text-lg font-bold md:text-5xl text-center">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			<div class="animated-border-card animate-fade-in-up rounded-xl border border-blue-500/20 bg-[#1a1b2e] p-12">
			<div class="grid gap-8 md:grid-cols-2">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '',
			'description_section_when' => '',
			'links_wrapper_when' => '<nav class="mt-10 flex flex-wrap gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '',
			'item_link_row' => '',
			'item' => <<<'HTML'
			<div>
			<h3 class="mb-6 text-lg font-bold text-black">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="mb-4 text-sm font-medium text-gray-300">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<div class="space-y-3 text-gray-400 [&_ul]:list-none [&_ul]:space-y-3 [&_li]:flex [&_li]:items-start [&_li]:gap-3">{{ITEM_CONTENT}}</div>',
			'item_content_raw' => true,
		],
	],

	'list_in_columns_section_style_3' => [
		'preview_caption' => 'List in Columns Section Style 3 — tech stack tags & compliance list in two cards',
		'preview_image'   => 'v1/list_in_columns_section_style_3.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-20">
			<div class="absolute inset-0 bg-gradient-to-b from-[#16172d] via-[#0f0f1e] to-[#16172d]"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<h2 class="animate-fade-in-up mb-12 text-center text-4xl font-bold">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			<div class="grid gap-8 md:grid-cols-2">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="-mt-8 mb-12 text-center text-lg text-gray-400">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="-mt-8 mb-12 text-center text-sm text-gray-500">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-10 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '',
			'item_link_row' => '',
			'item' => <<<'HTML'
			<div class="animated-border-card animate-fade-in-up rounded-xl border border-blue-500/20 bg-[#1a1b2e] p-8">
			<h3 class="mb-6 text-2xl font-bold text-white">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="mb-4 text-sm leading-relaxed text-gray-400">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<div class="flex flex-wrap gap-2 [&_ul]:flex [&_ul]:flex-wrap [&_ul]:gap-2 [&_ul]:list-none [&_li]:rounded-full [&_li]:border [&_li]:border-blue-500/30 [&_li]:bg-blue-500/10 [&_li]:px-3 [&_li]:py-1 [&_li]:text-xs [&_li]:text-cyan-400">{{ITEM_CONTENT}}</div>',
			'item_content_raw' => true,
		],
	],

    'list_in_columns_section_style_4' => [
		'preview_caption' => 'List in Columns Section Style 4 — two core cards with intro, feature list & accent link',
		'preview_image'   => 'v1/list_in_columns_section_style_4.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade section-depth relative overflow-hidden py-20">
			<div class="section-soft-glow absolute inset-0 opacity-80" aria-hidden="true"></div>
			<div class="absolute end-0 top-20 h-80 w-80 rounded-full bg-gradient-to-bl from-violet-500/15 to-transparent blur-3xl" aria-hidden="true"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<div class="animate-fade-in-up mb-16 text-center">
			<h2 class="mb-4 text-4xl font-bold md:text-5xl">{{TITLE}}</h2>
			{{SUBTITLE_SECTION}}
			{{DESCRIPTION_SECTION}}
			</div>
			<div class="grid gap-8 md:grid-cols-2">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '<p class="text-lg text-gray-400">{{SUBTITLE}}</p>',
			'description_section_when' => '<p class="mt-2 text-sm text-gray-500">{{DESCRIPTION}}</p>',
			'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '<div class="mt-2">{{ITEM_LINK_ROWS}}</div>',
			'item_link_row' => '<a class="inline-flex items-center gap-2 font-medium text-cyan-400 transition hover:gap-3" href="{{LINK_URL}}">{{LINK_LABEL}} <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>',
			'item' => <<<'HTML'
			<div class="animated-border-card group animate-fade-in-up rounded-lg border border-blue-500/20 bg-gradient-to-br from-[#1a1b2e] to-[#0f0f1e] p-8 transition duration-300 hover:border-cyan-400/50">
			<h3 class="mb-4 text-2xl font-bold text-white">{{ITEM_TITLE}}</h3>
			{{ITEM_SUBTITLE_SECTION}}
			{{ITEM_CONTENT_SECTION}}
			{{ITEM_LINKS_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '<p class="mb-6 text-sm text-gray-400">{{ITEM_SUBTITLE}}</p>',
			'item_content_section_when' => '<div class="mb-6 text-sm text-gray-300 [&_ul]:mb-0 [&_ul]:space-y-2 [&_li]:flex [&_li]:items-center [&_li]:gap-2">{{ITEM_CONTENT}}</div>',
			'item_content_raw' => true,
		],
	],

	'steps_section_style_1' => [
		'preview_caption' => 'Steps Section Style 1 — numbered process steps in 4-column grid',
		'preview_image'   => 'v1/steps_section_style_1.png',
		'templates'     => [
			'body' => <<<'HTML'
			<section class="section-fade relative overflow-hidden py-20">
			<div class="absolute inset-0 bg-gradient-to-b from-[#0f0f1e] via-[#16172d] to-[#0f0f1e]"></div>
			<div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
			<h2 class="animate-fade-in-up mb-12 text-center text-4xl font-bold">{{TITLE}}</h2>
			<div class="grid gap-4 md:grid-cols-4">{{ITEMS}}</div>
			{{LINKS_SECTION}}
			</div>
			</section>
			HTML,
			'subtitle_section_when' => '',
			'description_section_when' => '',
			'links_wrapper_when' => '<nav class="mt-10 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
			'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
			'item_links_wrapper_when' => '',
			'item_link_row' => '',
			'item' => <<<'HTML'
			<div class="animate-fade-in-up text-center">
			<div class="mb-4 inline-block rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-4 py-2 font-bold text-white">{{ITEM_COUNT}}</div>
			<h3 class="text-lg font-bold">{{ITEM_TITLE}}</h3>
			{{ITEM_CONTENT_SECTION}}
			</div>
			HTML,
			'item_subtitle_section_when' => '',
			'item_content_section_when' => '<p class="mt-2 text-sm text-gray-400">{{ITEM_CONTENT}}</p>',
		],
	],

    '4_items_in_row_section' => [
        'preview_caption' => '4 Items in Row Section — metric cards in a 4-column grid',
        'preview_image'   => 'v1/4_items_in_row_section.png',
        'templates'     => [
            'body' => <<<'HTML'
            <section class="section-fade relative overflow-hidden py-20">
            <div class="absolute inset-0 bg-gradient-to-b from-[#16172d] via-[#0f0f1e] to-[#16172d]"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="animate-fade-in-up mb-12 text-center text-4xl font-bold">{{TITLE}}</h2>
            {{SUBTITLE_SECTION}}
            {{DESCRIPTION_SECTION}}
            <div class="grid gap-6 md:grid-cols-4">{{ITEMS}}</div>
            {{LINKS_SECTION}}
            </div>
            </section>
            HTML,
            'subtitle_section_when' => '<p class="-mt-8 mb-12 text-center text-lg text-gray-400">{{SUBTITLE}}</p>',
            'description_section_when' => '<p class="-mt-8 mb-12 text-center text-sm text-gray-500">{{DESCRIPTION}}</p>',
            'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
            'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
            'item_links_wrapper_when' => '',
            'item_link_row' => '',
            'item' => <<<'HTML'
            <div class="animated-border-card animate-fade-in-up rounded-xl border border-blue-500/20 bg-[#1a1b2e] p-6 text-center">
            <div class="mb-2 text-lg font-bold text-black">{{ITEM_TITLE}}</div>
            {{ITEM_SUBTITLE_SECTION}}
            {{ITEM_CONTENT_SECTION}}
            </div>
            HTML,
            'item_subtitle_section_when' => '<p class="text-sm text-gray-400">{{ITEM_SUBTITLE}}</p>',
            'item_content_section_when' => '<p class="mt-2 text-sm text-gray-400">{{ITEM_CONTENT}}</p>',
        ],
    ],

    'bundles_section' => [
        'preview_caption' => 'Bundles Section — service bundle cards with features & CTAs',
        'preview_image'   => 'v1/bundles_section.png',
        'templates'     => [
            'body' => <<<'HTML'
            <section class="section-fade relative overflow-hidden py-20">
            <div class="absolute inset-0 bg-gradient-to-b from-[#0f0f1e] via-[#16172d]/30 to-[#0f0f1e]"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="animate-fade-in-up mb-16 text-center">
            {{SUBTITLE_SECTION}}
            <h2 class="mb-4 text-4xl font-bold md:text-5xl">{{TITLE}}</h2>
            {{DESCRIPTION_SECTION}}
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-5">{{ITEMS}}</div>
            {{LINKS_SECTION}}
            </div>
            </section>
            HTML,
            'subtitle_section_when' => '<p class="mb-2 text-sm font-medium uppercase tracking-wider text-blue-400">{{SUBTITLE}}</p>',
            'description_section_when' => '<p class="mx-auto max-w-2xl text-lg text-gray-400">{{DESCRIPTION}}</p>',
            'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
            'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
            'item_links_wrapper_when' => '<div class="mt-auto w-full pt-2">{{ITEM_LINK_ROWS}}</div>',
            'item_link_row' => '<a class="group/btn flex w-full items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-500 py-3 text-sm font-semibold text-white shadow-md transition hover:shadow-lg hover:shadow-blue-600/30" href="{{LINK_URL}}">{{LINK_LABEL}} <svg class="h-4 w-4 transition group-hover/btn:translate-x-0.5 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>',
            'item' => <<<'HTML'
            <div class="group animate-fade-in-up flex h-full flex-col">
            <div class="animated-border-card relative flex h-full min-h-0 flex-col overflow-hidden rounded-2xl border border-blue-500/20 bg-[#1a1b2e] p-6 transition duration-300 hover:border-cyan-400/50 hover:shadow-lg hover:shadow-cyan-500/10 md:p-8">
            <div class="pointer-events-none absolute inset-0 -z-10 rounded-2xl bg-gradient-to-br from-blue-600/5 to-cyan-500/5" aria-hidden="true"></div>
            <h3 class="mb-2 text-2xl font-bold text-white">{{ITEM_TITLE}}</h3>
            {{ITEM_SUBTITLE_SECTION}}
            {{ITEM_CONTENT_SECTION}}
            {{ITEM_LINKS_SECTION}}
            </div>
            </div>
            HTML,
            'item_subtitle_section_when' => '<p class="mb-6 text-sm text-gray-400">{{ITEM_SUBTITLE}}</p>',
            'item_content_section_when' => '<div class="mb-8 space-y-3 [&_svg]:mt-0.5 [&_svg]:h-[18px] [&_svg]:w-[18px] [&_svg]:shrink-0 [&_svg]:text-cyan-400">{{ITEM_CONTENT}}</div>',
            'item_content_raw' => true,
        ],
    ],

      'case_study_section_style_1' => [
        'preview_caption' => 'Case Study Section Style 1 — alternating image + copy rows (2nd item reverses columns)',
        'preview_image'   => 'v1/case_study_section_style_1.png',
        'templates'     => [
            'body' => <<<'HTML'
            <section class="section-fade section-unified relative overflow-hidden py-20">
            <div class="section-soft-glow absolute inset-0 opacity-60" aria-hidden="true"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{SUBTITLE_SECTION}}
            {{DESCRIPTION_SECTION}}
            <div class="flex flex-col">{{ITEMS}}</div>
            {{LINKS_SECTION}}
            </div>
            </section>
            HTML,
            'subtitle_section_when' => '',
            'description_section_when' => '',
            'links_wrapper_when' => '<nav class="mt-12 flex flex-wrap justify-center gap-4" aria-label="Actions">{{LINK_ROWS}}</nav>',
            'link_row' => '<a class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 text-sm font-semibold text-white shadow-lg" href="{{LINK_URL}}">{{LINK_LABEL}}</a>',
            'item_links_wrapper_when' => '<div>{{ITEM_LINK_ROWS}}</div>',
            'item_link_row' => '<a class="inline-flex items-center gap-2 rounded-lg border border-blue-500/30 px-6 py-3 text-sm font-semibold text-white transition hover:border-cyan-400/50" href="{{LINK_URL}}">{{LINK_LABEL}} <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>',
            'item' => <<<'HTML'
            <div class="mb-20 grid animate-fade-in-up items-center gap-12 last:mb-0 md:grid-cols-2 {{ITEM_CARD_SKIN}}">
            <div class="case-study-image relative h-96 overflow-hidden rounded-lg">
            {{ITEM_IMAGE_MARKUP}}
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-[#1A1D4D] to-transparent" aria-hidden="true"></div>
            </div>
            <div class="case-study-content min-w-0">
            <h2 class="mb-4 text-4xl font-bold text-white">{{ITEM_TITLE}}</h2>
            {{ITEM_SUBTITLE_SECTION}}
            {{ITEM_CONTENT_SECTION}}
            {{ITEM_LINKS_SECTION}}
            </div>
            </div>
            HTML,
            'item_subtitle_section_when' => '<p class="mb-6 text-3xl font-bold text-cyan-400">{{ITEM_SUBTITLE}}</p>',
            'item_content_section_when' => '<div class="mb-8 space-y-3 text-gray-400 [&>p:first-child]:mb-6 [&>p:first-child]:text-base [&>p:first-child]:leading-relaxed [&_h4]:mb-1 [&_h4]:font-bold [&_h4]:text-white [&_p]:text-sm">{{ITEM_CONTENT}}</div>',
            'item_content_raw' => true,
        ],
    ],

    'contact_form_section_style_1' => [
        'preview_caption' => 'Contact Form Section Style 1 — contact details left, message form right',
        'preview_image'   => 'v1/contact_form_section_style_1.png',
        'templates'     => [
            'body' => <<<'HTML'
            <section class="section-fade section-unified relative overflow-hidden py-20">
            <div class="section-soft-glow absolute inset-0 opacity-60" aria-hidden="true"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 md:grid-cols-2">
            <div class="animate-slide-in-left">
            <h2 class="mb-8 text-xl font-bold text-black">{{TITLE}}</h2>
            <div class="space-y-8">{{ITEMS}}</div>
            <div class="animated-border-card mt-12 rounded-xl border border-blue-500/20 bg-[#1a1b2e] p-6">
            {{SUBTITLE_SECTION}}
            {{DESCRIPTION_SECTION}}
            </div>
            </div>
            <div class="animate-slide-in-right flex min-w-0 flex-col">
            <form class="cms-contact-form flex w-full flex-col gap-6" data-cms-contact-form data-contact-api-url="/cms/api/contact-messages" method="post" novalidate>
            <input type="hidden" name="company_id" value="" data-cms-company-id />
            <div data-cms-contact-feedback class="hidden rounded-lg border px-4 py-3 text-sm" role="alert"></div>
            <div class="w-full">
            <label for="cms-contact-name" class="mb-2 block text-sm font-medium text-white">Name</label>
            <input id="cms-contact-name" type="text" name="name" required autocomplete="name" class="w-full rounded-lg border border-blue-500/20 bg-[#1a1b2e] px-4 py-2 text-white transition focus:border-cyan-400 focus:outline-none" placeholder="Your name" />
            </div>
            <div class="w-full">
            <label for="cms-contact-email" class="mb-2 block text-sm font-medium text-white">Email</label>
            <input id="cms-contact-email" type="email" name="email" required autocomplete="email" class="w-full rounded-lg border border-blue-500/20 bg-[#1a1b2e] px-4 py-2 text-white transition focus:border-cyan-400 focus:outline-none" placeholder="you@example.com" />
            </div>
            <div class="w-full">
            <label for="cms-contact-phone" class="mb-2 block text-sm font-medium text-white">Phone</label>
            <input id="cms-contact-phone" type="tel" name="phone" required autocomplete="tel" class="w-full rounded-lg border border-blue-500/20 bg-[#1a1b2e] px-4 py-2 text-white transition focus:border-cyan-400 focus:outline-none" placeholder="+1 (555) 000-0000" />
            </div>
            <div class="w-full">
            <label for="cms-contact-message" class="mb-2 block text-sm font-medium text-white">Message</label>
            <textarea id="cms-contact-message" name="message" rows="4" required class="w-full resize-none rounded-lg border border-blue-500/20 bg-[#1a1b2e] px-4 py-2 text-white transition focus:border-cyan-400 focus:outline-none" placeholder="How can we help?"></textarea>
            </div>
            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 px-6 py-3 font-semibold text-white transition hover:shadow-lg hover:shadow-blue-600/30 disabled:pointer-events-none disabled:opacity-60">
            Send message
            <svg class="h-[18px] w-[18px] rtl:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </button>
            </form>
            </div>
            </div>
            </div>
            </section>
            HTML,
            'subtitle_section_when' => '<h3 class="mb-3 font-semibold text-black">{{SUBTITLE}}</h3>',
            'description_section_when' => '<p class="text-sm text-gray">{{DESCRIPTION}}</p>',
            'links_wrapper_when' => '',
            'link_row' => '',
            'item_links_wrapper_when' => '',
            'item_link_row' => '',
            'item' => <<<'HTML'
            <div class="flex gap-4">
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-blue-600 to-cyan-500 text-white [&_svg]:h-5 [&_svg]:w-5">
            {{ITEM_ICON_MARKUP}}
            </div>
            <div class="min-w-0">
            <h3 class="mb-1 font-semibold text-black">{{ITEM_TITLE}}</h3>
            {{ITEM_CONTENT_SECTION}}
            </div>
            </div>
            HTML,
          //   'item_subtitle_section_when' => '<p class="text-gray">{{ITEM_SUBTITLE}}</p>',
            'item_content_section_when' => '<p class="text-gray">{{ITEM_CONTENT}}</p>',
            'item_content_raw' => false,
        ],
    ],
];