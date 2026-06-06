@php
    $itemTypes = ['default' => 'Default', 'card' => 'Card', 'feature' => 'Feature', 'testimonial' => 'Testimonial', 'industry' => 'Industry'];
    $nextSectionIndex = $page->sections->count();
    $locales = $locales ?? ['en' => 'English', 'ar' => 'Arabic'];
    $firstLocale = array_key_first($locales);
    $sectionLayouts = $sectionLayouts ?? config('cms.section_layouts.layouts', []);
    $defaultSectionLayout = $defaultSectionLayout ?? config('cms.section_layouts.default', array_key_first($sectionLayouts) ?: 'hero_section_style_1');
    $cmsBuilderLayoutPreview = $cmsBuilderLayoutPreview ?? \Webkul\Cms\Support\SectionLayoutPreview::scriptPayload($sectionLayouts);
    $cmsBuilderSectionLayoutGuide = [];
    foreach ($sectionLayouts as $layoutKey => $layoutMeta) {
        $preview = $cmsBuilderLayoutPreview[$layoutKey] ?? [];
        $cmsBuilderSectionLayoutGuide[] = [
            'key'             => $layoutKey,
            'label'           => $layoutMeta['label'] ?? $layoutKey,
            'description'     => $layoutMeta['description'] ?? '',
            'preview_image'   => $preview['preview_image'] ?? null,
            'preview_caption' => $preview['preview_caption'] ?? ($layoutMeta['description'] ?? ''),
        ];
    }
@endphp

