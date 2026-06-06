@props([
    'companies',
    'activeCompanyId' => null,
])

@if ($companies->isNotEmpty())
    <div class="rounded-lg border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <div class="flex gap-1 overflow-x-auto border-b border-gray-200 px-2 dark:border-gray-800">
            @foreach ($companies as $company)
                @php($isActive = (int) $activeCompanyId === (int) $company->id)
                <a
                    href="{{ request()->url() }}?company_id={{ $company->id }}"
                    @class([
                        'shrink-0 cursor-pointer whitespace-nowrap px-4 py-2.5 text-sm font-medium transition dark:text-white',
                        'border-brandColor border-b-2 !text-brandColor' => $isActive,
                        'text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white' => ! $isActive,
                    ])
                    @if ($isActive) aria-current="page" @endif
                >
                    {{ $company->name }}
                </a>
            @endforeach
        </div>
    </div>
@endif
