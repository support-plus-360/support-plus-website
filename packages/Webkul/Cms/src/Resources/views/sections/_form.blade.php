<div class="flex flex-col gap-2.5">
    <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
        <div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4 flex items-center justify-between gap-4">
                <div class="flex flex-col gap-1">
                    <p class="text-base font-semibold text-gray-800 dark:text-white">
                        @lang('cms::app.sections.form.general')
                    </p>
                </div>
            </div>

            <div class="flex flex-col gap-4">

                <div class="grid grid-cols-2 gap-4">

             	<!-- company -->
		<x-admin::form.control-group>
			<x-admin::form.control-group.label class="required">
			@lang('cms::app.sections.form.company')
			</x-admin::form.control-group.label>
			
			<x-admin::form.control-group.control
			type="select"
			id="company_id"
			name="company_id"
			rules="required"
			:value="old('company_id') ?? ($section?->company_id ?? '')"
			:label="trans('cms::app.sections.form.company')"
			>
			@foreach($companies as $company)
			<option value="{{ $company->id }}">
				{{ $company->name }}
			</option>
			@endforeach
			</x-admin::form.control-group.control>

			<x-admin::form.control-group.error control-name="company_id" />
		</x-admin::form.control-group>

 		<x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.sections.form.page')
                        </x-admin::form.control-group.label>

                        @if (isset($pages) && $pages)
                            <x-admin::form.control-group.control
                                type="select"
                                id="page_id"
                                name="page_id"
                                rules="required"
                                :value="old('page_id') ?? ($section?->page_id ?? '')"
                                :label="trans('cms::app.sections.form.page')"
                            >
                               
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}">
                                        {{ $page->name }} ({{ $page->slug }})
                                    </option>
                                @endforeach
                            </x-admin::form.control-group.control>
                        @else
                            <x-admin::form.control-group.control
                                type="number"
                                id="page_id"
                                name="page_id"
                                rules="required"
                                :value="old('page_id') ?? ($section?->page_id ?? '')"
                                :label="trans('cms::app.sections.form.page')"
                            />
                        @endif

                        <x-admin::form.control-group.error control-name="page_id" />
                    </x-admin::form.control-group>
                </div>



           

                <div class="grid grid-cols-2 gap-4">
                   
                <!-- name -->
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">
                        @lang('cms::app.sections.form.name')
                    </x-admin::form.control-group.label>

                    <x-admin::form.control-group.control
                        type="text"
                        id="name"
                        name="name"
                        rules="required"
                        :value="old('name') ?? ($section?->name ?? '')"
                        :label="trans('cms::app.sections.form.name')"
                    />

                    <x-admin::form.control-group.error control-name="name" />
                </x-admin::form.control-group>

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('cms::app.sections.form.section_layout')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control
                            type="select"
                            id="section_layout"
                            name="section_layout"
                            rules="required"
                            :value="old('section_layout') ?? ($section?->section_layout ?? ($defaultSectionLayout ?? ''))"
                            :label="trans('cms::app.sections.form.section_layout')"
                        >
                            @foreach ($sectionLayouts ?? [] as $layoutKey => $layoutMeta)
                                <option value="{{ $layoutKey }}">{{ $layoutMeta['label'] ?? $layoutKey }}</option>
                            @endforeach
                        </x-admin::form.control-group.control>

                        <x-admin::form.control-group.error control-name="section_layout" />
                    </x-admin::form.control-group>
                </div>

                <div class="grid grid-cols-3 gap-4">

                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('cms::app.sections.form.order')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="number"
                            id="order"
                            name="order"
                            :value="old('order') ?? ($section?->order ?? 0)"
                            :label="trans('cms::app.sections.form.order')"
                        />

                        <x-admin::form.control-group.error control-name="order" />
                    </x-admin::form.control-group>
		<!-- active -->
   		<x-admin::form.control-group class="!mb-0">
                        <x-admin::form.control-group.label>
                            @lang('cms::app.sections.form.active')
                        </x-admin::form.control-group.label>

                        <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                            <input
                                type="checkbox"
                                name="is_active"
                                value="1"
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
                                @checked(old('is_active', $section?->is_active ?? true))
                            />
                            <span>@lang('cms::app.sections.form.active')</span>
                        </label>

                        <x-admin::form.control-group.error control-name="is_active" />
                    </x-admin::form.control-group>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label>
                            @lang('cms::app.sections.form.settings')
                        </x-admin::form.control-group.label>

                        <x-admin::form.control-group.control
                            type="textarea"
                            id="settings"
                            name="settings"
                            :value="old('settings') ?? (isset($section) ? json_encode($section->settings, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) : '')"
                            :label="trans('cms::app.sections.form.settings')"
                        />

                        <x-admin::form.control-group.error control-name="settings" />
                    </x-admin::form.control-group>

                 
                </div>
            </div>
        </div>
    </div>

    @include('cms::components.media-manager', [
        'entity' => $section ?? null,
        'uid' => 'section-media-manager',
        'mainOnly' => true,
    ])

    <div class="flex w-full flex-col gap-2">
        <x-admin::accordion>
            <x-slot:header>
                <div class="flex items-center justify-between">
                    <p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
                        @lang('cms::app.sections.form.translations')
                    </p>
                </div>
            </x-slot>

            <x-slot:content>
                @php($tabId = 'cms-section-translations')

                <div class="mb-4 flex flex-wrap gap-2 border-b border-gray-200 pb-2 dark:border-gray-800">
                    @foreach($locales as $locale => $localeLabel)
                        <button
                            type="button"
                            class="cms-locale-tab rounded-md px-3 py-1.5 text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-950 {{ $loop->first ? 'bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-white' : 'text-gray-700 dark:text-gray-300' }}"
                            data-tab-group="{{ $tabId }}"
                            data-tab="{{ $locale }}"
                        >
                            {{ $localeLabel }}
                        </button>
                    @endforeach
                </div>

                @foreach($locales as $locale => $localeLabel)
                    @php($row = $section?->translations?->firstWhere('locale', $locale))

                    <div
                        class="cms-locale-panel {{ $loop->first ? '' : 'hidden' }}"
                        data-tab-group="{{ $tabId }}"
                        data-tab-panel="{{ $locale }}"
                    >
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('cms::app.sections.form.title_'.$locale)
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="translations_{{ $locale }}_title"
                                name="translations[{{ $locale }}][title]"
                                rules="required"
                                :value="old('translations.'.$locale.'.title') ?? ($row?->title ?? '')"
                                :label="trans('cms::app.sections.form.title_'.$locale)"
                            />

                            <x-admin::form.control-group.error control-name="translations.{{ $locale }}.title" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label>
                                @lang('cms::app.sections.form.subtitle_'.$locale)
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                id="translations_{{ $locale }}_subtitle"
                                name="translations[{{ $locale }}][subtitle]"
                                :value="old('translations.'.$locale.'.subtitle') ?? ($row?->subtitle ?? '')"
                                :label="trans('cms::app.sections.form.subtitle_'.$locale)"
                            />

                            <x-admin::form.control-group.error control-name="translations.{{ $locale }}.subtitle" />
                        </x-admin::form.control-group>

                        <x-admin::form.control-group class="!mb-0">
                            <x-admin::form.control-group.label>
                                @lang('cms::app.sections.form.description_'.$locale)
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="textarea"
                                id="translations_{{ $locale }}_description"
                                name="translations[{{ $locale }}][description]"
                                :value="old('translations.'.$locale.'.description') ?? ($row?->description ?? '')"
                                :label="trans('cms::app.sections.form.description_'.$locale)"
                            />

                            <x-admin::form.control-group.error control-name="translations.{{ $locale }}.description" />
                        </x-admin::form.control-group>
                    </div>
                @endforeach
            </x-slot>
        </x-admin::accordion>
    </div>
