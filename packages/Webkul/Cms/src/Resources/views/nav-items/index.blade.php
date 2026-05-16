<x-admin::layouts>
    <x-slot:title>
        @lang('cms::app.nav-items.index.title', ['menu' => $navMenu->name])
    </x-slot>

    <div class="flex flex-col gap-4">
        <div
            class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
            <div class="flex flex-col gap-2">
                <x-admin::breadcrumbs name="cms.nav-menus.items" :entity="$navMenu" />

                <div class="text-xl font-bold dark:text-white">
                    @lang('cms::app.nav-items.index.title', ['menu' => $navMenu->name])
                    <span class="ml-2 text-sm font-normal text-gray-500">({{ $navMenu->key }})</span>
                </div>
            </div>

            <div class="flex items-center gap-x-2.5">
                <a href="{{ route('admin.cms.nav-menus.edit', $navMenu->id) }}" class="secondary-button">
                    @lang('cms::app.nav-items.index.back-to-menu')
                </a>

                <a href="{{ route('admin.cms.nav-menus.items.create', $navMenu->id) }}" class="primary-button">
                    @lang('cms::app.nav-items.index.create-btn')
                </a>
            </div>
        </div>

        <x-admin::datagrid :src="route('admin.cms.nav-menus.items.index', $navMenu->id)">
            <x-admin::shimmer.datagrid />
        </x-admin::datagrid>
    </div>
</x-admin::layouts>
