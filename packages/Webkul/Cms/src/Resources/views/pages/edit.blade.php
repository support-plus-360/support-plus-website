<x-admin::layouts>
    <x-slot:title>
        @lang('cms::app.pages.edit.title')
    </x-slot>

    <x-admin::form
        :action="route('admin.cms.pages.update', $page->id)"
        method="PUT"
    >
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <x-admin::breadcrumbs name="cms.pages.edit" :entity="$page" />

                    <div class="text-xl font-bold dark:text-white">
                        @lang('cms::app.pages.edit.title')
                    </div>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <button type="submit" class="primary-button">
                        @lang('cms::app.pages.edit.save-btn')
                    </button>
                </div>
            </div>

            @include('cms::pages._form')
        </div>
    </x-admin::form>
</x-admin::layouts>

