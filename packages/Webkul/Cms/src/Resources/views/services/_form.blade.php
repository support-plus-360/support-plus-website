<div class="flex flex-col gap-2.5 max-xl:flex-wrap">
	<div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
		<div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
			<div class="mb-4">
				<p class="text-base font-semibold text-gray-800 dark:text-white">
					@lang('cms::app.services.form.general')
				</p>
			</div>

			<div class="flex flex-col gap-4">
				<div class="grid grid-cols-3 gap-4">
					<x-admin::form.control-group>
						<x-admin::form.control-group.label class="required">
							@lang('cms::app.services.form.company')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="select" id="company_id" name="company_id"
							:value="old('company_id', $service?->company_id ?? '')"
							:label="trans('cms::app.services.form.company')">
							@foreach($companies as $company)
							<option value="{{ $company->id }}">{{ $company->name }}</option>
							@endforeach
						</x-admin::form.control-group.control>
						<x-admin::form.control-group.error control-name="company_id" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.services.form.service_type')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="select" id="cms_service_type_id" name="cms_service_type_id"
							:value="old('cms_service_type_id', $service?->cms_service_type_id ?? '')"
							:label="trans('cms::app.services.form.service_type')">
							<option value=""></option>
							@foreach($serviceTypes as $serviceType)
							<option value="{{ $serviceType->id }}">{{ $serviceType->name }}</option>
							@endforeach
						</x-admin::form.control-group.control>
						<x-admin::form.control-group.error control-name="cms_service_type_id" />
					</x-admin::form.control-group>

					<x-admin::form.control-group class="!mb-0">
						<x-admin::form.control-group.label>
							@lang('cms::app.services.form.active')
						</x-admin::form.control-group.label>
						<label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
							<input type="checkbox" name="is_active" value="1"
								class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
								@checked(old('is_active', $service?->is_active ?? true)) />
							<span>@lang('cms::app.services.form.active')</span>
						</label>
						<x-admin::form.control-group.error control-name="is_active" />
					</x-admin::form.control-group>
				</div>

				<div class="grid grid-cols-3 gap-4">

				<x-admin::form.control-group>
					<x-admin::form.control-group.label>
						@lang('cms::app.services.form.name')
					</x-admin::form.control-group.label>
					<x-admin::form.control-group.control type="text" id="name" name="name"
						:value="old('name', $service?->name ?? '')"
						:label="trans('cms::app.services.form.name')" />
					<x-admin::form.control-group.error control-name="name" />
				</x-admin::form.control-group>

				<x-admin::form.control-group>
					<x-admin::form.control-group.label>
						@lang('cms::app.services.form.slug')
					</x-admin::form.control-group.label>
					<x-admin::form.control-group.control type="text" id="slug" name="slug"
						:value="old('slug', $service?->slug ?? '')"
						:label="trans('cms::app.services.form.slug')" />
					<x-admin::form.control-group.error control-name="slug" />
				</x-admin::form.control-group>
				<x-admin::form.control-group>
					<x-admin::form.control-group.label>
						@lang('cms::app.services.form.order')
					</x-admin::form.control-group.label>
					<x-admin::form.control-group.control type="number" id="order" name="order"
						:value="old('order', $service?->order ?? 0)"
						:label="trans('cms::app.services.form.order')" />
					<x-admin::form.control-group.error control-name="order" />
				</x-admin::form.control-group>
				</div>
			</div>
		</div>

		<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
			@include('cms::components.media-manager', [
				'entity' => $service ?? null,
				'uid' => 'service-image-media-manager',
				'mainOnly' => true,
			])

			<div class="flex flex-col gap-4">
				<div class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
					@include('cms::components.icon-picker', [
						'name' => 'icon',
						'id' => 'service_icon',
						'value' => $service?->icon ?? '',
						'uid' => 'service-icon-picker',
						'label' => trans('cms::app.services.form.icon'),
					])
				</div>

				@include('cms::components.icon-media-manager', [
					'entity' => $service ?? null,
					'uid' => 'service-icon-media-manager',
				])
			</div>
		</div>
	</div>

	<div class="flex w-full flex-col gap-2">
		<x-admin::accordion>
			<x-slot:header>
				<p class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
					@lang('cms::app.services.form.translations')
				</p>
			</x-slot>

			<x-slot:content>
				@php($tabId = 'cms-service-translations')
				@php($firstLocale = array_key_first($locales))

				<div class="mb-4 flex flex-wrap gap-2">
					@foreach($locales as $locale => $localeLabel)
					<button type="button"
						class="cms-locale-tab rounded-md border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-950 {{ $locale === $firstLocale ? 'bg-gray-100 dark:bg-gray-950 text-gray-900 dark:text-white' : '' }}"
						data-tab-group="{{ $tabId }}" data-tab="{{ $locale }}">
						{{ $localeLabel }} ({{ $locale }})
					</button>
					@endforeach
				</div>

				@foreach($locales as $locale => $localeLabel)
				@php($row = $service?->translations?->firstWhere('locale', $locale))
				<div class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
					data-tab-group="{{ $tabId }}" data-tab-panel="{{ $locale }}">

					<x-admin::form.control-group>
						<x-admin::form.control-group.label class="required">
							@lang('cms::app.services.form.title')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="text"
							name="translations[{{ $locale }}][title]" rules="required"
							:value="old('translations.'.$locale.'.title') ?? ($row?->title ?? '')"
							:label="trans('cms::app.services.form.title')" />
						<x-admin::form.control-group.error control-name="translations.{{ $locale }}.title" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.services.form.sub_title')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="text"
							name="translations[{{ $locale }}][sub_title]"
							:value="old('translations.'.$locale.'.sub_title') ?? ($row?->sub_title ?? '')"
							:label="trans('cms::app.services.form.sub_title')" />
						<x-admin::form.control-group.error control-name="translations.{{ $locale }}.sub_title" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.services.form.problems')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="textarea"
							name="translations[{{ $locale }}][problems]"
							:value="old('translations.'.$locale.'.problems') ?? ($row?->problems ?? '')"
							:label="trans('cms::app.services.form.problems')" />
						<x-admin::form.control-group.error control-name="translations.{{ $locale }}.problems" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.services.form.solutions')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="textarea"
							name="translations[{{ $locale }}][solutions]"
							:value="old('translations.'.$locale.'.solutions') ?? ($row?->solutions ?? '')"
							:label="trans('cms::app.services.form.solutions')" />
						<x-admin::form.control-group.error control-name="translations.{{ $locale }}.solutions" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.services.form.key_benefits')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="textarea"
							name="translations[{{ $locale }}][key_benefits]"
							:value="old('translations.'.$locale.'.key_benefits') ?? ($row?->key_benefits ?? '')"
							:label="trans('cms::app.services.form.key_benefits')" />
						<x-admin::form.control-group.error control-name="translations.{{ $locale }}.key_benefits" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.services.form.deliverables')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="textarea"
							name="translations[{{ $locale }}][deliverables]"
							:value="old('translations.'.$locale.'.deliverables') ?? ($row?->deliverables ?? '')"
							:label="trans('cms::app.services.form.deliverables')" />
						<x-admin::form.control-group.error control-name="translations.{{ $locale }}.deliverables" />
					</x-admin::form.control-group>
				</div>
				@endforeach
			</x-slot>
		</x-admin::accordion>
	</div>
</div>

@pushOnce('scripts', 'cms.services-form')
<script>
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

	document.addEventListener('click', (e) => {
		const tabBtn = e.target.closest('.cms-locale-tab');

		if (tabBtn) {
			setActive(tabBtn.getAttribute('data-tab-group'), tabBtn.getAttribute('data-tab'));
		}
	});

	const firstTab = document.querySelector('.cms-locale-tab');

	if (firstTab) {
		setActive(firstTab.getAttribute('data-tab-group'), firstTab.getAttribute('data-tab'));
	}
})();
</script>
@endPushOnce
