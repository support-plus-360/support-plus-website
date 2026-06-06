@props([
    'id',
    'name',
    'value' => '',
    'rows' => 8,
    'extraClass' => '',
])

<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    rows="{{ $rows }}"
    {{ $attributes->merge([
        'class' => 'cms-builder-rich-editor w-full rounded border border-gray-200 px-2 py-1 text-sm dark:border-gray-700 dark:bg-gray-900 '.$extraClass,
    ]) }}
>{!! $value !!}</textarea>
