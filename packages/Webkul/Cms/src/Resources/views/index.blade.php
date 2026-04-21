<x-admin::layouts>
    <!-- Title -->
    <x-slot:title>
        @lang('cms::app.menu.cms')
    </x-slot>

    <!-- Body -->
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                <div class="flex cursor-pointer items-center">
                    <!-- Breadcrumbs -->

                </div>

                <div class="text-xl font-bold dark:text-white">
                    @lang('cms::app.menu.cms')
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-4 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <a href="{{ route('admin.cms.pages.index') }}" class="text-brandColor hover:underline">
                @lang('cms::app.menu.pages')
            </a>
        </div>
    </div>
</x-admin::layouts>
