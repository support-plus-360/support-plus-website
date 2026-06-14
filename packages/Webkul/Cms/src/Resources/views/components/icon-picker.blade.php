@props([
    'name' => 'icon',
    'id' => null,
    'value' => '',
    'uid' => 'cms-icon-picker-' . uniqid(),
    'label' => null,
    'errorControlName' => null,
])

@php
    $inputId = $id ?? $name;
    $iconValue = old($name, $value);
    $labelText = $label ?? __('cms::app.icon-picker.label');
    $errorName = $errorControlName ?? $name;
@endphp

<div class="flex flex-col gap-2" data-cms-icon-picker="{{ $uid }}">
    <x-admin::form.control-group class="!mb-0">
        <x-admin::form.control-group.label>
            {{ $labelText }}
        </x-admin::form.control-group.label>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <div class="flex min-w-0 flex-1 items-center gap-2">
                <input
                    type="text"
                    name="{{ $name }}"
                    id="{{ $inputId }}"
                    value="{{ $iconValue }}"
                    autocomplete="off"
                    placeholder="icon-setting"
                    data-cms-icon-picker-input="{{ $uid }}"
                    class="w-full min-w-0 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400"
                />
                <span
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800"
                    title="{{ $labelText }}"
                    aria-hidden="true"
                >
                    <i
                        data-cms-icon-picker-preview="{{ $uid }}"
                        class="@if($iconValue){{ $iconValue }}@endif text-2xl @if($iconValue) text-gray-800 dark:text-gray-200 @else text-gray-300 dark:text-gray-600 @endif"
                    ></i>
                </span>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <button
                    type="button"
                    class="secondary-button !py-1.5 text-sm"
                    data-cms-icon-picker-open="{{ $uid }}"
                    onclick="window.cmsIconPickerOpen && window.cmsIconPickerOpen('{{ $uid }}')"
                >
                    @lang('cms::app.icon-picker.choose')
                </button>
                <button
                    type="button"
                    class="rounded border border-gray-200 px-2.5 py-1.5 text-sm text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-950"
                    data-cms-icon-picker-clear="{{ $uid }}"
                    onclick="window.cmsIconPickerClear && window.cmsIconPickerClear('{{ $uid }}')"
                >
                    @lang('cms::app.icon-picker.clear')
                </button>
            </div>
        </div>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            @lang('cms::app.icon-picker.custom_hint')
        </p>
        <x-admin::form.control-group.error :control-name="$errorName" />
    </x-admin::form.control-group>
</div>
