<div class="flex flex-col gap-2.5 max-xl:flex-wrap">
    <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
        <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4">
                <p class="text-base font-semibold text-gray-800 dark:text-white">
                    @lang('cms::app.nav-menus.form.general')
                </p>
            </div>

            <div class="flex flex-col gap-4">
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">
                        @lang('cms::app.nav-menus.form.company')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="select"
                        id="company_id"
                        name="company_id"
                        :value="old('company_id') ?? ($navMenu?->company_id ?? '')"
                        :label="trans('cms::app.nav-menus.form.company')"
                    >
                        <option value="">@lang('cms::app.nav-menus.form.company_none')</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </x-admin::form.control-group.control>

                    <x-admin::form.control-group.error control-name="company_id" />
                </x-admin::form.control-group>

                <div class="grid grid-cols-2 gap-4">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.nav-menus.form.name')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="name"
                            name="name"
                            rules="required"
                            :value="old('name') ?? ($navMenu?->name ?? '')"
                            :label="trans('cms::app.nav-menus.form.name')"
                        />

                        <x-admin::form.control-group.error control-name="name" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.nav-menus.form.key')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="select"
                            id="key"
                            name="key"
                            rules="required"
                            :value="old('key') ?? ($navMenu?->key ?? 'header')"
                            :label="trans('cms::app.nav-menus.form.key')"
                        >
                            <option value="header">@lang('cms::app.nav-menus.form.key_header')</option>
                            <option value="footer">@lang('cms::app.nav-menus.form.key_footer')</option>
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="key" />
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>
    </div>
</div>
