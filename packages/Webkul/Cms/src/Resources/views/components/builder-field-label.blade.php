@include('cms::components.builder-hint-styles')

@props([
    'label',
    'hint' => '',
    'for' => null,
    'required' => false,
    'inline' => false,
])

@if ($inline)
    <span {{ $attributes->merge(['class' => 'cms-builder-label cms-builder-label--inline inline-flex items-center gap-1']) }}>
        <span>{{ $label }}</span>
        @if ($hint)
            @include('cms::components.builder-hint', ['hint' => $hint])
        @endif
    </span>
@else
    <label
        @if ($for) for="{{ $for }}" @endif
        {{ $attributes->merge(['class' => 'cms-builder-label mb-1 flex items-center gap-1.5 text-xs font-medium text-gray-600 dark:text-gray-300']) }}
    >
        <span>
            {{ $label }}
            @if ($required)
                <span class="text-red-500" aria-hidden="true">*</span>
            @endif
        </span>
        @if ($hint)
            @include('cms::components.builder-hint', ['hint' => $hint])
        @endif
    </label>
@endif
