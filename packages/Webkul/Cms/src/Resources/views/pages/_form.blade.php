@php($types = ['page' => 'Page', 'service' => 'Service', 'case_study' => 'Case Study', 'industry' => 'Industry'])
@php($statuses = ['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'])

<div class="flex gap-2.5 max-xl:flex-wrap">
    <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
        <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4 flex items-center justify-between gap-4">
                <div class="flex flex-col gap-1">
                    <p class="text-base font-semibold text-gray-800 dark:text-white">
                        @lang('cms::app.pages.form.general')
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">
                        @lang('cms::app.pages.form.slug')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="text"
                        id="slug"
                        name="slug"
                        rules="required"
                        :value="old('slug') ?? ($page?->slug ?? '')"
                        :label="trans('cms::app.pages.form.slug')"
                    />

                    <x-admin::form.control-group.error control-name="slug" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">
                        @lang('cms::app.pages.form.name')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="text"
                        id="name"
                        name="name"
                        rules="required"
                        :value="old('name') ?? ($page?->name ?? '')"
                        :label="trans('cms::app.pages.form.name')"
                    />

                    <x-admin::form.control-group.error control-name="name" />
                </x-admin::form.control-group>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.pages.form.type')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="select"
                            id="type"
                            name="type"
                            rules="required"
                            :value="old('type') ?? ($page?->type ?? 'page')"
                            :label="trans('cms::app.pages.form.type')"
                        >
                            @foreach($types as $value => $label)
                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="type" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.pages.form.status')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="select"
                            id="status"
                            name="status"
                            rules="required"
                            :value="old('status') ?? ($page?->status ?? 'draft')"
                            :label="trans('cms::app.pages.form.status')"
                        >
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}">
                                    {{ $label }}
                                </option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="status" />
                    </x-admin::form.control-group>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('cms::app.pages.form.order')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="number"
                            id="order"
                            name="order"
                            :value="old('order') ?? ($page?->order ?? 0)"
                            :label="trans('cms::app.pages.form.order')"
                        />

                        <x-admin::form.control-group.error control-name="order" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('cms::app.pages.form.published_at')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="datetime"
                            id="published_at"
                            name="published_at"
                            :value="old('published_at') ?? ($page?->published_at?->format('Y-m-d H:i:s') ?? now()->format('Y-m-d H:i:s'))"
                            :label="trans('cms::app.pages.form.published_at')"
                        />

                        <x-admin::form.control-group.error control-name="published_at" />
                    </x-admin::form.control-group>

                    <x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('cms::app.pages.form.active')
                        </x-admin::form.control-group.label>

                        <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                @checked(old('is_active', $page?->is_active ?? true))
                            />
                            <span>@lang('cms::app.pages.form.active')</span>
                        </label>

                        <x-admin::form.control-group.error control-name="is_active" />
                    </x-admin::form.control-group>
                </div>
            </div>
        </div>
    </div>

    <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
        <x-admin::accordion>
            <x-slot:header>
                <div class="flex items-center justify-between">
                    <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('cms::app.pages.form.translations')
                    </p>
                </div>
            </x-slot>

            <x-slot:content>
                @foreach($locales as $locale => $localeLabel)
                    @php($row = $page?->translations?->firstWhere('locale', $locale))
                    <div class="mb-4 border-b border-gray-200 pb-4 last:mb-0 last:border-0 last:pb-0 dark:border-gray-800">
                        <p class="mb-3 text-sm font-semibold text-gray-800 dark:text-white">
                            {{ $localeLabel }} ({{ $locale }})
                        </p>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('cms::app.pages.form.title')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="translations_{{ $locale }}_title"
                                name="translations[{{ $locale }}][title]"
                                rules="required"
                                :value="old('translations.'.$locale.'.title') ?? ($row?->title ?? '')"
                                :label="trans('cms::app.pages.form.title')"
                            />

                            <x-admin::form.control-group.error control-name="translations.{{ $locale }}.title" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('cms::app.pages.form.meta_description')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                id="translations_{{ $locale }}_meta_description"
                                name="translations[{{ $locale }}][meta_description]"
                                :value="old('translations.'.$locale.'.meta_description') ?? ($row?->meta_description ?? '')"
                                :label="trans('cms::app.pages.form.meta_description')"
                            />

                            <x-admin::form.control-group.error control-name="translations.{{ $locale }}.meta_description" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label>
                                @lang('cms::app.pages.form.meta_keywords')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="translations_{{ $locale }}_meta_keywords"
                                name="translations[{{ $locale }}][meta_keywords]"
                                :value="old('translations.'.$locale.'.meta_keywords') ?? ($row?->meta_keywords ?? '')"
                                :label="trans('cms::app.pages.form.meta_keywords')"
                            />

                            <x-admin::form.control-group.error control-name="translations.{{ $locale }}.meta_keywords" />
                        </x-admin::form.control-group>
                    </div>
                @endforeach
            </x-slot>
        </x-admin::accordion>
    </div>
</div>

