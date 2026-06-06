@php
    $si = $si ?? '__SI__';
    $ii = $ii ?? '__II__';
    $item = $item ?? null;
    $itemTabId = $itemTabId ?? 'cms-builder-item-translations-'.$si.'-'.$ii;
    $isTemplate = $ii === '__II__';
@endphp

<div class="cms-builder-field-group mt-3 rounded-lg border border-gray-100 bg-gray-50/80 p-3 dark:border-gray-800 dark:bg-gray-900/40">
    <p class="cms-builder-field-group__title">
        @lang('cms::app.pages.builder.groups.item_content')
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
        @php($it = $isTemplate ? null : $item?->translate($locale, false))
        <div
            class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
            data-tab-group="{{ $itemTabId }}"
            data-tab-panel="{{ $locale }}"
        >
            @include('cms::components.builder-field-label', [
                'label' => __('cms::app.items.form.title'),
                'hint' => __('cms::app.pages.builder.hints.item_title'),
                'required' => $locale === 'en',
            ])
            <input
                type="text"
                name="sections[{{ $si }}][items][{{ $ii }}][translations][{{ $locale }}][title]"
                value="{{ $isTemplate ? '' : old('sections.'.$si.'.items.'.$ii.'.translations.'.$locale.'.title', $it?->title) }}"
                class="mb-3 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
                @if ($locale === 'en') required @endif
            />
            @include('cms::components.builder-field-label', [
                'label' => __('cms::app.items.form.sub_title'),
                'hint' => __('cms::app.pages.builder.hints.item_subtitle'),
            ])
            <input
                type="text"
                name="sections[{{ $si }}][items][{{ $ii }}][translations][{{ $locale }}][sub_title]"
                value="{{ $isTemplate ? '' : old('sections.'.$si.'.items.'.$ii.'.translations.'.$locale.'.sub_title', $it?->sub_title) }}"
                class="mb-3 w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
            />
            @include('cms::components.builder-field-label', [
                'label' => __('cms::app.items.form.content'),
                'hint' => __('cms::app.pages.builder.hints.item_content'),
            ])
            @include('cms::components.builder-rich-textarea', [
                'id' => 'cms-builder-item-'.$si.'-'.$ii.'-'.$locale.'-content',
                'name' => 'sections['.$si.'][items]['.$ii.'][translations]['.$locale.'][content]',
                'value' => $isTemplate ? '' : old('sections.'.$si.'.items.'.$ii.'.translations.'.$locale.'.content', $it?->content),
                'extraClass' => 'mb-3',
            ])
            @include('cms::components.builder-field-label', [
                'label' => __('cms::app.items.form.icon'),
                'hint' => __('cms::app.pages.builder.hints.item_icon'),
            ])
            <input
                type="text"
                name="sections[{{ $si }}][items][{{ $ii }}][translations][{{ $locale }}][icon]"
                value="{{ $isTemplate ? '' : old('sections.'.$si.'.items.'.$ii.'.translations.'.$locale.'.icon', $it?->icon) }}"
                class="w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900"
            />
        </div>
    @endforeach
</div>
