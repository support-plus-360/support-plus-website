@php
    $currentLocale = app()->getLocale();
    $availableLocales = config('app.available_locales', []);
    $dropdownPosition = 'bottom-'.(in_array($currentLocale, ['fa', 'ar']) ? 'left' : 'right');
@endphp

<x-admin::dropdown :position="$dropdownPosition">
    <x-slot:toggle>
        <button
            type="button"
            class="flex h-9 cursor-pointer items-center gap-1.5 rounded-md px-2 text-sm font-medium text-gray-600 transition-all hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-950"
            title="@lang('admin::app.layouts.language')"
            aria-label="@lang('admin::app.layouts.language')"
        >
            <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.6 9h16.8M3.6 15h16.8" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.2 2.5 3.4 5.6 3.6 9-.2 3.4-1.4 6.5-3.6 9-2.2-2.5-3.4-5.6-3.6-9 .2-3.4 1.4-6.5 3.6-9z" />
            </svg>
            <span class="hidden uppercase sm:inline">{{ str_replace('_', '-', $currentLocale) }}</span>
        </button>
    </x-slot>

    <x-slot:content class="mt-2 !min-w-[11rem] border-t-0 !p-0">
        <div class="grid gap-0.5 py-1">
            @foreach ($availableLocales as $code => $label)
                <a
                    href="{{ route('admin.locale.switch', ['locale' => $code]) }}"
                    class="px-4 py-2 text-sm {{ $currentLocale === $code ? 'bg-gray-100 font-semibold text-gray-900 dark:bg-gray-950 dark:text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-950' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </x-slot>
</x-admin::dropdown>
