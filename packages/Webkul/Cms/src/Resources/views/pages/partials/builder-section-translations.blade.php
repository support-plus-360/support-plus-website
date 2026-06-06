@php
    $si = $si ?? '__SI__';
    $section = $section ?? null;
    $sectionTabId = $sectionTabId ?? 'cms-builder-section-translations-'.$si;
    $isTemplate = $si === '__SI__';
@endphp

<div class="cms-builder-field-group mt-4 rounded-lg border border-gray-100 bg-gray-50/80 p-3 dark:border-gray-800 dark:bg-gray-900/40">
    <p class="cms-builder-field-group__title">
        @lang('cms::app.pages.builder.groups.section_content')
    </p>
    <p class="mb-3 text-xs text-gray-500 dark:text-gray-400">
        @lang('cms::app.pages.builder.groups.section_content_help')
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
        @php($st = $isTemplate ? null : $section?->translate($locale, false))
        <div
            class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
            data-tab-group="{{ $sectionTabId }}"
            data-tab-panel="{{ $locale }}"
        >
            @include('cms::components.builder-field-label', [
                'label' => __('cms::app.sections.form.title_en'),
                'hint' => __('cms::app.pages.builder.hints.section_title'),
                'required' => $locale === 'en',
            ])
            <input
                type="text"
                name="sections[{{ $si }}][translations][{{ $locale }}][title]"
                value="{{ $isTemplate ? '' : old('sections.'.$si.'.translations.'.$locale.'.title', $st?->title) }}"
                class="cms-section-preview-trigger mb-3 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
                @if ($locale === 'en') required @endif
            />
            @include('cms::components.builder-field-label', [
                'label' => __('cms::app.sections.form.subtitle_en'),
                'hint' => __('cms::app.pages.builder.hints.section_subtitle'),
            ])
            <input
                type="text"
                name="sections[{{ $si }}][translations][{{ $locale }}][subtitle]"
                value="{{ $isTemplate ? '' : old('sections.'.$si.'.translations.'.$locale.'.subtitle', $st?->subtitle) }}"
                class="cms-section-preview-trigger mb-3 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
            />
            @include('cms::components.builder-field-label', [
                'label' => __('cms::app.sections.form.description_en'),
                'hint' => __('cms::app.pages.builder.hints.section_description'),
            ])
            @include('cms::components.builder-rich-textarea', [
                'id' => 'cms-builder-section-'.$si.'-'.$locale.'-description',
                'name' => 'sections['.$si.'][translations]['.$locale.'][description]',
                'value' => $isTemplate ? '' : old('sections.'.$si.'.translations.'.$locale.'.description', $st?->description),
                'extraClass' => 'cms-section-preview-trigger',
            ])
        </div>
    @endforeach
</div>
