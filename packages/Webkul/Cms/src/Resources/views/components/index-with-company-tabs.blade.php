@props([
    'pageTitle',
    'breadcrumbName',
    'breadcrumbEntity' => null,
    'createRoute' => null,
    'createBtnLabel' => null,
    'datagridSrc',
    'companies',
    'activeCompanyId' => null,
    'showCreate' => true,
    'headerActions' => null,
])

<x-admin::layouts>
    <x-slot:title>{{ $pageTitle }}</x-slot>

    <div class="flex flex-col gap-4">
        <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                @if ($breadcrumbEntity)
                    <x-admin::breadcrumbs :name="$breadcrumbName" :entity="$breadcrumbEntity" />
                @else
                    <x-admin::breadcrumbs :name="$breadcrumbName" />
                @endif

                <div class="text-xl font-bold dark:text-white">
                    {{ $pageTitle }}
                </div>
            </div>

            @if ($headerActions)
                {{ $headerActions }}
            @elseif ($showCreate && $createRoute && $createBtnLabel)
                <div class="flex items-center gap-x-2.5">
                    <a href="{{ $createRoute }}" class="primary-button">
                        {{ $createBtnLabel }}
                    </a>
                </div>
            @endif
        </div>

        <x-cms::company-tabs
            :companies="$companies"
            :active-company-id="$activeCompanyId"
        />

        <x-admin::datagrid :src="$datagridSrc">
            <x-admin::shimmer.datagrid />
        </x-admin::datagrid>
    </div>
</x-admin::layouts>
