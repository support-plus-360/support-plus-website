@php
$kpis = old('kpis', $caseStudy?->kpis ?? []);
if (! is_array($kpis)) {
$kpis = [];
}
if ($kpis === [] && old('kpis_json')) {
$decodedKpis = json_decode(old('kpis_json'), true);
if (is_array($decodedKpis)) {
$kpis = $decodedKpis;
}
}
if ($kpis === []) {
$kpis = [['key' => '', 'value' => '']];
}
$kpisJson = old('kpis_json', json_encode($kpis));
@endphp

<div class="flex flex-col gap-2.5 max-xl:flex-wrap">
	<div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
		<div
			class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
			<div class="mb-4 flex items-center justify-between gap-4">
				<div class="flex flex-col gap-1">
					<p class="text-base font-semibold text-gray-800 dark:text-white">
						@lang('cms::app.case-studies.form.general')
					</p>
				</div>
			</div>

			<div class="flex flex-col gap-4">
				
				<div class="grid grid-cols-5 gap-4">

					<x-admin::form.control-group>
					<x-admin::form.control-group.label class="required">
						@lang('cms::app.case-studies.form.slug')
					</x-admin::form.control-group.label>
					<x-admin::form.control-group.control type="text" id="slug" name="slug"
						:value="old('slug', $caseStudy?->slug ?? '')"
						:label="trans('cms::app.case-studies.form.slug')" />
				</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label class="required">
							@lang('cms::app.case-studies.form.company')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="select"
							id="company_id" name="company_id"
							:value="old('company_id', $caseStudy?->company_id ?? '')"
							:label="trans('cms::app.case-studies.form.company')">
							@foreach($companies as $company)
							<option value="{{ $company->id }}">
								{{ $company->name }}
							</option>
							@endforeach
						</x-admin::form.control-group.control>

						<x-admin::form.control-group.error
							control-name="company_id" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.case-studies.form.category')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="select"
							id="cms_case_study_category_id"
							name="cms_case_study_category_id"
							:value="old('cms_case_study_category_id', $caseStudy?->cms_case_study_category_id ?? '')"
							:label="trans('cms::app.case-studies.form.category')">
							@foreach($caseStudyCategories as $category)
							<option value="{{ $category->id }}">
								{{ $category->name }}
							</option>
							@endforeach
						</x-admin::form.control-group.control>

						<x-admin::form.control-group.error
							control-name="cms_case_study_category_id" />
					</x-admin::form.control-group>

					<x-admin::form.control-group class="!mb-0">
						<x-admin::form.control-group.label>
							@lang('cms::app.case-studies.form.active')
						</x-admin::form.control-group.label>

						<label
							class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
							<input type="checkbox" name="is_active" value="1"
								class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
								@checked(old('is_active',
								$caseStudy?->is_active
							?? true))
							/>
							<span>@lang('cms::app.case-studies.form.active')</span>
						</label>

						<x-admin::form.control-group.error
							control-name="is_active" />
					</x-admin::form.control-group>

					<x-admin::form.control-group class="!mb-0">
						<x-admin::form.control-group.label>
							@lang('cms::app.case-studies.form.featured')
						</x-admin::form.control-group.label>

						<label
							class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
							<input type="checkbox" name="is_featured"
								value="1"
								class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
								@checked(old('is_featured',
								$caseStudy?->is_featured ?? false))
							/>
							<span>@lang('cms::app.case-studies.form.featured')</span>
						</label>

						<x-admin::form.control-group.error
							control-name="is_featured" />
					</x-admin::form.control-group>
				</div>

				<div class="grid grid-cols-3 gap-4">
					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.case-studies.form.city')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="text" id="city"
							name="city"
							:value="old('city', $caseStudy?->city ?? '')"
							:label="trans('cms::app.case-studies.form.city')" />

						<x-admin::form.control-group.error control-name="city" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.case-studies.form.rate')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="number" id="rate"
							name="rate" step="0.01" min="0"
							:value="old('rate', $caseStudy?->rate ?? '')"
							:label="trans('cms::app.case-studies.form.rate')" />

						<x-admin::form.control-group.error control-name="rate" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.case-studies.form.order')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="number"
							id="order" name="order"
							:value="old('order', $caseStudy?->order ?? 0)"
							:label="trans('cms::app.case-studies.form.order')" />

						<x-admin::form.control-group.error control-name="order" />
					</x-admin::form.control-group>
				</div>


			</div>
		</div>

		<div
			class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
			<div class="mb-4 flex items-center justify-between gap-4">
				<p class="text-base font-semibold text-gray-800 dark:text-white">
					@lang('cms::app.case-studies.form.kpis')
				</p>

				<button type="button" id="cms-case-study-kpi-add"
					class="secondary-button text-sm">
					@lang('cms::app.case-studies.form.kpi-add')
				</button>
			</div>

			<input type="hidden" name="kpis_json" id="cms-case-study-kpis-json"
				value="{{ $kpisJson }}">

			<div id="cms-case-study-kpis" class="flex flex-col gap-3">
				@foreach($kpis as $kpi)
				<div class="cms-case-study-kpi-row grid grid-cols-12 gap-3 items-end">
					<div class="col-span-5">
						<div class="flex flex-col gap-1.5">
							<label
								class="text-xs font-medium text-gray-800 dark:text-white">
								@lang('cms::app.case-studies.form.kpi-key')
							</label>
							<input type="text" data-kpi-key
								value="{{ $kpi['key'] ?? '' }}"
								class="w-full rounded border border-gray-200 px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
						</div>
					</div>

					<div class="col-span-5">
						<div class="flex flex-col gap-1.5">
							<label
								class="text-xs font-medium text-gray-800 dark:text-white">
								@lang('cms::app.case-studies.form.kpi-value')
							</label>
							<input type="text" data-kpi-value
								value="{{ $kpi['value'] ?? '' }}"
								class="w-full rounded border border-gray-200 px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
						</div>
					</div>

					<div class="col-span-2">
						<button type="button"
							class="cms-case-study-kpi-remove secondary-button w-full text-sm"
							@if(count($kpis)===1) disabled @endif>
							@lang('cms::app.case-studies.form.kpi-remove')
						</button>
					</div>
				</div>
				@endforeach
			</div>
		</div>

		@include('cms::components.media-manager', [
		'entity' => $caseStudy ?? null,
		'uid' => 'case-study-media-manager',
		])
	</div>

	<div class="flex w-full flex-col gap-2">
		<x-admin::accordion>
			<x-slot:header>
				<div class="flex items-center justify-between">
					<p
						class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
						@lang('cms::app.case-studies.form.translations')
					</p>
				</div>
				</x-slot>

				<x-slot:content>
					@php($tabId = 'cms-case-study-translations')
					@php($firstLocale = array_key_first($locales))

					<div class="mb-4 flex flex-wrap gap-2">
						@foreach($locales as $locale => $localeLabel)
						<button type="button"
							class="cms-locale-tab rounded-md border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-950 {{ $locale === $firstLocale ? 'bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-white' : '' }}"
							data-tab-group="{{ $tabId }}"
							data-tab="{{ $locale }}">
							{{ $localeLabel }} ({{ $locale }})
						</button>
						@endforeach
					</div>

					@foreach($locales as $locale => $localeLabel)
					@php($row = $caseStudy?->translations?->firstWhere('locale',
					$locale))
					<div class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
						data-tab-group="{{ $tabId }}"
						data-tab-panel="{{ $locale }}">

						<x-admin::form.control-group>
							<x-admin::form.control-group.label
								class="required">
								@lang('cms::app.case-studies.form.title')
							</x-admin::form.control-group.label>

							<x-admin::form.control-group.control type="text"
								id="translations_{{ $locale }}_title"
								name="translations[{{ $locale }}][title]"
								rules="required"
								:value="old('translations.'.$locale.'.title') ?? ($row?->title ?? '')"
								:label="trans('cms::app.case-studies.form.title')" />

							<x-admin::form.control-group.error
								control-name="translations.{{ $locale }}.title" />
						</x-admin::form.control-group>

						<x-admin::form.control-group>
							<x-admin::form.control-group.label>
								@lang('cms::app.case-studies.form.sub_title')
							</x-admin::form.control-group.label>

							<x-admin::form.control-group.control type="text"
								id="translations_{{ $locale }}_sub_title"
								name="translations[{{ $locale }}][sub_title]"
								:value="old('translations.'.$locale.'.sub_title') ?? ($row?->sub_title ?? '')"
								:label="trans('cms::app.case-studies.form.sub_title')" />

							<x-admin::form.control-group.error
								control-name="translations.{{ $locale }}.sub_title" />
						</x-admin::form.control-group>

						<x-admin::form.control-group>
							<x-admin::form.control-group.label>
								@lang('cms::app.case-studies.form.content')
							</x-admin::form.control-group.label>

							<x-admin::form.control-group.control
								type="textarea"
								id="translations_{{ $locale }}_content"
								name="translations[{{ $locale }}][content]"
								:value="old('translations.'.$locale.'.content') ?? ($row?->content ?? '')"
								:label="trans('cms::app.case-studies.form.content')" />

							<x-admin::form.control-group.error
								control-name="translations.{{ $locale }}.content" />
						</x-admin::form.control-group>

						<x-admin::form.control-group>
							<x-admin::form.control-group.label>
								@lang('cms::app.case-studies.form.challenges')
							</x-admin::form.control-group.label>

							<x-admin::form.control-group.control
								type="textarea"
								id="translations_{{ $locale }}_challenges"
								name="translations[{{ $locale }}][challenges]"
								:value="old('translations.'.$locale.'.challenges') ?? ($row?->challenges ?? '')"
								:label="trans('cms::app.case-studies.form.challenges')" />

							<x-admin::form.control-group.error
								control-name="translations.{{ $locale }}.challenges" />
						</x-admin::form.control-group>

						<x-admin::form.control-group>
							<x-admin::form.control-group.label>
								@lang('cms::app.case-studies.form.solutions')
							</x-admin::form.control-group.label>

							<x-admin::form.control-group.control
								type="textarea"
								id="translations_{{ $locale }}_solutions"
								name="translations[{{ $locale }}][solutions]"
								:value="old('translations.'.$locale.'.solutions') ?? ($row?->solutions ?? '')"
								:label="trans('cms::app.case-studies.form.solutions')" />

							<x-admin::form.control-group.error
								control-name="translations.{{ $locale }}.solutions" />
						</x-admin::form.control-group>
					</div>
					@endforeach
					</x-slot>
		</x-admin::accordion>
	</div>