</div>



@pushOnce('scripts')
    <script type="module">
        (() => {
            const setActive = (group, tab) => {
                document.querySelectorAll(`.cms-locale-tab[data-tab-group="${group}"]`).forEach((btn) => {
                    const isActive = btn.getAttribute('data-tab') === tab;

                    btn.classList.toggle('bg-gray-100', isActive);
                    btn.classList.toggle('dark:bg-gray-950', isActive);
                    btn.classList.toggle('text-gray-900', isActive);
                    btn.classList.toggle('dark:text-white', isActive);
                });

                document.querySelectorAll(`.cms-locale-panel[data-tab-group="${group}"]`).forEach((panel) => {
                    panel.classList.toggle('hidden', panel.getAttribute('data-tab-panel') !== tab);
                });
            };

            const initGroup = (group) => {
                const first = document.querySelector(`.cms-locale-tab[data-tab-group="${group}"]`);

                if (! first) {
                    return;
                }

                // Default to the first locale tab.
                setActive(group, first.getAttribute('data-tab'));
            };

            document.addEventListener('click', (e) => {
                const btn = e.target.closest('.cms-locale-tab');

                if (! btn) {
                    return;
                }

                setActive(btn.getAttribute('data-tab-group'), btn.getAttribute('data-tab'));
            });

            initGroup(@json($tabId));
        })();
    </script>
@endPushOnce

