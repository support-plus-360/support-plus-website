@include('cms::components.builder-hint-styles')

@props(['hint'])

<span class="cms-builder-hint" tabindex="0" aria-label="{{ $hint }}">
    <i class="icon-info text-sm leading-none text-blue-500 dark:text-blue-400" aria-hidden="true"></i>
    <span class="cms-builder-hint__bubble" role="tooltip" aria-hidden="true">{{ $hint }}</span>
</span>