<x-admin::layouts>
    @include('cms::components.builder-hint-styles')

    <x-slot:title>
        @lang('cms::app.pages.builder.title')
    </x-slot>

    {{-- Admin Tailwind content paths often exclude CMS views; layout utilities may be missing from built CSS --}}
    @pushOnce('styles')
        <style>
            /*
             * Only these rules control the builder row — do not add Tailwind grid-cols-* on the same
             * element or Admin’s compiled CSS can override and stack preview below the editor.
             */
            .cms-section-builder-layout {
                display: grid;
                width: 100%;
                gap: 1rem;
                grid-template-columns: minmax(0, 1fr);
            }
            @media (min-width: 525px) {
                .cms-section-builder-layout {
                    grid-template-columns: minmax(0, 1fr) minmax(260px, 700px) !important;
                    align-items: start;
                    gap: 1.5rem;
                }
                .cms-section-preview-aside {
                    position: sticky;
                    top: 1rem;
                    align-self: start;
                    border-top: none;
                    padding-top: 0;
                }
            }
            @media (max-width: 524px) {
                .cms-section-preview-aside {
                    border-top: 1px solid rgb(229 231 235);
                    padding-top: 1rem;
                }
                .dark .cms-section-preview-aside {
                    border-top-color: rgb(31 41 55);
                }
            }
            [data-cms-section-editor] {
                min-width: 0;
            }
            .cms-section-preview-aside {
                min-width: 0;
            }
            .cms-layout-preview-figure {
                margin: 0;
            }
            .cms-layout-preview-figure img {
                display: block;
                width: 100%;
                height: auto;
                border-radius: 0.5rem;
                border: 1px solid rgb(229 231 235);
                background: rgb(249 250 251);
            }
            .dark .cms-layout-preview-figure img {
                border-color: rgb(55 65 81);
                background: rgb(17 24 39);
            }
            /* Live preview: links as inline text, not admin “button” anchors */
            [data-cms-section-preview] a {
                display: inline !important;
                padding: 0 !important;
                margin: 0;
                border-radius: 0 !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                font-weight: 400;
                color: #2563eb;
                text-decoration: underline;
            }
            [data-cms-section-preview] a:hover {
                color: #1d4ed8;
            }
            .dark [data-cms-section-preview] a {
                color: #60a5fa;
            }
            .dark [data-cms-section-preview] a:hover {
                color: #93c5fd;
            }
            .cms-builder-details > summary {
                list-style: none;
            }
            .cms-builder-details > summary::-webkit-details-marker {
                display: none;
            }
            .cms-builder-details__summary {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 0.75rem;
                user-select: none;
            }
            .cms-builder-details__chev {
                flex-shrink: 0;
                font-size: 0.65rem;
                line-height: 1;
                color: rgb(107 114 128);
                transition: transform 0.15s ease;
            }
            .cms-builder-details[open] > .cms-builder-details__summary .cms-builder-details__chev {
                transform: rotate(-180deg);
            }
            .dark .cms-builder-details__chev {
                color: rgb(156 163 175);
            }
            .cms-builder-remove-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 0.375rem;
                border: 1px solid rgb(252 165 165);
                background: rgb(254 242 242);
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
                font-weight: 500;
                line-height: 1.25;
                color: rgb(185 28 28);
            }
            .cms-builder-remove-btn:hover {
                background: rgb(254 226 226);
            }
            .dark .cms-builder-remove-btn {
                border-color: rgb(127 29 29);
                background: rgb(69 10 10);
                color: rgb(252 165 165);
            }
            .dark .cms-builder-remove-btn:hover {
                background: rgb(127 29 29);
            }
            .cms-layout-preview-zoomable {
                cursor: zoom-in;
                transition: box-shadow 0.15s ease, opacity 0.15s ease;
            }
            .cms-layout-preview-zoomable:hover {
                opacity: 0.92;
                box-shadow: 0 4px 14px rgb(0 0 0 / 0.12);
            }
            .cms-builder-modal {
                position: fixed;
                inset: 0;
                z-index: 10050;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
            }
            .cms-builder-modal[hidden] {
                display: none !important;
            }
            body.cms-builder-modal-open {
                overflow: hidden;
            }
            .cms-builder-modal__backdrop {
                position: absolute;
                inset: 0;
                background: rgb(0 0 0 / 0.65);
            }
            .cms-builder-modal__panel {
                position: relative;
                z-index: 1;
                display: flex;
                flex-direction: column;
                width: 100%;
                max-width: min(95vw, 960px);
                max-height: 90vh;
                overflow: hidden;
                border-radius: 0.75rem;
                border: 1px solid rgb(229 231 235);
                background: rgb(255 255 255);
                box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.35);
            }
            .dark .cms-builder-modal__panel {
                border-color: rgb(55 65 81);
                background: rgb(17 24 39);
            }
            .cms-builder-modal__panel--wide {
                max-width: min(95vw, 1280px);
            }
            .cms-builder-modal__header {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 1rem;
                padding: 1rem 1.25rem;
                border-bottom: 1px solid rgb(229 231 235);
            }
            .dark .cms-builder-modal__header {
                border-bottom-color: rgb(55 65 81);
            }
            .cms-builder-modal__body {
                overflow: auto;
                padding: 1rem 1.25rem 1.25rem;
            }
            .cms-builder-modal__close {
                flex-shrink: 0;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 2rem;
                height: 2rem;
                border-radius: 0.375rem;
                border: 1px solid rgb(229 231 235);
                background: rgb(249 250 251);
                font-size: 1.25rem;
                line-height: 1;
                color: rgb(75 85 99);
            }
            .cms-builder-modal__close:hover {
                background: rgb(243 244 246);
            }
            .dark .cms-builder-modal__close {
                border-color: rgb(55 65 81);
                background: rgb(31 41 55);
                color: rgb(209 213 219);
            }
            .cms-builder-modal__zoom-img {
                display: block;
                width: 100%;
                height: auto;
                max-height: calc(90vh - 8rem);
                object-fit: contain;
                border-radius: 0.5rem;
                background: rgb(249 250 251);
            }
            .dark .cms-builder-modal__zoom-img {
                background: rgb(31 41 55);
            }
            .cms-layout-guide-card {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                border-radius: 0.5rem;
                border: 1px solid rgb(229 231 235);
                background: rgb(249 250 251);
                padding: 0.75rem;
            }
            .dark .cms-layout-guide-card {
                border-color: rgb(55 65 81);
                background: rgb(31 41 55);
            }
            .cms-layout-guide-card img {
                display: block;
                width: 100%;
                height: auto;
                border-radius: 0.375rem;
                border: 1px solid rgb(229 231 235);
                cursor: zoom-in;
            }
            .dark .cms-layout-guide-card img {
                border-color: rgb(55 65 81);
            }
            .cms-layout-guide-grid {
                display: grid;
                grid-template-columns: repeat(1, minmax(0, 1fr));
                gap: 1rem;
            }
            @media (min-width: 640px) {
                .cms-layout-guide-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }
            @media (min-width: 1024px) {
                .cms-layout-guide-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }
        </style>
    @endPushOnce

    {{-- Native <form>: Vue <v-form> (x-admin::form) re-renders its subtree and clears live preview panels. --}}
    <form action="{{ route('admin.cms.pages.builder.update', $page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <x-admin::breadcrumbs name="cms.pages.builder" :entity="$page" />

                    <div class="text-xl font-bold dark:text-white">
                        @lang('cms::app.pages.builder.title')
                    </div>
                    <!-- <p class="max-w-3xl text-sm text-gray-600 dark:text-gray-400">
                        @lang('cms::app.pages.builder.help')
                    </p> -->
                </div>

                <div class="flex flex-shrink-0 flex-col items-end gap-2">
                    <a href="{{ route('admin.cms.pages.edit', $page->id) }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400">
                        @lang('cms::app.pages.edit.title')
                    </a>
                    <button type="submit" class="primary-button">
                        @lang('cms::app.pages.builder.save-btn')
                    </button>
                </div>
            </div>

            <!-- <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <p class="mb-3 text-base font-semibold text-gray-800 dark:text-white">@lang('cms::app.pages.form.general') — sync options</p>
                <div class="flex flex-col gap-3 text-sm text-gray-700 dark:text-gray-300">
                    <input type="hidden" name="sync_sections" value="0" />
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="sync_sections" value="1" class="h-4 w-4 rounded border-gray-300" @checked(old('sync_sections', true)) />
                        @lang('cms::app.pages.builder.sync-sections-label')
                    </label>
                    <input type="hidden" name="prune_sections" value="0" />
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="prune_sections" value="1" class="h-4 w-4 rounded border-gray-300" @checked(old('prune_sections', true)) />
                        @lang('cms::app.pages.builder.prune-sections-label')
                    </label>

                    <input type="hidden" name="sync_page_links" value="0" />
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="sync_page_links" value="1" class="h-4 w-4 rounded border-gray-300" @checked(old('sync_page_links', true)) />
                        @lang('cms::app.pages.builder.sync-page-links-label')
                    </label>
                    <input type="hidden" name="prune_page_links" value="0" />
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="prune_page_links" value="1" class="h-4 w-4 rounded border-gray-300" @checked(old('prune_page_links', true)) />
                        @lang('cms::app.pages.builder.prune-page-links-label')
                    </label>
                </div>
            </div> -->

            <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
                <p class="mb-3 text-base font-semibold text-gray-800 dark:text-white">
                    @lang('cms::app.menu.pages')
                </p>
                <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    @lang('cms::app.pages.form.general') · @lang('cms::app.pages.form.translations')
                </p>
                @include('cms::pages._form', ['page' => $page, 'companies' => $companies])
            </div>

            <x-admin::accordion>
                <x-slot:header>
                    <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('cms::app.pages.builder.page-links-heading')
                    </p>
                </x-slot>
                <x-slot:content>
                    <div class="flex flex-col gap-3 p-2.5" data-cms-page-links>
                        @forelse ($page->links as $pi => $link)
                            @include('cms::pages.partials.builder-link', [
                                'namePrefix' => 'page_links['.$pi.']',
                                'oldPrefix' => 'page_links.'.$pi,
                                'link' => $link,
                                'tabGroupId' => 'cms-builder-page-link-'.$pi,
                                'locales' => $locales,
                                'showRemove' => true,
                            ])
                        @empty
                            @include('cms::pages.partials.builder-link', [
                                'namePrefix' => 'page_links[0]',
                                'oldPrefix' => 'page_links.0',
                                'link' => null,
                                'tabGroupId' => 'cms-builder-page-link-0',
                                'locales' => $locales,
                                'showRemove' => true,
                            ])
                        @endforelse
                    </div>
                    <button type="button" class="secondary-button mt-2 w-fit text-xs" data-cms-add-page-link onclick="window.cmsBuilderAddPageLink && window.cmsBuilderAddPageLink(); return false;">
                        @lang('cms::app.pages.builder.add-link')
                    </button>
                </x-slot>
            </x-admin::accordion>

            <div id="cms-sections-root" class="flex flex-col gap-4">
                @foreach ($page->sections as $si => $section)
                    @php
                        $__sectionLayout = old('sections.'.$si.'.section_layout', $section->section_layout);
                        if (! is_string($__sectionLayout) || ! isset($sectionLayouts[$__sectionLayout])) {
                            $__sectionLayout = $defaultSectionLayout;
                        }
                    @endphp
                    <div
                        class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900"
                        data-cms-section
                        data-section-index="{{ $si }}"
                        data-preview-locale="en"
                        data-main-media-url="{{ e($section->getFirstMediaUrl('main_media')) }}"
                    >
                        <input type="hidden" name="sections[{{ $si }}][id]" value="{{ old('sections.'.$si.'.id', $section->id) }}" />

                        <div class="mb-3 flex flex-wrap items-center gap-2 border-b border-gray-200 pb-3 dark:border-gray-800">
                            <button
                                type="button"
                                class="secondary-button text-xs"
                                data-cms-open-layout-guide
                            >
                                @lang('cms::app.pages.builder.layout-guide-btn')
                            </button>
                        </div>

                        {{-- Native <details>: works for cloned “Add section” HTML (Vue accordions would not compile). --}}
                        <div class="cms-section-builder-layout w-full">
                            <div class="min-w-0">
                                <details class="cms-builder-details rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900/50" {!! $si === 0 ? 'open' : '' !!}>
                                    <summary class="cms-builder-details__summary rounded-t-lg bg-white px-3 py-2.5 dark:bg-gray-900">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-base font-semibold text-gray-800 dark:text-white" data-cms-section-heading>
                                                @lang('cms::app.pages.builder.section') #{{ $si + 1 }}
                                            </p>
                                            <p class="truncate text-xs text-gray-500 dark:text-gray-400" title="{{ e(old('sections.'.$si.'.name', $section->name)) }}">
                                                {{ old('sections.'.$si.'.name', $section->name) }}
                                            </p>
                                        </div>
                                        <button
                                            type="button"
                                            class="cms-builder-remove-btn shrink-0"
                                            data-cms-remove-section
                                            aria-label="@lang('cms::app.pages.builder.remove-section')"
                                        >
                                            @lang('cms::app.pages.builder.remove-section')
                                        </button>
                                        <span class="cms-builder-details__chev" aria-hidden="true">▼</span>
                                    </summary>
                                    <div class="space-y-4 border-t border-gray-200 bg-white p-3 dark:border-gray-800 dark:bg-gray-900" data-cms-section-editor>
                                <div class="grid gap-3 grid-cols-3 md:grid-cols-2 lg:grid-cols-3">
                                    <div>
                                        <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.sections.form.name')</label>
                                        <input
                                            type="text"
                                            name="sections[{{ $si }}][name]"
                                            value="{{ old('sections.'.$si.'.name', $section->name) }}"
                                            class="cms-section-preview-trigger w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                                            required
                                        />
                                    </div>
				<div>
                                        <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.pages.form.order')</label>
                                        <input
                                            type="number"
                                            name="sections[{{ $si }}][order]"
                                            value="{{ old('sections.'.$si.'.order', $section->order) }}"
                                            class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                                        />
                                    </div>
 	                   
                                </div>

                               

			<div class="grid gap-3 grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
				
				<div>
				<label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.pages.builder.layout-label')</label>
				<p class="mb-2 text-xs text-gray-500 dark:text-gray-400">@lang('cms::app.pages.builder.layout-description')</p>
				<select
					name="sections[{{ $si }}][section_layout]"
					class="cms-section-layout-select cms-section-preview-trigger w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
					required
					data-cms-section-layout
				>
					@foreach ($sectionLayouts as $layoutKey => $layoutMeta)
					<option
					value="{{ $layoutKey }}"
					data-description="{{ e($layoutMeta['description'] ?? '') }}"
					@selected($__sectionLayout === $layoutKey)
					>
					{{ $layoutMeta['label'] ?? $layoutKey }}
					</option>
					@endforeach
				</select>
				<p class="cms-section-layout-description mt-1 text-xs text-gray-500 dark:text-gray-400">
					{{ $sectionLayouts[$__sectionLayout]['description'] ?? '' }}
				</p>
				</div>
					
				<div class="flex items-end gap-2 pb-1">
					<label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
					<input type="checkbox" name="sections[{{ $si }}][is_active]" value="1" class="h-4 w-4 rounded border-gray-300" @checked(old('sections.'.$si.'.is_active', $section->is_active)) />
					@lang('cms::app.pages.form.active')
					</label>
				</div>
			</div>

                        <div class="mt-3" data-cms-section-main-media>
                            @include('cms::components.media-manager', [
                                'entity' => $section,
                                'uid' => 'cms-builder-section-'.$si.'-media',
                                'mainOnly' => true,
                                'namePrefix' => 'sections['.$si.']',
                            ])
                        </div>

                        @php($sectionTabId = 'cms-builder-section-translations-'.$si)
                        <div class="mt-4">
                            <p class="mb-2 text-sm font-semibold text-gray-800 dark:text-white">
                                @lang('cms::app.menu.sections') — @lang('cms::app.pages.form.translations')
                            </p>
                            <div class="mb-3 flex flex-wrap gap-2">
                                @foreach ($locales as $locale => $localeLabel)
                                    <button
                                        type="button"
                                        class="cms-locale-tab rounded-md border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-950 {{ $locale === $firstLocale ? 'bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-white' : '' }}"
                                        data-tab-group="{{ $sectionTabId }}"
                                        data-tab="{{ $locale }}"
                                    >
                                        {{ $localeLabel }} ({{ $locale }})
                                    </button>
                                @endforeach
                            </div>
                            @foreach ($locales as $locale => $localeLabel)
                                @php($st = $section->translate($locale, false))
                                <div
                                    class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
                                    data-tab-group="{{ $sectionTabId }}"
                                    data-tab-panel="{{ $locale }}"
                                >
                                    <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.sections.form.title_en')</label>
                                    <input
                                        type="text"
                                        name="sections[{{ $si }}][translations][{{ $locale }}][title]"
                                        value="{{ old('sections.'.$si.'.translations.'.$locale.'.title', $st?->title) }}"
                                        class="mb-2 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
                                        @if ($locale === 'en') required @endif
                                    />
                                    <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.sections.form.subtitle_en')</label>
                                    <input
                                        type="text"
                                        name="sections[{{ $si }}][translations][{{ $locale }}][subtitle]"
                                        value="{{ old('sections.'.$si.'.translations.'.$locale.'.subtitle', $st?->subtitle) }}"
                                        class="mb-2 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
                                    />
                                    <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.sections.form.description_en')</label>
                                    <textarea
                                        name="sections[{{ $si }}][translations][{{ $locale }}][description]"
                                        rows="2"
                                        class="w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
                                    >{{ old('sections.'.$si.'.translations.'.$locale.'.description', $st?->description) }}</textarea>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            <p class="mb-2 text-sm font-semibold text-gray-800 dark:text-white">@lang('cms::app.pages.builder.links-heading') (@lang('cms::app.links.form.linkable_section'))</p>
                            <div class="flex flex-col gap-3" data-cms-section-links>
                                @foreach ($section->links as $sli => $link)
                                    @include('cms::pages.partials.builder-link', [
                                        'namePrefix' => 'sections['.$si.'][links]['.$sli.']',
                                        'oldPrefix' => 'sections.'.$si.'.links.'.$sli,
                                        'link' => $link,
                                        'tabGroupId' => 'cms-builder-section-'.$si.'-link-'.$sli,
                                        'locales' => $locales,
                                        'showRemove' => true,
                                    ])
                                @endforeach
                            </div>
                            <button type="button" class="secondary-button mt-2 w-fit text-xs" data-cms-add-section-link onclick="window.cmsBuilderAddSectionLink && window.cmsBuilderAddSectionLink(this); return false;">
                                @lang('cms::app.pages.builder.add-link')
                            </button>
                        </div>

                        <div class="mt-4">
                            <p class="mb-2 text-sm font-semibold text-gray-800 dark:text-white">@lang('cms::app.pages.builder.items-heading')</p>
                            @foreach ($section->items as $ii => $item)
                                <details
                                    class="cms-builder-details cms-builder-details--item mb-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-900/30"
                                    data-cms-item-index="{{ $ii }}"
                                    data-main-media-url="{{ e($item->getFirstMediaUrl('main_media')) }}"
                                    {!! $ii === 0 ? 'open' : '' !!}
                                >
                                    <summary class="cms-builder-details__summary cursor-pointer rounded-t-md border-b border-dashed border-gray-200 bg-white px-3 py-2 dark:border-gray-600 dark:bg-gray-900">
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-semibold text-gray-800 dark:text-white" data-cms-item-heading>
                                                @lang('cms::app.menu.items') #{{ $ii + 1 }}
                                            </p>
                                            @php($itHdr = $item->translate($firstLocale, false))
                                            <p class="truncate text-xs text-gray-500 dark:text-gray-400" title="{{ e(old('sections.'.$si.'.items.'.$ii.'.translations.'.$firstLocale.'.title', $itHdr?->title)) }}">
                                                {{ old('sections.'.$si.'.items.'.$ii.'.translations.'.$firstLocale.'.title', $itHdr?->title) ?: '—' }}
                                            </p>
                                        </div>
                                        <button
                                            type="button"
                                            class="cms-builder-remove-btn shrink-0"
                                            data-cms-remove-item
                                            aria-label="@lang('cms::app.pages.builder.remove-item')"
                                        >
                                            @lang('cms::app.pages.builder.remove-item')
                                        </button>
                                        <span class="cms-builder-details__chev" aria-hidden="true">▼</span>
                                    </summary>
                                    <div class="space-y-3 border-t-0 bg-white p-3 dark:bg-gray-900">
                                    <input type="hidden" name="sections[{{ $si }}][items][{{ $ii }}][id]" value="{{ old('sections.'.$si.'.items.'.$ii.'.id', $item->id) }}" />
                                    <div class="grid gap-3 md:grid-cols-2">
                                        <div>
                                            <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.type')</label>
                                            <select name="sections[{{ $si }}][items][{{ $ii }}][type]" class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900">
                                                @foreach ($itemTypes as $val => $label)
                                                    <option value="{{ $val }}" @selected(old('sections.'.$si.'.items.'.$ii.'.type', $item->type) === $val)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex items-end gap-2 pb-1">
                                            <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                                <input type="checkbox" name="sections[{{ $si }}][items][{{ $ii }}][is_active]" value="1" class="h-4 w-4 rounded border-gray-300" @checked(old('sections.'.$si.'.items.'.$ii.'.is_active', $item->is_active)) />
                                                @lang('cms::app.pages.form.active')
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mt-3" data-cms-item-main-media>
                                        @include('cms::components.media-manager', [
                                            'entity' => $item,
                                            'uid' => 'cms-builder-item-'.$si.'-'.$ii.'-media',
                                            'mainOnly' => true,
                                            'namePrefix' => 'sections['.$si.'][items]['.$ii.']',
                                        ])
                                    </div>

                                    @php($itemTabId = 'cms-builder-item-translations-'.$si.'-'.$ii)
                                    <div class="mt-3">
                                        <p class="mb-2 text-xs font-semibold text-gray-700 dark:text-gray-300">
                                            @lang('cms::app.menu.items') — @lang('cms::app.pages.form.translations')
                                        </p>
                                        <div class="mb-3 flex flex-wrap gap-2">
                                            @foreach ($locales as $locale => $localeLabel)
                                                <button
                                                    type="button"
                                                    class="cms-locale-tab rounded-md border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-950 {{ $locale === $firstLocale ? 'bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-white' : '' }}"
                                                    data-tab-group="{{ $itemTabId }}"
                                                    data-tab="{{ $locale }}"
                                                >
                                                    {{ $localeLabel }} ({{ $locale }})
                                                </button>
                                            @endforeach
                                        </div>
                                        @foreach ($locales as $locale => $localeLabel)
                                            @php($it = $item->translate($locale, false))
                                            <div
                                                class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
                                                data-tab-group="{{ $itemTabId }}"
                                                data-tab-panel="{{ $locale }}"
                                            >
                                                <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.title')</label>
                                                <input
                                                    type="text"
                                                    name="sections[{{ $si }}][items][{{ $ii }}][translations][{{ $locale }}][title]"
                                                    value="{{ old('sections.'.$si.'.items.'.$ii.'.translations.'.$locale.'.title', $it?->title) }}"
                                                    class="mb-2 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
                                                    @if ($locale === 'en') required @endif
                                                />
                                                <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.sub_title')</label>
                                                <input
                                                    type="text"
                                                    name="sections[{{ $si }}][items][{{ $ii }}][translations][{{ $locale }}][sub_title]"
                                                    value="{{ old('sections.'.$si.'.items.'.$ii.'.translations.'.$locale.'.sub_title', $it?->sub_title) }}"
                                                    class="mb-2 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
                                                />
                                                <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.content')</label>
                                                <textarea
                                                    name="sections[{{ $si }}][items][{{ $ii }}][translations][{{ $locale }}][content]"
                                                    rows="2"
                                                    class="w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
                                                >{{ old('sections.'.$si.'.items.'.$ii.'.translations.'.$locale.'.content', $it?->content) }}</textarea>
                                                <label class="mb-1 mt-2 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.icon')</label>
                                                <input
                                                    type="text"
                                                    name="sections[{{ $si }}][items][{{ $ii }}][translations][{{ $locale }}][icon]"
                                                    value="{{ old('sections.'.$si.'.items.'.$ii.'.translations.'.$locale.'.icon', $it?->icon) }}"
                                                    class="w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
                                                />
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-3">
                                        <p class="mb-2 text-xs font-semibold text-gray-700 dark:text-gray-300">@lang('cms::app.pages.builder.links-heading') (@lang('cms::app.links.form.linkable_item'))</p>
                                        <div class="flex flex-col gap-3" data-cms-item-links>
                                            @foreach ($item->links as $ili => $link)
                                                @include('cms::pages.partials.builder-link', [
                                                    'namePrefix' => 'sections['.$si.'][items]['.$ii.'][links]['.$ili.']',
                                                    'oldPrefix' => 'sections.'.$si.'.items.'.$ii.'.links.'.$ili,
                                                    'link' => $link,
                                                    'tabGroupId' => 'cms-builder-item-'.$si.'-'.$ii.'-link-'.$ili,
                                                    'locales' => $locales,
                                                    'showRemove' => true,
                                                ])
                                            @endforeach
                                        </div>
                                        <button type="button" class="secondary-button mt-2 w-fit text-xs" data-cms-add-item-link onclick="window.cmsBuilderAddItemLink && window.cmsBuilderAddItemLink(this); return false;">
                                            @lang('cms::app.pages.builder.add-link')
                                        </button>
                                    </div>
                                    </div>
                                </details>
                            @endforeach
                            <button type="button" class="secondary-button mt-2 w-fit text-xs" data-cms-add-item onclick="window.cmsBuilderAddItem && window.cmsBuilderAddItem(this); return false;">
                                @lang('cms::app.pages.builder.add-item')
                            </button>
                        </div>

                                    </div>{{-- data-cms-section-editor --}}
                                </details>
                            </div>

                            <aside class="cms-section-preview-aside space-y-2">
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    @lang('cms::app.pages.builder.layout-preview-thumb')
                                </p>
                                {{-- Live HTML preview disabled for now — layout reference image only --}}
                                {{--
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                    @lang('cms::app.pages.builder.preview-heading')
                                </p>
                                <div
                                    class="cms-section-preview-shell max-h-[min(70vh,560px)] min-h-[220px] overflow-auto rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm text-gray-800 shadow-inner dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100"
                                    data-cms-section-preview
                                ></div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    @lang('cms::app.pages.builder.preview-locale-hint')
                                </p>
                                --}}
                                <figure class="cms-layout-preview-figure" data-cms-layout-preview-figure hidden>
                                    <img
                                        alt=""
                                        loading="lazy"
                                        decoding="async"
                                        class="cms-layout-preview-zoomable mt-2 w-full rounded-lg border border-gray-200 dark:border-gray-700"
                                        data-cms-layout-preview-image
                                        title="@lang('cms::app.pages.builder.layout-preview-zoom-hint')"
                                        hidden
                                    />
                                    <figcaption class="mt-1 text-xs text-gray-500 dark:text-gray-400" data-cms-layout-preview-caption hidden></figcaption>
                                    <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                                        @lang('cms::app.pages.builder.layout-preview-zoom-hint')
                                    </p>
                                </figure>
                            </aside>

                        </div>{{-- editor + preview row --}}

                    </div>{{-- data-cms-section --}}
                @endforeach
            </div>

            <button
                type="button"
                id="cms-add-section"
                class="secondary-button w-fit"
                onclick="window.cmsBuilderAddSection && window.cmsBuilderAddSection(); return false;"
            >
                @lang('cms::app.pages.builder.add-section')
            </button>
        </div>
    </form>

    <div id="cms-section-template" class="hidden" aria-hidden="true">
        <div
            class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900"
            data-cms-section
            data-section-index="__SI__"
            data-preview-locale="en"
            data-main-media-url=""
        >
            <input type="hidden" name="sections[__SI__][id]" value="" />
            <div class="mb-3 flex flex-wrap items-center gap-2 border-b border-gray-200 pb-3 dark:border-gray-800">
                <button
                    type="button"
                    class="secondary-button text-xs"
                    data-cms-open-layout-guide
                >
                    @lang('cms::app.pages.builder.layout-guide-btn')
                </button>
            </div>
            <div class="cms-section-builder-layout w-full">
                <div class="min-w-0">
                    <details class="cms-builder-details rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-800 dark:bg-gray-900/50" open>
                        <summary class="cms-builder-details__summary rounded-t-lg bg-white px-3 py-2.5 dark:bg-gray-900">
                            <div class="min-w-0 flex-1">
                                <p class="text-base font-semibold text-gray-800 dark:text-white" data-cms-section-heading>
                                    @lang('cms::app.pages.builder.section')
                                </p>
                                <p class="truncate text-xs text-gray-500 dark:text-gray-400">—</p>
                            </div>
                            <button
                                type="button"
                                class="cms-builder-remove-btn shrink-0"
                                data-cms-remove-section
                                aria-label="@lang('cms::app.pages.builder.remove-section')"
                            >
                                @lang('cms::app.pages.builder.remove-section')
                            </button>
                            <span class="cms-builder-details__chev" aria-hidden="true">▼</span>
                        </summary>
                        <div class="space-y-4 border-t border-gray-200 bg-white p-3 dark:border-gray-800 dark:bg-gray-900" data-cms-section-editor>
                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.sections.form.name')</label>
                            <input type="text" name="sections[__SI__][name]" required class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900" />
                        </div>
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.pages.builder.layout-label')</label>
                        <p class="mb-2 text-xs text-gray-500 dark:text-gray-400">@lang('cms::app.pages.builder.layout-description')</p>
                        <select
                            name="sections[__SI__][section_layout]"
                            required
                            class="cms-section-layout-select w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                            data-cms-section-layout
                        >
                            @foreach ($sectionLayouts as $layoutKey => $layoutMeta)
                                <option
                                    value="{{ $layoutKey }}"
                                    data-description="{{ e($layoutMeta['description'] ?? '') }}"
                                    @selected($layoutKey === $defaultSectionLayout)
                                >
                                    {{ $layoutMeta['label'] ?? $layoutKey }}
                                </option>
                            @endforeach
                        </select>
                        <p class="cms-section-layout-description mt-1 text-xs text-gray-500 dark:text-gray-400"></p>
                    </div>
                    <div class="grid gap-3 md:grid-cols-2">
                        <div>
                            <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.pages.form.order')</label>
                            <input type="number" name="sections[__SI__][order]" value="0" class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900" />
                        </div>
                        <div class="flex items-end gap-2 pb-1">
                            <input type="hidden" name="sections[__SI__][is_active]" value="0" />
                            <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                <input type="checkbox" name="sections[__SI__][is_active]" value="1" checked class="h-4 w-4 rounded border-gray-300" />
                                @lang('cms::app.pages.form.active')
                            </label>
                        </div>
                    </div>
                    <div class="mt-3" data-cms-section-main-media>
                        @include('cms::components.media-manager', [
                            'entity' => null,
                            'uid' => 'cms-builder-section-__SI__-media',
                            'mainOnly' => true,
                            'namePrefix' => 'sections[__SI__]',
                        ])
                    </div>
                    @php($tplSectionTabId = 'cms-builder-section-translations-__SI__')
                    <div class="mt-3">
                        <p class="mb-2 text-sm font-semibold text-gray-800 dark:text-white">@lang('cms::app.pages.form.translations')</p>
                        <div class="mb-3 flex flex-wrap gap-2">
                            @foreach ($locales as $locale => $localeLabel)
                                <button
                                    type="button"
                                    class="cms-locale-tab rounded-md border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-950 {{ $locale === $firstLocale ? 'bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-white' : '' }}"
                                    data-tab-group="{{ $tplSectionTabId }}"
                                    data-tab="{{ $locale }}"
                                >
                                    {{ $localeLabel }} ({{ $locale }})
                                </button>
                            @endforeach
                        </div>
                        @foreach ($locales as $locale => $localeLabel)
                            <div
                                class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
                                data-tab-group="{{ $tplSectionTabId }}"
                                data-tab-panel="{{ $locale }}"
                            >
                                <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.sections.form.title_en')</label>
                                <input
                                    type="text"
                                    name="sections[__SI__][translations][{{ $locale }}][title]"
                                    class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                                    @if ($locale === 'en') required @endif
                                />
                            </div>
                        @endforeach
                    </div>
                        </div>{{-- data-cms-section-editor --}}
                    </details>
                </div>
                <aside class="cms-section-preview-aside space-y-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        @lang('cms::app.pages.builder.layout-preview-thumb')
                    </p>
                    {{-- Live HTML preview disabled for now — layout reference image only --}}
                    {{--
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                        @lang('cms::app.pages.builder.preview-heading')
                    </p>
                    <div
                        class="cms-section-preview-shell max-h-[min(70vh,560px)] min-h-[220px] overflow-auto rounded-lg border border-gray-200 bg-gray-50 p-3 text-sm text-gray-800 shadow-inner dark:border-gray-700 dark:bg-gray-950 dark:text-gray-100"
                        data-cms-section-preview
                    ></div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        @lang('cms::app.pages.builder.preview-locale-hint')
                    </p>
                    --}}
                    <figure class="cms-layout-preview-figure" data-cms-layout-preview-figure hidden>
                        <img
                            alt=""
                            loading="lazy"
                            decoding="async"
                            class="cms-layout-preview-zoomable mt-2 w-full rounded-lg border border-gray-200 dark:border-gray-700"
                            data-cms-layout-preview-image
                            title="@lang('cms::app.pages.builder.layout-preview-zoom-hint')"
                            hidden
                        />
                        <figcaption class="mt-1 text-xs text-gray-500 dark:text-gray-400" data-cms-layout-preview-caption hidden></figcaption>
                        <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">
                            @lang('cms::app.pages.builder.layout-preview-zoom-hint')
                        </p>
                    </figure>
                </aside>
            </div>
        </div>
    </div>

    <div id="cms-layout-image-zoom-modal" class="cms-builder-modal" hidden aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="cms-layout-zoom-modal-title">
        <div class="cms-builder-modal__backdrop" data-cms-close-modal tabindex="-1"></div>
        <div class="cms-builder-modal__panel">
            <div class="cms-builder-modal__header">
                <div class="min-w-0">
                    <p id="cms-layout-zoom-modal-title" class="text-base font-semibold text-gray-800 dark:text-white">
                        @lang('cms::app.pages.builder.layout-preview-zoom-title')
                    </p>
                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400" data-cms-zoom-modal-caption></p>
                </div>
                <button type="button" class="cms-builder-modal__close" data-cms-close-modal aria-label="@lang('cms::app.pages.builder.modal-close')">
                    ×
                </button>
            </div>
            <div class="cms-builder-modal__body">
                <img alt="" class="cms-builder-modal__zoom-img" data-cms-zoom-modal-image />
            </div>
        </div>
    </div>

    <div id="cms-layout-guide-modal" class="cms-builder-modal" hidden aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="cms-layout-guide-modal-title">
        <div class="cms-builder-modal__backdrop" data-cms-close-modal tabindex="-1"></div>
        <div class="cms-builder-modal__panel cms-builder-modal__panel--wide">
            <div class="cms-builder-modal__header">
                <div class="min-w-0">
                    <p id="cms-layout-guide-modal-title" class="text-base font-semibold text-gray-800 dark:text-white">
                        @lang('cms::app.pages.builder.layout-guide-title')
                    </p>
                    <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                        @lang('cms::app.pages.builder.layout-guide-help')
                    </p>
                </div>
                <button type="button" class="cms-builder-modal__close" data-cms-close-modal aria-label="@lang('cms::app.pages.builder.modal-close')">
                    ×
                </button>
            </div>
            <div class="cms-builder-modal__body">
                <div class="cms-layout-guide-grid" data-cms-layout-guide-grid></div>
            </div>
        </div>
    </div>

    {{-- Link template (used by add-link buttons) --}}
    <div id="cms-link-template" class="hidden" aria-hidden="true">
        @include('cms::pages.partials.builder-link', [
            'namePrefix' => '__LINK_PREFIX__',
            'oldPrefix' => '__LINK_OLD_PREFIX__',
            'link' => null,
            'tabGroupId' => '__LINK_TAB_GROUP__',
            'locales' => $locales,
            'showRemove' => true,
        ])
    </div>

    {{-- Item template (used by add-item button) --}}
    <div id="cms-item-template" class="hidden" aria-hidden="true">
        <details
            class="cms-builder-details cms-builder-details--item mb-4 rounded-lg border border-dashed border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-900/30"
            data-cms-item-index="__II__"
            data-main-media-url=""
            open
        >
            <summary class="cms-builder-details__summary cursor-pointer rounded-t-md border-b border-dashed border-gray-200 bg-white px-3 py-2 dark:border-gray-600 dark:bg-gray-900">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-800 dark:text-white" data-cms-item-heading>
                        @lang('cms::app.menu.items')
                    </p>
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">—</p>
                </div>
                <button type="button" class="cms-builder-remove-btn shrink-0" data-cms-remove-item aria-label="@lang('cms::app.pages.builder.remove-item')">
                    @lang('cms::app.pages.builder.remove-item')
                </button>
                <span class="cms-builder-details__chev" aria-hidden="true">▼</span>
            </summary>
            <div class="space-y-3 border-t-0 bg-white p-3 dark:bg-gray-900">
                <input type="hidden" name="sections[__SI__][items][__II__][id]" value="" />
                <div class="grid gap-3 md:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-medium text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.type')</label>
                        <select name="sections[__SI__][items][__II__][type]" class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900">
                            @foreach ($itemTypes as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end gap-2 pb-1">
                        <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <input type="checkbox" name="sections[__SI__][items][__II__][is_active]" value="1" checked class="h-4 w-4 rounded border-gray-300" />
                            @lang('cms::app.pages.form.active')
                        </label>
                    </div>
                </div>
                <div class="mt-3" data-cms-item-main-media>
                    @include('cms::components.media-manager', [
                        'entity' => null,
                        'uid' => 'cms-builder-item-__SI__-__II__-media',
                        'mainOnly' => true,
                        'namePrefix' => 'sections[__SI__][items][__II__]',
                    ])
                </div>
                @php($tplItemTabId = 'cms-builder-item-translations-__SI__-__II__')
                <div class="mt-3">
                    <p class="mb-2 text-xs font-semibold text-gray-700 dark:text-gray-300">
                        @lang('cms::app.menu.items') — @lang('cms::app.pages.form.translations')
                    </p>
                    <div class="mb-3 flex flex-wrap gap-2">
                        @foreach ($locales as $locale => $localeLabel)
                            <button
                                type="button"
                                class="cms-locale-tab rounded-md border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-950 {{ $locale === $firstLocale ? 'bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-white' : '' }}"
                                data-tab-group="{{ $tplItemTabId }}"
                                data-tab="{{ $locale }}"
                            >
                                {{ $localeLabel }} ({{ $locale }})
                            </button>
                        @endforeach
                    </div>
                    @foreach ($locales as $locale => $localeLabel)
                        <div
                            class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
                            data-tab-group="{{ $tplItemTabId }}"
                            data-tab-panel="{{ $locale }}"
                        >
                            <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.title')</label>
                            <input type="text" name="sections[__SI__][items][__II__][translations][{{ $locale }}][title]" class="mb-2 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900" @if ($locale === 'en') required @endif />
                            <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.sub_title')</label>
                            <input type="text" name="sections[__SI__][items][__II__][translations][{{ $locale }}][sub_title]" class="mb-2 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900" />
                            <label class="mb-1 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.content')</label>
                            <textarea name="sections[__SI__][items][__II__][translations][{{ $locale }}][content]" rows="2" class="w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"></textarea>
                            <label class="mb-1 mt-2 block text-xs text-gray-600 dark:text-gray-300">@lang('cms::app.items.form.icon')</label>
                            <input type="text" name="sections[__SI__][items][__II__][translations][{{ $locale }}][icon]" class="w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900" />
                        </div>
                    @endforeach
                </div>
                <div class="mt-3">
                    <p class="mb-2 text-xs font-semibold text-gray-700 dark:text-gray-300">@lang('cms::app.pages.builder.links-heading') (@lang('cms::app.links.form.linkable_item'))</p>
                    <div class="flex flex-col gap-3" data-cms-item-links></div>
                    <button type="button" class="secondary-button mt-2 w-fit text-xs" data-cms-add-item-link onclick="window.cmsBuilderAddItemLink && window.cmsBuilderAddItemLink(this); return false;">
                        @lang('cms::app.pages.builder.add-link')
                    </button>
                </div>
            </div>
        </details>
    </div>

    @pushOnce('scripts', 'cms.builder.section-live-preview')
        <script>
            (() => {
                const LAYOUT_PREVIEW = @json($cmsBuilderLayoutPreview);
                const LAYOUT_FALLBACK = @json($defaultSectionLayout);
                const SECTION_LAYOUT_GUIDE = @json($cmsBuilderSectionLayoutGuide);
                const CMS_MODAL_LABELS = {
                    noPreview: @json(__('cms::app.pages.builder.layout-guide-no-preview')),
                };

                const esc = (s) => {
                    const d = document.createElement('div');
                    d.textContent = s == null ? '' : String(s);

                    return d.innerHTML;
                };

                const escAttr = (s) => esc(s).replace(/"/g, '&quot;');

                const escUrl = (u) => {
                    const s = u == null ? '' : String(u);
                    if (s === '') {
                        return '';
                    }
                    if (s.startsWith('blob:')) {
                        return s;
                    }

                    return esc(s);
                };

                const tplToken = (k) => '{' + '{' + k + '}' + '}';

                const applyTpl = (template, map) => {
                    if (! template) {
                        return '';
                    }
                    let out = template;
                    for (const [k, v] of Object.entries(map)) {
                        out = out.split(tplToken(k)).join(v == null ? '' : String(v));
                    }

                    return out;
                };

                const layoutDefinition = (layoutKey) => {
                    let def = LAYOUT_PREVIEW[layoutKey];
                    if (! def?.templates?.body) {
                        def = LAYOUT_PREVIEW[LAYOUT_FALLBACK] || def;
                    }
                    if (! def?.templates?.body) {
                        def = Object.values(LAYOUT_PREVIEW)[0];
                    }

                    return def;
                };

                const CONTACT_FORM_ICON_MAIL = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>';
                const CONTACT_FORM_ICON_PHONE = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>';
                const CONTACT_FORM_ICON_MESSAGE = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>';
                const CONTACT_FORM_ICONS_BY_INDEX = [CONTACT_FORM_ICON_MAIL, CONTACT_FORM_ICON_PHONE, CONTACT_FORM_ICON_MESSAGE];

                const contactFormItemIconMarkup = (rawIcon, itemIndex) => {
                    const key = rawIcon ? String(rawIcon).trim().toLowerCase() : '';
                    if (/^https?:\/\//i.test(key) || key.startsWith('/')) {
                        return `<img src="${esc(key)}" alt="" class="h-5 w-5 object-contain" loading="lazy" decoding="async" />`;
                    }
                    if (key.includes('phone') || key.includes('tel')) {
                        return CONTACT_FORM_ICON_PHONE;
                    }
                    if (key.includes('message') || key.includes('whatsapp') || key.includes('chat')) {
                        return CONTACT_FORM_ICON_MESSAGE;
                    }
                    if (key.includes('mail') || key.includes('email')) {
                        return CONTACT_FORM_ICON_MAIL;
                    }

                    return CONTACT_FORM_ICONS_BY_INDEX[itemIndex % CONTACT_FORM_ICONS_BY_INDEX.length];
                };

                const renderFromConfig = (layoutKey, data) => {
                    const def = layoutDefinition(layoutKey);
                    if (! def?.templates?.body) {
                        return `<div class="text-sm text-gray-500">${esc('No layout template')}</div>`;
                    }
                    const t = def.templates;
                    const sub = data.subtitle && t.subtitle_section_when
                        ? applyTpl(t.subtitle_section_when, { SUBTITLE: esc(data.subtitle) })
                        : '';
                    const desc = data.description && t.description_section_when
                        ? applyTpl(t.description_section_when, { DESCRIPTION: esc(data.description) })
                        : '';
                    let linksSection = '';
                    if (data.links?.length && t.link_row) {
                        const rows = data.links.map((l) => applyTpl(t.link_row, {
                            LINK_URL: esc(l.url || '#'),
                            LINK_LABEL: esc(l.label || 'Link'),
                        })).join('');
                        linksSection = t.links_wrapper_when
                            ? applyTpl(t.links_wrapper_when, { LINK_ROWS: rows })
                            : rows;
                    }
                    const secMain = (data.main_image_url || '').trim();
                    let sectionMainImageMarkup = '<div class="absolute inset-0 bg-gradient-to-br from-slate-700 via-slate-600 to-slate-800" aria-hidden="true"></div>';
                    if (secMain) {
                        sectionMainImageMarkup = `<img src="${escUrl(secMain)}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy" decoding="async" />`;
                    }
                    const allItems = data.items || [];
                    const isTestimonialType = (it) => String(it.type || '').toLowerCase() === 'testimonial';
                    const listItems = t.testimonial_item
                        ? allItems.filter((it) => ! isTestimonialType(it))
                        : allItems;
                    const firstTestimonialItem = t.testimonial_item
                        ? allItems.find((it) => isTestimonialType(it))
                        : null;

                    const renderItemMarkup = (it, itemIndex, itemsSource) => {
                        const iconText = it.icon ? String(it.icon).trim().slice(0, 2) : '•';
                        const rawIcon = it.icon ? String(it.icon).trim() : '';
                        const isLikelyImgUrl = /^https?:\/\//i.test(rawIcon) || rawIcon.startsWith('/');
                        const titleEsc = esc(it.title || '');
                        const itemMain = (it.main_image_url || '').trim();
			let itemImageMarkup = '<div class="absolute inset-0 bg-gradient-to-br from-slate-700 via-slate-600 to-slate-800" aria-hidden="true"></div>';
                        if (itemMain) {
                            itemImageMarkup = `<img src="${escUrl(itemMain)}" alt="${titleEsc}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-125 group-hover:brightness-110" loading="lazy" decoding="async" />`;
                        } else if (isLikelyImgUrl && rawIcon) {
                            itemImageMarkup = `<img src="${esc(rawIcon)}" alt="${titleEsc}" class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-125 group-hover:brightness-110" loading="lazy" decoding="async" />`;
                        }
                        const initial = titleEsc ? titleEsc.charAt(0) : '?';
                        let itemAvatarMarkup;
                        if (itemMain) {
                            itemAvatarMarkup = `<div class="relative h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-cyan-400"><img src="${escUrl(itemMain)}" alt="${titleEsc}" class="h-full w-full object-cover" loading="lazy" decoding="async" /></div>`;
                        } else if (isLikelyImgUrl && rawIcon) {
                            itemAvatarMarkup = `<div class="relative h-12 w-12 shrink-0 overflow-hidden rounded-full border-2 border-cyan-400"><img src="${esc(rawIcon)}" alt="${titleEsc}" class="h-full w-full object-cover" loading="lazy" decoding="async" /></div>`;
                        } else {
                            itemAvatarMarkup = `<div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-indigo-500"><span class="text-sm font-bold text-white">${initial}</span></div>`;
                        }
                        const calmBlueT2 = layoutKey === 'testimonials_section_style_2';
                        const caseStudyS1 = layoutKey === 'case_study_section_style_1';
                        const testimonialItemCount = itemsSource.length;
                        let itemAvatarForTpl = itemAvatarMarkup;
                        let itemCardSkin = '';
                        if (caseStudyS1 && itemIndex % 2 === 1) {
                            itemCardSkin = 'md:[&>.case-study-image]:order-2 md:[&>.case-study-content]:order-1';
                        }
                        if (calmBlueT2) {
                            if (testimonialItemCount === 3) {
                                if (itemIndex === 1) {
                                    itemCardSkin = 'border-blue-500/30 bg-gradient-to-br from-[#04140e] to-[#000501] opacity-70 transition duration-300 hover:opacity-100 rounded-[30px]';
                                    const twoInitials = titleEsc.length >= 2 ? titleEsc.slice(0, 2) : initial;
                                    if (itemMain) {
                                        itemAvatarForTpl = `<div class="relative h-10 w-10 shrink-0 overflow-hidden rounded-full border border-cyan-400/50 bg-cyan-400/20"><img src="${escUrl(itemMain)}" alt="${titleEsc}" class="h-full w-full object-cover" loading="lazy" decoding="async" /></div>`;
                                    } else if (isLikelyImgUrl && rawIcon) {
                                        itemAvatarForTpl = `<div class="relative h-10 w-10 shrink-0 overflow-hidden rounded-full border border-cyan-400/50 bg-cyan-400/20"><img src="${esc(rawIcon)}" alt="${titleEsc}" class="h-full w-full object-cover" loading="lazy" decoding="async" /></div>`;
                                    } else {
                                        itemAvatarForTpl = `<div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-cyan-400/50 bg-cyan-400/20"><span class="text-xs font-bold text-cyan-400">${twoInitials}</span></div>`;
                                    }
                                } else {
                                    itemCardSkin = 'border-blue-500/30 bg-gradient-to-br from-[#1A1D4D] to-[#16172d] rounded-lg';
                                    itemAvatarForTpl = '';
                                }
                            } else {
                                itemCardSkin = 'border-blue-500/30 bg-gradient-to-br from-[#1A1D4D] to-[#16172d] rounded-lg';
                            }
                        }
                        const isub = it.sub_title && t.item_subtitle_section_when
                            ? applyTpl(t.item_subtitle_section_when, { ITEM_SUBTITLE: esc(it.sub_title) })
                            : '';
                        const icont = it.content && t.item_content_section_when
                            ? applyTpl(t.item_content_section_when, { ITEM_CONTENT: t.item_content_raw ? it.content : esc(it.content) })
                            : '';
                        let itemLinksSection = '';
                        const itemLinks = it.links || [];
                        const cardHrefRaw = itemLinks[0]?.url;
                        const itemCardHref = esc(
                            cardHrefRaw && String(cardHrefRaw).trim()
                                ? String(cardHrefRaw).trim()
                                : '#',
                        );
                        if (itemLinks.length && t.item_link_row) {
                            const rows = itemLinks.map((l) => applyTpl(t.item_link_row, {
                                LINK_URL: esc(l.url || '#'),
                                LINK_LABEL: esc(l.label || 'Link'),
                            })).join('');
                            itemLinksSection = t.item_links_wrapper_when
                                ? applyTpl(t.item_links_wrapper_when, { ITEM_LINK_ROWS: rows })
                                : rows;
                        }

                        const contactFormS1 = layoutKey === 'contact_form_section_style_1';
                        const itemIconMarkup = contactFormS1
                            ? contactFormItemIconMarkup(rawIcon, itemIndex)
                            : esc(iconText);

                        return applyTpl(t.item, {
                            ITEM_TITLE: esc(it.title),
                            ITEM_SUBTITLE_SECTION: isub,
                            ITEM_CONTENT_SECTION: icont,
                            ITEM_ICON_DISPLAY: esc(iconText),
                            ITEM_ICON_MARKUP: itemIconMarkup,
                            ITEM_LINKS_SECTION: itemLinksSection,
                            ITEM_CARD_HREF: itemCardHref,
                            ITEM_IMAGE_MARKUP: itemImageMarkup,
                            ITEM_AVATAR_MARKUP: itemAvatarForTpl,
                            ITEM_COUNT: itemIndex + 1,
                            ITEM_CARD_SKIN: itemCardSkin,
                        });
                    };

                    const items = listItems.map((it, idx) => renderItemMarkup(it, idx, listItems)).join('');

                    let testimonialItemSection = '';
                    if (t.testimonial_item && firstTestimonialItem) {
                        const it = firstTestimonialItem;
                        const tSub = it.sub_title && t.testimonial_item_subtitle_section_when
                            ? applyTpl(t.testimonial_item_subtitle_section_when, { ITEM_SUBTITLE: esc(it.sub_title) })
                            : '';
                        const tCont = it.content && t.testimonial_item_content_section_when
                            ? applyTpl(t.testimonial_item_content_section_when, {
                                ITEM_CONTENT: t.testimonial_item_content_raw ? it.content : esc(it.content),
                            })
                            : '';
                        testimonialItemSection = applyTpl(t.testimonial_item, {
                            ITEM_TITLE: esc(it.title),
                            ITEM_SUBTITLE_SECTION: tSub,
                            ITEM_CONTENT_SECTION: tCont,
                        });
                    }

                    return applyTpl(t.body, {
                        TITLE: esc(data.title),
                        SUBTITLE_SECTION: sub,
                        DESCRIPTION_SECTION: desc,
                        LINKS_SECTION: linksSection,
                        ITEMS: items,
                        TESTIMONIAL_ITEM_SECTION: testimonialItemSection,
                        SECTION_MAIN_IMAGE_MARKUP: sectionMainImageMarkup,
                    });
                };

                const syncLayoutPreviewThumb = (sectionRoot) => {
                    const sel = sectionRoot.querySelector('[data-cms-section-layout]');
                    const layout = sel?.value || LAYOUT_FALLBACK || 'hero_section_style_1';
                    const meta = layoutDefinition(layout) || {};
                    const fig = sectionRoot.querySelector('[data-cms-layout-preview-figure]');
                    const img = sectionRoot.querySelector('[data-cms-layout-preview-image]');
                    const cap = sectionRoot.querySelector('[data-cms-layout-preview-caption]');
                    if (! img || ! fig) {
                        return;
                    }
                    if (meta.preview_image) {
                        img.src = meta.preview_image;
                        img.alt = meta.preview_caption || '';
                        img.removeAttribute('hidden');
                        fig.removeAttribute('hidden');
                        if (cap) {
                            cap.textContent = meta.preview_caption || '';
                            cap.removeAttribute('hidden');
                        }
                    } else {
                        img.removeAttribute('src');
                        img.setAttribute('hidden', 'hidden');
                        fig.setAttribute('hidden', 'hidden');
                        if (cap) {
                            cap.textContent = '';
                            cap.setAttribute('hidden', 'hidden');
                        }
                    }
                };

                /**
                 * Active locale for a tab group = panel without Tailwind `hidden` (matches setActive in locale scripts).
                 */
                const panelIsVisible = (panel) => {
                    if (panel.classList.contains('hidden')) {
                        return false;
                    }
                    if (panel.hidden) {
                        return false;
                    }
                    try {
                        return window.getComputedStyle(panel).display !== 'none';
                    } catch (e) {
                        return true;
                    }
                };

                const visibleLocaleForTabGroup = (editor, groupId, fallbackLocale) => {
                    const panels = editor.querySelectorAll(`.cms-locale-panel[data-tab-group="${groupId}"]`);
                    for (const panel of panels) {
                        if (panelIsVisible(panel)) {
                            return panel.getAttribute('data-tab-panel') || fallbackLocale;
                        }
                    }

                    return fallbackLocale;
                };

                /**
                 * Preview follows the section's visible translation tab (EN/AR), not a fixed locale.
                 */
                const resolvePreviewLocale = (sectionRoot) => {
                    const editor = sectionRoot.querySelector('[data-cms-section-editor]');
                    if (! editor) {
                        return 'en';
                    }
                    const si = sectionRoot.getAttribute('data-section-index');
                    if (si === null || si === '') {
                        return 'en';
                    }
                    const groupId = `cms-builder-section-translations-${si}`;
                    const locale = visibleLocaleForTabGroup(editor, groupId, sectionRoot.dataset.previewLocale || 'en');

                    return locale || 'en';
                };

                const resolveItemPreviewLocale = (sectionRoot, si, ii) => {
                    const editor = sectionRoot.querySelector('[data-cms-section-editor]');
                    if (! editor) {
                        return resolvePreviewLocale(sectionRoot);
                    }
                    const groupId = `cms-builder-item-translations-${si}-${ii}`;

                    return visibleLocaleForTabGroup(editor, groupId, resolvePreviewLocale(sectionRoot));
                };

                const resolveSectionLinkPreviewLocale = (sectionRoot, si, li) => {
                    const editor = sectionRoot.querySelector('[data-cms-section-editor]');
                    if (! editor) {
                        return resolvePreviewLocale(sectionRoot);
                    }
                    const groupId = `cms-builder-section-${si}-link-${li}`;

                    return visibleLocaleForTabGroup(editor, groupId, resolvePreviewLocale(sectionRoot));
                };

                const resolveItemLinkPreviewLocale = (sectionRoot, si, ii, ili) => {
                    const editor = sectionRoot.querySelector('[data-cms-section-editor]');
                    if (! editor) {
                        return resolvePreviewLocale(sectionRoot);
                    }
                    const groupId = `cms-builder-item-${si}-${ii}-link-${ili}`;

                    return visibleLocaleForTabGroup(editor, groupId, resolveItemPreviewLocale(sectionRoot, si, ii));
                };

                const readField = (sectionRoot, si, parts) => {
                    let name = `sections[${si}]`;
                    for (const p of parts) {
                        name += `[${p}]`;
                    }
                    for (const el of sectionRoot.querySelectorAll('input, textarea, select')) {
                        if (el.name === name) {
                            return el.value;
                        }
                    }

                    return '';
                };

                const sectionMainMediaUrl = (sectionRoot) => {
                    const persisted = (sectionRoot.getAttribute('data-main-media-url') || '').trim();
                    /** Section main file lives before item blocks; skip item-scoped main inputs. */
                    for (const inp of sectionRoot.querySelectorAll('input[type="file"][data-main-media-input]')) {
                        if (inp.closest('[data-cms-item-index]')) {
                            continue;
                        }
                        if (inp.files?.[0]) {
                            return URL.createObjectURL(inp.files[0]);
                        }
                    }

                    return persisted;
                };

                const itemMainMediaUrl = (sectionRoot, ii) => {
                    const itemEl = sectionRoot.querySelector(`[data-cms-item-index="${ii}"]`);
                    const persisted = (itemEl?.getAttribute('data-main-media-url') || '').trim();
                    const inp = itemEl?.querySelector('input[type="file"][data-main-media-input]');
                    if (inp?.files?.[0]) {
                        return URL.createObjectURL(inp.files[0]);
                    }

                    return persisted;
                };

                const collectItemLinks = (sectionRoot, si, ii) => {
                    const nameRe = new RegExp(
                        `^sections\\[${si}\\]\\[items\\]\\[${ii}\\]\\[links\\]\\[(\\d+)\\]\\[translations\\]\\[(.+?)\\]\\[name\\]$`,
                    );
                    const linkIndices = new Set();
                    sectionRoot.querySelectorAll('input, textarea, select').forEach((el) => {
                        const m = el.name.match(nameRe);
                        if (m) {
                            linkIndices.add(m[1]);
                        }
                    });
                    const out = [];
                    Array.from(linkIndices)
                        .sort((a, b) => Number(a) - Number(b))
                        .forEach((ili) => {
                            const locale = resolveItemLinkPreviewLocale(sectionRoot, si, ii, ili);
                            const label = readField(sectionRoot, si, [
                                'items', ii, 'links', ili, 'translations', locale, 'name',
                            ]);
                            const url = readField(sectionRoot, si, ['items', ii, 'links', ili, 'link']);
                            if (label || url) {
                                out.push({ label, url });
                            }
                        });

                    return out;
                };

                const collectItems = (sectionRoot, si) => {
                    const prefixRe = new RegExp(`^sections\\[${si}\\]\\[items\\]\\[(\\d+)\\]`);
                    const indices = new Set();
                    sectionRoot.querySelectorAll('input, textarea, select').forEach((el) => {
                        const m = el.name.match(prefixRe);
                        if (m) {
                            indices.add(m[1]);
                        }
                    });

                    return Array.from(indices)
                        .sort((a, b) => Number(a) - Number(b))
                        .map((ii) => {
                            const locale = resolveItemPreviewLocale(sectionRoot, si, ii);

                            return {
                                type: readField(sectionRoot, si, ['items', ii, 'type']) || 'default',
                                title: readField(sectionRoot, si, ['items', ii, 'translations', locale, 'title']),
                                sub_title: readField(sectionRoot, si, ['items', ii, 'translations', locale, 'sub_title']),
                                content: readField(sectionRoot, si, ['items', ii, 'translations', locale, 'content']),
                                icon: readField(sectionRoot, si, ['items', ii, 'translations', locale, 'icon']),
                                main_image_url: itemMainMediaUrl(sectionRoot, ii),
                                links: collectItemLinks(sectionRoot, si, ii),
                            };
                        });
                };

                const collectSectionLinks = (sectionRoot, si) => {
                    const nameRe = new RegExp(
                        `^sections\\[${si}\\]\\[links\\]\\[(\\d+)\\]\\[translations\\]\\[(.+?)\\]\\[name\\]$`,
                    );
                    const linkIndices = new Set();
                    sectionRoot.querySelectorAll('input, textarea, select').forEach((el) => {
                        const m = el.name.match(nameRe);
                        if (m) {
                            linkIndices.add(m[1]);
                        }
                    });
                    const out = [];
                    Array.from(linkIndices)
                        .sort((a, b) => Number(a) - Number(b))
                        .forEach((li) => {
                            const locale = resolveSectionLinkPreviewLocale(sectionRoot, si, li);
                            const label = readField(sectionRoot, si, [
                                'links', li, 'translations', locale, 'name',
                            ]);
                            const url = readField(sectionRoot, si, ['links', li, 'link']);
                            if (label || url) {
                                out.push({ label, url });
                            }
                        });

                    return out;
                };

                const refreshSectionPreview = (sectionRoot) => {
                    // Live HTML preview disabled — update layout reference image only.
                    syncLayoutPreviewThumb(sectionRoot);

                    /*
                    Restore live preview when re-enabling data-cms-section-preview in the aside:
                    const preview = sectionRoot.querySelector('[data-cms-section-preview]');
                    if (! preview) {
                        return;
                    }
                    const si = sectionRoot.getAttribute('data-section-index');
                    if (si === null || si === '') {
                        return;
                    }
                    const locale = resolvePreviewLocale(sectionRoot);
                    const sel = sectionRoot.querySelector('[data-cms-section-layout]');
                    const layout = sel?.value || LAYOUT_FALLBACK || 'hero_section_style_1';
                    const payload = {
                        title: readField(sectionRoot, si, ['translations', locale, 'title']),
                        subtitle: readField(sectionRoot, si, ['translations', locale, 'subtitle']),
                        description: readField(sectionRoot, si, ['translations', locale, 'description']),
                        main_image_url: sectionMainMediaUrl(sectionRoot),
                        items: collectItems(sectionRoot, si),
                        links: collectSectionLinks(sectionRoot, si),
                    };
                    preview.innerHTML = renderFromConfig(layout, payload);
                    syncLayoutPreviewThumb(sectionRoot);
                    */
                };

                const debouncePreview = (sectionRoot) => {
                    clearTimeout(sectionRoot._cmsPvTimer);
                    sectionRoot._cmsPvTimer = setTimeout(() => refreshSectionPreview(sectionRoot), 70);
                };

                const bindLayoutSelect = (sectionRoot) => {
                    const sel = sectionRoot.querySelector('[data-cms-section-layout]');
                    const desc = sectionRoot.querySelector('.cms-section-layout-description');
                    if (! sel || ! desc) {
                        return;
                    }
                    if (sel.dataset.cmsLayoutListener === '1') {
                        return;
                    }
                    sel.dataset.cmsLayoutListener = '1';
                    const sync = () => {
                        const opt = sel.options[sel.selectedIndex];
                        desc.textContent = opt?.dataset?.description || '';
                    };
                    sel.addEventListener('change', () => {
                        sync();
                        debouncePreview(sectionRoot);
                    });
                    sync();
                };

                const bindSection = (sectionRoot) => {
                    bindLayoutSelect(sectionRoot);
                    refreshSectionPreview(sectionRoot);
                };

                document.addEventListener('submit', (event) => {
                    const form = event.target?.closest?.('[data-cms-contact-form]');
                    if (form && form.closest('[data-cms-section-preview]')) {
                        event.preventDefault();
                    }
                }, true);

                /**
                 * Listen on document — Vue app.mount('#app') replaces/patches DOM under #app, so listeners
                 * attached to #cms-sections-root are dropped while document listeners survive.
                 */
                const wireSectionPreviewDelegation = () => {
                    if (window.__cmsBuilderPreviewDocDelegation) {
                        return;
                    }
                    window.__cmsBuilderPreviewDocDelegation = true;

                    const sectionsRoot = () => document.getElementById('cms-sections-root');

                    const bubble = (e) => {
                        const root = sectionsRoot();
                        const t = e.target;
                        if (! t || ! root) {
                            return;
                        }
                        const section = typeof t.closest === 'function' ? t.closest('[data-cms-section]') : null;
                        if (section && root.contains(section)) {
                            debouncePreview(section);
                        }
                    };

                    document.addEventListener('input', bubble, true);
                    document.addEventListener('change', bubble, true);
                    document.addEventListener('input', bubble, false);
                    document.addEventListener('change', bubble, false);

                    document.addEventListener('click', (e) => {
                        const root = sectionsRoot();
                        const tab = e.target?.closest?.('.cms-locale-tab');
                        if (! tab || ! root?.contains(tab)) {
                            return;
                        }
                        const section = tab.closest('[data-cms-section]');
                        if (section) {
                            requestAnimationFrame(() => refreshSectionPreview(section));
                        }
                    });
                };

                const setActive = (group, tab) => {
                    document.querySelectorAll(`.cms-locale-tab[data-tab-group="${group}"]`).forEach((btnEl) => {
                        const isActive = btnEl.getAttribute('data-tab') === tab;
                        btnEl.classList.toggle('bg-gray-100', isActive);
                        btnEl.classList.toggle('dark:bg-gray-950', isActive);
                        btnEl.classList.toggle('text-gray-900', isActive);
                        btnEl.classList.toggle('dark:text-white', isActive);
                    });

                    document.querySelectorAll(`.cms-locale-panel[data-tab-group="${group}"]`).forEach((panel) => {
                        panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== tab);
                    });
                };

                const initGroup = (group) => {
                    const first = document.querySelector(`.cms-locale-tab[data-tab-group="${group}"]`);
                    if (first) {
                        setActive(group, first.getAttribute('data-tab'));
                    }
                };

                const initAllLocaleTabGroups = () => {
                    const seen = new Set();
                    document.querySelectorAll('.cms-locale-tab[data-tab-group]').forEach((btnEl) => {
                        const g = btnEl.getAttribute('data-tab-group');
                        if (g && ! seen.has(g)) {
                            seen.add(g);
                            initGroup(g);
                        }
                    });
                };

                const CMS_BUILDER_REMOVE = {
                    section: @json(__('cms::app.pages.builder.confirm-remove-section')),
                    item: @json(__('cms::app.pages.builder.confirm-remove-item')),
                    link: @json(__('cms::app.pages.builder.confirm-remove-link')),
                };
                const CMS_BUILDER_LABELS = {
                    section: @json(__('cms::app.pages.builder.section')),
                    items: @json(__('cms::app.menu.items')),
                };

                const syncUidInScope = (scope, newUid) => {
                    const inp = scope.querySelector('[data-main-media-input]');
                    if (! inp) {
                        return;
                    }
                    const oldUid = inp.getAttribute('data-main-media-input');
                    if (! oldUid || oldUid === newUid) {
                        return;
                    }
                    scope.querySelectorAll('*').forEach((node) => {
                        [...node.attributes].forEach((attr) => {
                            if (attr.value.includes(oldUid)) {
                                attr.value = attr.value.split(oldUid).join(newUid);
                            }
                        });
                    });
                };

                const reindexPageLinks = () => {
                    const wrap = document.querySelector('[data-cms-page-links]');
                    if (! wrap) {
                        return;
                    }
                    Array.from(wrap.children).forEach((block, pi) => {
                        if (! block.matches?.('[data-cms-builder-link]')) {
                            return;
                        }
                        block.querySelectorAll('[name]').forEach((el) => {
                            if (el.name) {
                                el.name = el.name.replace(/^page_links\[\d+\]/, `page_links[${pi}]`);
                            }
                        });
                        block.querySelectorAll('[data-tab-group]').forEach((el) => {
                            el.setAttribute('data-tab-group', `cms-builder-page-link-${pi}`);
                        });
                    });
                };

                const reindexSectionsInForm = () => {
                    const sectionsRoot = document.getElementById('cms-sections-root');
                    if (! sectionsRoot) {
                        return;
                    }
                    sectionsRoot.querySelectorAll(':scope > [data-cms-section]').forEach((sec, si) => {
                        sec.setAttribute('data-section-index', String(si));
                        sec.querySelectorAll('[name]').forEach((el) => {
                            if (el.name) {
                                el.name = el.name.replace(/^sections\[\d+\]/, `sections[${si}]`);
                            }
                        });
                        const heading = sec.querySelector('[data-cms-section-heading]');
                        if (heading) {
                            heading.textContent = `${CMS_BUILDER_LABELS.section} #${si + 1}`;
                        }
                        const secMain = sec.querySelector('[data-cms-section-main-media]');
                        if (secMain) {
                            syncUidInScope(secMain, `cms-builder-section-${si}-media`);
                        }
                        sec.querySelectorAll('[data-tab-group]').forEach((el) => {
                            const g = el.getAttribute('data-tab-group');
                            if (g && /^cms-builder-section-translations-\d+$/.test(g)) {
                                el.setAttribute('data-tab-group', `cms-builder-section-translations-${si}`);
                            }
                        });
                        const items = sec.querySelectorAll('[data-cms-section-editor] details.cms-builder-details--item');
                        items.forEach((itemEl, ii) => {
                            itemEl.setAttribute('data-cms-item-index', String(ii));
                            itemEl.querySelectorAll('[name]').forEach((el) => {
                                if (el.name) {
                                    el.name = el.name.replace(
                                        new RegExp(`^sections\\[${si}\\]\\[items\\]\\[\\d+\\]`),
                                        `sections[${si}][items][${ii}]`,
                                    );
                                }
                            });
                            const ih = itemEl.querySelector('[data-cms-item-heading]');
                            if (ih) {
                                ih.textContent = `${CMS_BUILDER_LABELS.items} #${ii + 1}`;
                            }
                            const imwrap = itemEl.querySelector('[data-cms-item-main-media]');
                            if (imwrap) {
                                syncUidInScope(imwrap, `cms-builder-item-${si}-${ii}-media`);
                            }
                            const ilinks = itemEl.querySelector('[data-cms-item-links]');
                            if (ilinks) {
                                Array.from(ilinks.children).forEach((lb, ili) => {
                                    if (! lb.matches?.('[data-cms-builder-link]')) {
                                        return;
                                    }
                                    lb.querySelectorAll('[name]').forEach((el) => {
                                        if (el.name) {
                                            el.name = el.name.replace(
                                                new RegExp(`^sections\\[${si}\\]\\[items\\]\\[${ii}\\]\\[links\\]\\[\\d+\\]`),
                                                `sections[${si}][items][${ii}][links][${ili}]`,
                                            );
                                        }
                                    });
                                    lb.querySelectorAll('[data-tab-group]').forEach((el) => {
                                        el.setAttribute('data-tab-group', `cms-builder-item-${si}-${ii}-link-${ili}`);
                                    });
                                });
                            }
                        });
                        const slinks = sec.querySelector('[data-cms-section-links]');
                        if (slinks) {
                            Array.from(slinks.children).forEach((lb, li) => {
                                if (! lb.matches?.('[data-cms-builder-link]')) {
                                    return;
                                }
                                lb.querySelectorAll('[name]').forEach((el) => {
                                    if (el.name) {
                                        el.name = el.name.replace(
                                            new RegExp(`^sections\\[${si}\\]\\[links\\]\\[\\d+\\]`),
                                            `sections[${si}][links][${li}]`,
                                        );
                                    }
                                });
                                lb.querySelectorAll('[data-tab-group]').forEach((el) => {
                                    el.setAttribute('data-tab-group', `cms-builder-section-${si}-link-${li}`);
                                });
                            });
                        }
                    });
                };

                wireSectionPreviewDelegation();

                const zoomModalEl = () => document.getElementById('cms-layout-image-zoom-modal');
                const guideModalEl = () => document.getElementById('cms-layout-guide-modal');

                const openBuilderModal = (modal) => {
                    if (! modal) {
                        return;
                    }
                    modal.removeAttribute('hidden');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.classList.add('cms-builder-modal-open');
                };

                const closeBuilderModal = (modal) => {
                    if (! modal) {
                        return;
                    }
                    modal.setAttribute('hidden', 'hidden');
                    modal.setAttribute('aria-hidden', 'true');
                    if (! document.querySelector('.cms-builder-modal:not([hidden])')) {
                        document.body.classList.remove('cms-builder-modal-open');
                    }
                };

                const closeAllBuilderModals = () => {
                    document.querySelectorAll('.cms-builder-modal').forEach((modal) => closeBuilderModal(modal));
                };

                const openLayoutZoomModal = (src, caption) => {
                    const modal = zoomModalEl();
                    const img = modal?.querySelector('[data-cms-zoom-modal-image]');
                    const cap = modal?.querySelector('[data-cms-zoom-modal-caption]');
                    if (! modal || ! img || ! src) {
                        return;
                    }
                    img.src = src;
                    img.alt = caption || '';
                    if (cap) {
                        cap.textContent = caption || '';
                    }
                    openBuilderModal(modal);
                };

                const buildLayoutGuideGrid = () => {
                    const grid = document.querySelector('[data-cms-layout-guide-grid]');
                    if (! grid || grid.dataset.built === '1') {
                        return;
                    }
                    grid.dataset.built = '1';
                    grid.innerHTML = SECTION_LAYOUT_GUIDE.map((entry) => {
                        const label = esc(entry.label || entry.key || '');
                        const description = esc(entry.description || '');
                        const caption = escAttr(entry.preview_caption || entry.description || entry.label || '');
                        const thumb = entry.preview_image
                            ? `<img src="${escAttr(entry.preview_image)}" alt="${label}" loading="lazy" decoding="async" data-cms-guide-layout-thumb data-caption="${caption}" />`
                            : `<div class="flex min-h-[120px] items-center justify-center rounded-md border border-dashed border-gray-300 bg-white px-3 text-center text-xs text-gray-500 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-400">${esc(CMS_MODAL_LABELS.noPreview)}</div>`;

                        return `<article class="cms-layout-guide-card">
                            ${thumb}
                            <div>
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">${label}</p>
                                ${description ? `<p class="mt-1 text-xs text-gray-500 dark:text-gray-400">${description}</p>` : ''}
                            </div>
                        </article>`;
                    }).join('');
                };

                const wireBuilderModals = () => {
                    if (window.__cmsBuilderModalsWired) {
                        return;
                    }
                    window.__cmsBuilderModalsWired = true;

                    buildLayoutGuideGrid();

                    document.addEventListener('click', (e) => {
                        const guideBtn = e.target?.closest?.('[data-cms-open-layout-guide]');
                        if (guideBtn) {
                            e.preventDefault();
                            e.stopPropagation();
                            buildLayoutGuideGrid();
                            openBuilderModal(guideModalEl());

                            return;
                        }

                        const previewImg = e.target?.closest?.('[data-cms-layout-preview-image]');
                        if (previewImg && previewImg.src && ! previewImg.hasAttribute('hidden')) {
                            e.preventDefault();
                            const caption = previewImg.alt
                                || previewImg.closest('figure')?.querySelector('[data-cms-layout-preview-caption]')?.textContent
                                || '';
                            openLayoutZoomModal(previewImg.src, caption);

                            return;
                        }

                        const guideThumb = e.target?.closest?.('[data-cms-guide-layout-thumb]');
                        if (guideThumb?.src) {
                            e.preventDefault();
                            e.stopPropagation();
                            openLayoutZoomModal(
                                guideThumb.src,
                                guideThumb.getAttribute('data-caption') || guideThumb.alt || '',
                            );

                            return;
                        }

                        const closeTarget = e.target?.closest?.('[data-cms-close-modal]');
                        if (closeTarget) {
                            const modal = closeTarget.closest('.cms-builder-modal');
                            if (modal) {
                                e.preventDefault();
                                closeBuilderModal(modal);
                            }
                        }
                    }, true);

                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape') {
                            closeAllBuilderModals();
                        }
                    });
                };

                wireBuilderModals();

                const bindAllSections = () => {
                    document.querySelectorAll('#cms-sections-root [data-cms-section]').forEach((el) => bindSection(el));
                };

                const syncNextSectionIndexFromDom = () => {
                    const r = document.getElementById('cms-sections-root');
                    si = r ? r.querySelectorAll(':scope > [data-cms-section]').length : 0;
                };

                const wireBuilderRemovals = () => {
                    if (window.__cmsBuilderRemovalsWired) {
                        return;
                    }
                    window.__cmsBuilderRemovalsWired = true;
                    document.addEventListener('click', (e) => {
                        const secBtn = e.target?.closest?.('[data-cms-remove-section]');
                        if (secBtn) {
                            e.preventDefault();
                            e.stopPropagation();
                            if (! window.confirm(CMS_BUILDER_REMOVE.section)) {
                                return;
                            }
                            secBtn.closest('[data-cms-section]')?.remove();
                            syncNextSectionIndexFromDom();
                            reindexSectionsInForm();
                            initAllLocaleTabGroups();
                            bindAllSections();

                            return;
                        }
                        const itemBtn = e.target?.closest?.('[data-cms-remove-item]');
                        if (itemBtn) {
                            e.preventDefault();
                            e.stopPropagation();
                            if (! window.confirm(CMS_BUILDER_REMOVE.item)) {
                                return;
                            }
                            const itemEl = itemBtn.closest('details.cms-builder-details--item')
                                || itemBtn.closest('[data-cms-item-index]')?.closest('details');
                            itemEl?.remove();
                            reindexSectionsInForm();
                            initAllLocaleTabGroups();
                            bindAllSections();

                            return;
                        }
                        const linkBtn = e.target?.closest?.('[data-cms-remove-link]');
                        if (linkBtn) {
                            e.preventDefault();
                            e.stopPropagation();
                            if (! window.confirm(CMS_BUILDER_REMOVE.link)) {
                                return;
                            }
                            const block = linkBtn.closest('[data-cms-builder-link]');
                            const pageWrap = block?.closest('[data-cms-page-links]');
                            block?.remove();
                            if (pageWrap) {
                                reindexPageLinks();
                            } else {
                                reindexSectionsInForm();
                            }
                            initAllLocaleTabGroups();
                            bindAllSections();
                        }
                    }, true);
                };

                let cmsBuilderLocaleTabsInitialized = false;

                const bootBuilderPreview = (opts = {}) => {
                    const skipLocale = opts.skipLocaleInit === true;
                    if (! skipLocale && ! cmsBuilderLocaleTabsInitialized) {
                        initAllLocaleTabGroups();
                        cmsBuilderLocaleTabsInitialized = true;
                    }
                    bindAllSections();
                };

                bootBuilderPreview();

                window.addEventListener('load', () => {
                    bootBuilderPreview();
                    setTimeout(() => bootBuilderPreview({ skipLocaleInit: true }), 0);
                    setTimeout(() => bootBuilderPreview({ skipLocaleInit: true }), 100);
                    setTimeout(() => bootBuilderPreview({ skipLocaleInit: true }), 500);
                });

                let si = {{ (int) $nextSectionIndex }};

                wireBuilderRemovals();

                /**
                 * Admin mounts Vue on #app after load, which replaces the DOM and drops listeners
                 * bound to the old #cms-add-section node. Delegate from document so add-section keeps working.
                 */
                const wireAddSectionDelegation = () => {
                    if (window.__cmsBuilderAddSectionWired) {
                        return;
                    }
                    window.__cmsBuilderAddSectionWired = true;

                    window.cmsBuilderAddSection = () => {
                        const tplEl = document.getElementById('cms-section-template');
                        const rootEl = document.getElementById('cms-sections-root');
                        if (! tplEl?.innerHTML || ! rootEl) {
                            return;
                        }
                        const html = tplEl.innerHTML.replaceAll('__SI__', String(si));
                        const wrap = document.createElement('div');
                        wrap.innerHTML = html.trim();
                        const node = wrap.firstElementChild;
                        if (node) {
                            rootEl.appendChild(node);
                            const h = node.querySelector('[data-cms-section-heading]');
                            if (h) {
                                h.textContent = `${CMS_BUILDER_LABELS.section} #${si + 1}`;
                            }
                            const firstTab = node.querySelector('.cms-locale-tab[data-tab-group]');
                            if (firstTab) {
                                initGroup(firstTab.getAttribute('data-tab-group'));
                            }
                            bindSection(node);
                        }
                        si += 1;
                    };

                    document.addEventListener('click', (e) => {
                        if (! e.target?.closest?.('#cms-add-section')) {
                            return;
                        }
                        e.preventDefault();
                        e.stopPropagation();
                        window.cmsBuilderAddSection();
                    }, true);
                };

                wireAddSectionDelegation();

                /**
                 * Shared helper: clone link template, replace placeholders, append to container, init tabs.
                 */
                const cloneLinkBlock = (container, namePrefix, oldPrefix, tabGroupId) => {
                    const tpl = document.getElementById('cms-link-template');
                    if (! tpl || ! container) {
                        return;
                    }
                    let html = tpl.innerHTML
                        .replaceAll('__LINK_PREFIX__', namePrefix)
                        .replaceAll('__LINK_OLD_PREFIX__', oldPrefix)
                        .replaceAll('__LINK_TAB_GROUP__', tabGroupId);
                    const wrap = document.createElement('div');
                    wrap.innerHTML = html.trim();
                    const node = wrap.firstElementChild;
                    if (node) {
                        container.appendChild(node);
                        const firstTab = node.querySelector('.cms-locale-tab[data-tab-group]');
                        if (firstTab) {
                            initGroup(firstTab.getAttribute('data-tab-group'));
                        }
                    }
                };

                /**
                 * Add link to page-level links.
                 */
                window.cmsBuilderAddPageLink = () => {
                    const container = document.querySelector('[data-cms-page-links]');
                    if (! container) {
                        return;
                    }
                    const idx = container.querySelectorAll('[data-cms-builder-link]').length;
                    cloneLinkBlock(
                        container,
                        `page_links[${idx}]`,
                        `page_links.${idx}`,
                        `cms-builder-page-link-${idx}`
                    );
                };

                /**
                 * Add link to a section.
                 */
                window.cmsBuilderAddSectionLink = (btn) => {
                    const sectionRoot = btn?.closest('[data-cms-section]');
                    if (! sectionRoot) {
                        return;
                    }
                    const si = sectionRoot.getAttribute('data-section-index');
                    const container = btn.closest('[data-cms-section-editor]')
                        ?.querySelector('[data-cms-section-links]')
                        || sectionRoot.querySelector('[data-cms-section-links]');
                    if (! container) {
                        return;
                    }
                    const idx = container.querySelectorAll('[data-cms-builder-link]').length;
                    cloneLinkBlock(
                        container,
                        `sections[${si}][links][${idx}]`,
                        `sections.${si}.links.${idx}`,
                        `cms-builder-section-${si}-link-${idx}`
                    );
                    debouncePreview(sectionRoot);
                };

                /**
                 * Add link to an item.
                 */
                window.cmsBuilderAddItemLink = (btn) => {
                    const sectionRoot = btn?.closest('[data-cms-section]');
                    const itemEl = btn?.closest('[data-cms-item-index]');
                    if (! sectionRoot || ! itemEl) {
                        return;
                    }
                    const si = sectionRoot.getAttribute('data-section-index');
                    const ii = itemEl.getAttribute('data-cms-item-index');
                    const container = itemEl.querySelector('[data-cms-item-links]');
                    if (! container) {
                        return;
                    }
                    const idx = container.querySelectorAll('[data-cms-builder-link]').length;
                    cloneLinkBlock(
                        container,
                        `sections[${si}][items][${ii}][links][${idx}]`,
                        `sections.${si}.items.${ii}.links.${idx}`,
                        `cms-builder-item-${si}-${ii}-link-${idx}`
                    );
                    debouncePreview(sectionRoot);
                };

                /**
                 * Add item to a section.
                 */
                window.cmsBuilderAddItem = (btn) => {
                    const sectionRoot = btn?.closest('[data-cms-section]');
                    if (! sectionRoot) {
                        return;
                    }
                    const si = sectionRoot.getAttribute('data-section-index');
                    const itemsContainer = btn.parentElement;
                    if (! itemsContainer) {
                        return;
                    }
                    const existingItems = itemsContainer.querySelectorAll('details.cms-builder-details--item');
                    const ii = existingItems.length;
                    const tpl = document.getElementById('cms-item-template');
                    if (! tpl) {
                        return;
                    }
                    let html = tpl.innerHTML
                        .replaceAll('__SI__', String(si))
                        .replaceAll('__II__', String(ii));
                    const wrap = document.createElement('div');
                    wrap.innerHTML = html.trim();
                    const node = wrap.firstElementChild;
                    if (node) {
                        btn.before(node);
                        const h = node.querySelector('[data-cms-item-heading]');
                        if (h) {
                            h.textContent = `${CMS_BUILDER_LABELS.items} #${ii + 1}`;
                        }
                        node.querySelectorAll('.cms-locale-tab[data-tab-group]').forEach((tabBtn) => {
                            const g = tabBtn.getAttribute('data-tab-group');
                            if (g) {
                                initGroup(g);
                            }
                        });
                        debouncePreview(sectionRoot);
                    }
                };
            })();
        </script>
    @endPushOnce
</x-admin::layouts>
