<x-admin::layouts>
    <x-slot:title>
        @lang('cms::app.pages.index.title')
    </x-slot>

    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                <x-admin::breadcrumbs name="cms.pages" />

                <div class="text-xl font-bold dark:text-white">
                    @lang('cms::app.pages.index.title')
                </div>
            </div>

            <div class="flex items-center gap-x-2.5">
                <a
                    href="{{ route('admin.cms.pages.create') }}"
                    class="primary-button"
                >
                    @lang('cms::app.pages.index.create-btn')
                </a>
            </div>
        </div>

        <x-admin::datagrid :src="route('admin.cms.pages.index')">
            <x-admin::shimmer.datagrid />
        </x-admin::datagrid>
    </div>
</x-admin::layouts>

