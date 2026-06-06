@props([
    'locale',
    'value' => '',
])

@php
    $editorId = 'translations_'.$locale.'_content';
    $editorName = 'translations['.$locale.'][content]';
@endphp

<textarea
    id="{{ $editorId }}"
    name="{{ $editorName }}"
    rows="12"
    class="blog-post-content-editor w-full rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400 dark:focus:border-gray-400"
>{!! $value !!}</textarea>