</div>

@pushOnce('scripts', 'cms.case-studies-form')
<script>
(() => {
	const kpiKeyLabel = @json(__('cms::app.case-studies.form.kpi-key'));
	const kpiValueLabel = @json(__('cms::app.case-studies.form.kpi-value'));
	const kpiRemoveLabel = @json(__('cms::app.case-studies.form.kpi-remove'));

	const setActive = (group, tab) => {
		document.querySelectorAll(`.cms-locale-tab[data-tab-group="${group}"]`).forEach(
			(btn) => {
				const isActive = btn.getAttribute('data-tab') ===
					tab;

				btn.classList.toggle('bg-gray-100', isActive);
				btn.classList.toggle('dark:bg-gray-950',
					isActive);
				btn.classList.toggle('text-gray-900', isActive);
				btn.classList.toggle('dark:text-white', isActive);
			});

		document.querySelectorAll(`.cms-locale-panel[data-tab-group="${group}"]`)
			.forEach((panel) => {
				panel.classList.toggle('hidden', panel
					.getAttribute(
						'data-tab-panel'
					) !==
					tab);
			});
	};

	const getKpiContainer = () => document.getElementById('cms-case-study-kpis');
	const getKpiJsonInput = () => document.getElementById('cms-case-study-kpis-json');

	const syncKpisJson = () => {
		const container = getKpiContainer();
		const hidden = getKpiJsonInput();

		if (!container || !hidden) {
			return;
		}

		const kpis = [];

		container.querySelectorAll('.cms-case-study-kpi-row').forEach((row) => {
			const key = (row.querySelector('[data-kpi-key]')
				?.value ?? '').trim();
			const value = (row.querySelector(
					'[data-kpi-value]')
				?.value ?? '').trim();

			if (key !== '' || value !== '') {
				kpis.push({
					key,
					value
				});
			}
		});

		hidden.value = JSON.stringify(kpis);
	};

	const updateRemoveButtons = () => {
		const container = getKpiContainer();

		if (!container) {
			return;
		}

		const rows = container.querySelectorAll('.cms-case-study-kpi-row');

		rows.forEach((row) => {
			const removeBtn = row.querySelector(
				'.cms-case-study-kpi-remove');

			if (removeBtn) {
				removeBtn.disabled = rows.length === 1;
			}
		});
	};

	const createRow = () => {
		const row = document.createElement('div');
		row.className = 'cms-case-study-kpi-row grid grid-cols-12 gap-3 items-end';
		row.innerHTML = `
			<div class="col-span-5">
				<div class="flex flex-col gap-1.5">
					<label class="text-xs font-medium text-gray-800 dark:text-white">${kpiKeyLabel}</label>
					<input type="text" data-kpi-key class="w-full rounded border border-gray-200 px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
				</div>
			</div>
			<div class="col-span-5">
				<div class="flex flex-col gap-1.5">
					<label class="text-xs font-medium text-gray-800 dark:text-white">${kpiValueLabel}</label>
					<input type="text" data-kpi-value class="w-full rounded border border-gray-200 px-3 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-white" />
				</div>
			</div>
			<div class="col-span-2">
				<button type="button" class="cms-case-study-kpi-remove secondary-button w-full text-sm">${kpiRemoveLabel}</button>
			</div>
		`;

		return row;
	};

	const initLocaleTabs = () => {
		const firstTab = document.querySelector('.cms-locale-tab');

		if (firstTab) {
			setActive(firstTab.getAttribute('data-tab-group'), firstTab
				.getAttribute('data-tab'));
		}
	};

	// Delegated handlers survive Vue remounting the form on window.load.
	document.addEventListener('click', (e) => {
		const localeTab = e.target.closest('.cms-locale-tab');

		if (localeTab) {
			setActive(localeTab.getAttribute('data-tab-group'),
				localeTab.getAttribute('data-tab'));

			return;
		}

		if (e.target.closest('#cms-case-study-kpi-add')) {
			const container = getKpiContainer();

			if (container) {
				container.appendChild(createRow());
				updateRemoveButtons();
				syncKpisJson();
			}

			return;
		}

		const removeBtn = e.target.closest('.cms-case-study-kpi-remove');

		if (!removeBtn || removeBtn.disabled) {
			return;
		}

		removeBtn.closest('.cms-case-study-kpi-row')?.remove();
		updateRemoveButtons();
		syncKpisJson();
	});

	document.addEventListener('submit', (e) => {
		if (e.target?.querySelector('#cms-case-study-kpis')) {
			syncKpisJson();
		}
	}, true);

	const init = () => {
		initLocaleTabs();
		updateRemoveButtons();
		syncKpisJson();
	};

	if (document.readyState === 'complete') {
		init();
	} else {
		window.addEventListener('load', init);
	}
})();
</script>
@endPushOnce
