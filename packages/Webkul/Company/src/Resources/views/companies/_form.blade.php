<div class="flex gap-2.5 max-xl:flex-wrap">
    <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
        <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4 flex items-center justify-between gap-4">
                <div class="flex flex-col gap-1">
                    <p class="text-base font-semibold text-gray-800 dark:text-white">
                        @lang('company::app.companies.form.general')
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">
                        @lang('company::app.companies.form.name')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="text"
                        id="name"
                        name="name"
                        rules="required"
                        :value="old('name') ?? ($company?->name ?? '')"
                        :label="trans('company::app.companies.form.name')"
                    />

                    <x-admin::form.control-group.error control-name="name" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">
                        @lang('company::app.companies.form.short_name')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="text"
                        id="short_name"
                        name="short_name"
                        rules="required"
                        :value="old('short_name') ?? ($company?->short_name ?? '')"
                        :label="trans('company::app.companies.form.short_name')"
                    />

                    <x-admin::form.control-group.error control-name="short_name" />
                </x-admin::form.control-group>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('company::app.companies.form.website')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="text"
                            id="website"
                            name="website"
                            rules="required"
                            :value="old('website') ?? ($company?->website ?? '')"
                            :label="trans('company::app.companies.form.website')"
                        />

                        <x-admin::form.control-group.error control-name="website" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('company::app.companies.form.address')
                        </x-admin::form.control-group.label>

                        <div class="grid grid-cols-3 gap-4">
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    @lang('company::app.companies.form.email')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="email"
                                    id="address_email"
                                    name="address[email]"
                                    :value="old('address.email') ?? ($company?->address['email'] ?? '')"
                                    :label="trans('company::app.companies.form.email')"
                                />

                                <x-admin::form.control-group.error control-name="address.email" />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    @lang('company::app.companies.form.phone')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    id="address_phone"
                                    name="address[phone]"
                                    :value="old('address.phone') ?? ($company?->address['phone'] ?? '')"
                                    :label="trans('company::app.companies.form.phone')"
                                />

                                <x-admin::form.control-group.error control-name="address.phone" />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group class="!mb-0">
                                <x-admin::form.control-group.label>
                                @lang('company::app.companies.form.location')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    id="address_location"
                                    name="address[location]"
                                    :value="old('address.location') ?? ($company?->address['location'] ?? '')"
                                    :label="trans('company::app.companies.form.address')"
                                />

                                <x-admin::form.control-group.error control-name="address.location') ?? ($company?->address['location'] ?? '')"
                                    :label="trans('company::app.companies.form.location')"
                                />

                                <x-admin::form.control-group.error control-name="address.location" />
                            </x-admin::form.control-group>
                        </div>
                    </x-admin::form.control-group>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('company::app.companies.form.configs')
                        </x-admin::form.control-group.label>

                        <div class="grid grid-cols-3 gap-4">
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    @lang('company::app.companies.form.main_color')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="color"
                                    id="configs_main_color"
                                    name="configs[main_color]"
                                    :value="old('configs.main_color') ?? ($company?->configs['main_color'] ?? '')"
                                    :label="trans('company::app.companies.form.main_color')"
                                />

                                <x-admin::form.control-group.error control-name="configs.main_color" />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label>
                                    @lang('company::app.companies.form.secondary_color')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="color"
                                    id="configs_secondary_color"
                                    name="configs[secondary_color]"
                                    :value="old('configs.secondary_color') ?? ($company?->configs['secondary_color'] ?? '')"
                                    :label="trans('company::app.companies.form.secondary_color')"
                                />

                                <x-admin::form.control-group.error control-name="configs.secondary_color" />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group class="!mb-0">
                                <x-admin::form.control-group.label>
                                    @lang('company::app.companies.form.accent_color')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="color"
                                    id="configs_accent_color"
                                    name="configs[accent_color]"
                                    :value="old('configs.accent_color') ?? ($company?->configs['accent_color'] ?? '')"
                                    :label="trans('company::app.companies.form.accent_color')"
                                />

                                <x-admin::form.control-group.error control-name="configs.accent_color" />
                            </x-admin::form.control-group>
                        </div>
                    </x-admin::form.control-group>
                </div>

                 <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('company::app.companies.form.active')
                        </x-admin::form.control-group.label>

                        <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                @checked(old('is_active', $company?->is_active ?? true))
                            />
                            <span>@lang('company::app.companies.form.active')</span>
                        </label>

                        <x-admin::form.control-group.error control-name="is_active" />
                    </x-admin::form.control-group>
            </div>
        </div>
    </div>

   
</div>

