@php
    $si = $si ?? '__SI__';
    $section = $section ?? null;
    $selectedLayout = $selectedLayout ?? $defaultSectionLayout ?? array_key_first($sectionLayouts ?? []);
    $isTemplate = $si === '__SI__';
@endphp

<div class="cms-builder-field-group rounded-lg border border-gray-100 bg-gray-50/80 p-3 dark:border-gray-800 dark:bg-gray-900/40">
    <p class="cms-builder-field-group__title">
        @lang('cms::app.pages.builder.groups.section_settings')
    </p>
    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        <div>
            @include('cms::components.builder-field-label', [
                'label' => __('cms::app.sections.form.name'),
                'hint' => __('cms::app.pages.builder.hints.section_name'),
                'required' => true,
            ])
            <input
                type="text"
                name="sections[{{ $si }}][name]"
                value="{{ $isTemplate ? '' : old('sections.'.$si.'.name', $section?->name) }}"
                class="cms-section-preview-trigger w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                required
            />
        </div>
        <div class="flex gap-2">
            <div>
                @include('cms::components.builder-field-label', [
                    'label' => __('cms::app.pages.form.order'),
                    'hint' => __('cms::app.pages.builder.hints.section_order'),
                ])
                <input
                    type="number"
                    name="sections[{{ $si }}][order]"
                    value="{{ $isTemplate ? 0 : old('sections.'.$si.'.order', $section?->order ?? 0) }}"
                    class="w-full rounded border border-gray-200 px-2 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-900"
                />
            </div>
            <div class="flex items-end pb-1">
                <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                    <input
                        type="checkbox"
                        name="sections[{{ $si }}][is_active]"
                        value="1"
                        class="h-4 w-4 rounded border-gray-300"
                        @checked($isTemplate ? true : old('sections.'.$si.'.is_active', $section?->is_active ?? true))
                    />
                    @include('cms::components.builder-field-label', [
                        'label' => __('cms::app.pages.form.active'),
                        'hint' => __('cms::app.pages.builder.hints.section_active'),
                        'inline' => true,
                    ])
                </label>
            </div>
        </div>    
        <div class="sm:col-span-2 lg:col-span-1">
            @include('cms::components.builder-field-label', [
                'label' => __('cms::app.pages.builder.layout-label'),
                'hint' => __('cms::app.pages.builder.hints.section_layout'),
                'required' => true,
            ])
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
                        @selected($selectedLayout === $layoutKey)
                    >
                        {{ $layoutMeta['label'] ?? $layoutKey }}
                    </option>
                @endforeach
            </select>
            <!-- <p class="cms-section-layout-description mt-1 text-xs text-gray-500 dark:text-gray-400">
                {{ $sectionLayouts[$selectedLayout]['description'] ?? '' }}
            </p> -->
        </div>
    </div>
</div>
