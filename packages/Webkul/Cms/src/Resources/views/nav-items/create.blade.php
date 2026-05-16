<x-admin::layouts>
    <x-slot:title>
        @lang('cms::app.nav-items.create.title')
    </x-slot>

    <x-admin::form :action="route('admin.cms.nav-menus.items.store', $navMenu->id)">
        <div class="flex flex-col gap-4">
            <div
                class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <x-admin::breadcrumbs name="cms.nav-menus.items.create" :entity="$navMenu" />

                    <div class="text-xl font-bold dark:text-white">
                        @lang('cms::app.nav-items.create.title')
                    </div>
                </div>

                <button type="submit" class="primary-button">
                    @lang('cms::app.nav-items.create.save-btn')
                </button>
            </div>

            @include('cms::nav-items._form', [
                'navMenu' => $navMenu,
                'navItem' => null,
                'locales' => $locales,
                'pages' => $pages,
                'parentOptions' => $parentOptions,
            ])
        </div>
    </x-admin::form>
</x-admin::layouts>
