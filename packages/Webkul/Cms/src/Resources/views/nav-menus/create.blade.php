<x-admin::layouts>
    <x-slot:title>
        @lang('cms::app.nav-menus.create.title')
    </x-slot>

    <x-admin::form :action="route('admin.cms.nav-menus.store')">
        <div class="flex flex-col gap-4">
            <div
                class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <x-admin::breadcrumbs name="cms.nav-menus.create" />

                    <div class="text-xl font-bold dark:text-white">
                        @lang('cms::app.nav-menus.create.title')
                    </div>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <button type="submit" class="primary-button">
                        @lang('cms::app.nav-menus.create.save-btn')
                    </button>
                </div>
            </div>

            @include('cms::nav-menus._form', ['navMenu' => null, 'companies' => $companies])
        </div>
    </x-admin::form>
</x-admin::layouts>
