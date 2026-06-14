@props([
    'uid' => 'cms-icon-picker-' . uniqid(),
])

@php
    use Webkul\Cms\Support\IconPickerLibraries;

    $libraries = IconPickerLibraries::all();
    $firstLibraryKey = array_key_first($libraries);
@endphp

<div
    data-cms-icon-picker-modal="{{ $uid }}"
    class="cms-icon-picker-overlay"
    role="dialog"
    aria-modal="true"
    aria-labelledby="cms-icon-picker-title-{{ $uid }}"
>
    <button
        type="button"
        class="cms-icon-picker-backdrop"
        data-cms-icon-picker-backdrop="{{ $uid }}"
        aria-label="Close"
        onclick="window.cmsIconPickerClose && window.cmsIconPickerClose('{{ $uid }}')"
    ></button>

    <div class="cms-icon-picker-dialog">
        <div class="cms-icon-picker-header">
            <p id="cms-icon-picker-title-{{ $uid }}" style="font-size: 0.9375rem; font-weight: 600; margin: 0;">
                @lang('cms::app.icon-picker.title')
            </p>
            <button
                type="button"
                class="cms-icon-picker-close-btn"
                aria-label="Close"
                onclick="window.cmsIconPickerClose && window.cmsIconPickerClose('{{ $uid }}')"
            >
                <span class="icon-cross-large text-2xl"></span>
            </button>
        </div>

        <div class="cms-icon-picker-toolbar">
            <div class="cms-icon-picker-tabs" data-cms-icon-picker-tabs="{{ $uid }}">
                @foreach ($libraries as $libraryKey => $library)
                    <button
                        type="button"
                        data-cms-icon-picker-tab="{{ $libraryKey }}"
                        data-cms-icon-picker-modal-uid="{{ $uid }}"
                        class="cms-icon-picker-tab {{ $libraryKey === $firstLibraryKey ? 'cms-icon-picker-tab-active' : '' }}"
                        onclick="window.cmsIconPickerSetTab && window.cmsIconPickerSetTab('{{ $uid }}', '{{ $libraryKey }}')"
                    >
                        {{ __($library['label_key']) }}
                    </button>
                @endforeach
            </div>

            <input
                type="search"
                data-cms-icon-picker-search="{{ $uid }}"
                class="cms-icon-picker-search"
                placeholder="@lang('cms::app.icon-picker.filter')"
                autocomplete="off"
            />
        </div>

        <div class="cms-icon-picker-body">
            @foreach ($libraries as $libraryKey => $library)
                <div
                    data-cms-icon-picker-panel="{{ $uid }}"
                    data-cms-icon-library="{{ $libraryKey }}"
                    class="cms-icon-picker-panel {{ $libraryKey !== $firstLibraryKey ? 'is-hidden' : '' }}"
                >
                    <div
                        data-cms-icon-picker-grid="{{ $uid }}"
                        data-cms-icon-library="{{ $libraryKey }}"
                        class="cms-icon-picker-grid"
                    >
                        @foreach ($library['icons'] as $iconClass)
                            <button
                                type="button"
                                data-cms-icon-class="{{ $iconClass }}"
                                data-cms-icon-picker-uid="{{ $uid }}"
                                class="cms-icon-picker-icon-btn"
                                title="{{ $iconClass }}"
                                onclick="window.cmsIconPickerSelect && window.cmsIconPickerSelect({{ json_encode($uid) }}, {{ json_encode($iconClass) }})"
                            >
                                <i class="{{ $iconClass }}" aria-hidden="true"></i>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
