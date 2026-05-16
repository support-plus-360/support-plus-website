<x-admin::layouts>
    <x-slot:title>
        @lang('cms::app.nav-items.edit.title')
    </x-slot>

    <x-admin::form :action="route('admin.cms.nav-menus.items.update', [$navMenu->id, $navItem->id])" method="PUT">
        <div class="flex flex-col gap-4">
            <div
                class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <x-admin::breadcrumbs name="cms.nav-menus.items.edit" :entity="$navMenu" />

                    <div class="text-xl font-bold dark:text-white">
                        @lang('cms::app.nav-items.edit.title')
                    </div>
                </div>

                <button type="submit" class="primary-button">
                    @lang('cms::app.nav-items.edit.save-btn')
                </button>
            </div>

            @include('cms::nav-items._form', [
                'navMenu' => $navMenu,
                'navItem' => $navItem,
                'locales' => $locales,
                'pages' => $pages,
                'parentOptions' => $parentOptions,
            ])
        </div>
    </x-admin::form>
</x-admin::layouts>
