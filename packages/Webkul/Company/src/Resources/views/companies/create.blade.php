<x-admin::layouts>
    <x-slot:title>
        @lang('company::app.companies.create.title')
    </x-slot>

    <x-admin::form :action="route('admin.company.store')">
        <div class="flex flex-col gap-4">
            <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div class="flex flex-col gap-2">
                    <x-admin::breadcrumbs name="company.create" />

                    <div class="text-xl font-bold dark:text-white">
                        @lang('company::app.companies.create.title')
                    </div>
                </div>

                <div class="flex items-center gap-x-2.5">
                    <button type="submit" class="primary-button">
                        @lang('company::app.companies.create.save-btn')
                    </button>
                </div>
            </div>

            @include('company::companies._form', ['company' => null])
        </div>
    </x-admin::form>
</x-admin::layouts>

