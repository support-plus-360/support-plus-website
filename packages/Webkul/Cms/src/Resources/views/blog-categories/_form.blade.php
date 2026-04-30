<div class="flex flex-col gap-2.5 max-xl:flex-wrap">
	<div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
		<div
			class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
			<div class="mb-4 flex items-center justify-between gap-4">
				<div class="flex flex-col gap-1">
					<p class="text-base font-semibold text-gray-800 dark:text-white">
						@lang('cms::app.blog-categories.form.general')
					</p>
				</div>
			</div>

			<div class="flex flex-col gap-4">


				<!-- company -->
				<x-admin::form.control-group>
					<x-admin::form.control-group.label class="required">
						@lang('cms::app.blog-categories.form.company')
					</x-admin::form.control-group.label>

					<x-admin::form.control-group.control type="select" id="company_id"
						name="company_id" rules="required"
						:value="old('company_id') ?? ($blogCategory?->company_id ?? '')"
						:label="trans('cms::app.blog-categories.form.company')">
						@foreach($companies as $company)
						<option value="{{ $company->id }}">
							{{ $company->name }}
						</option>
						@endforeach
					</x-admin::form.control-group.control>

					<x-admin::form.control-group.error control-name="company_id" />
				</x-admin::form.control-group>


				<div class="grid grid-cols-2 gap-4">
					<x-admin::form.control-group>
						<x-admin::form.control-group.label class="required">
							@lang('cms::app.blog-categories.form.name')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="text" id="name"
							name="name" rules="required"
							:value="old('name') ?? ($blogCategory?->name ?? '')"
							:label="trans('cms::app.blog-categories.form.name')" />

						<x-admin::form.control-group.error control-name="name" />
					</x-admin::form.control-group>


					<x-admin::form.control-group>
						<x-admin::form.control-group.label class="required">
							@lang('cms::app.blog-categories.form.slug')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="text" id="slug"
							name="slug" rules="required"
							:value="old('slug') ?? ($blogCategory?->slug ?? '')"
							:label="trans('cms::app.blog-categories.form.slug')" />

						<x-admin::form.control-group.error control-name="slug" />
					</x-admin::form.control-group>
				</div>





				<div class="grid grid-cols-3 gap-4">
					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.blog-categories.form.order')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="number"
							id="order" name="order"
							:value="old('order') ?? ($blogCategory?->order ?? 0)"
							:label="trans('cms::app.blog-categories.form.order')" />

						<x-admin::form.control-group.error control-name="order" />
					</x-admin::form.control-group>


					<x-admin::form.control-group class="!mb-0">
						<x-admin::form.control-group.label>
							@lang('cms::app.blog-categories.form.active')
						</x-admin::form.control-group.label>

						<label
							class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
							<input type="checkbox" name="is_active" value="1"
								class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
								@checked(old('is_active',
								$blogCategory?->is_active ?? true))
							/>
							<span>@lang('cms::app.blog-categories.form.active')</span>
						</label>

						<x-admin::form.control-group.error
							control-name="is_active" />
					</x-admin::form.control-group>
				</div>
			</div>
		</div>
	</div>

    @include('cms::components.media-manager', [
        'entity' => $blogCategory ?? null,
        'uid' => 'blog-category-media-manager',
    ])

	<div class="flex w-full flex-col gap-2">
		<x-admin::accordion>
			<x-slot:header>
				<div class="flex items-center justify-between">
					<p
						class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
						@lang('cms::app.blog-categories.form.translations')
					</p>
				</div>
				</x-slot>

				<x-slot:content>
					@php($tabId = 'cms-blog-category-translations')
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
					@php($row = $blogCategory?->translations?->firstWhere('locale',
					$locale))
					<div class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
						data-tab-group="{{ $tabId }}"
						data-tab-panel="{{ $locale }}">

						<x-admin::form.control-group>
							<x-admin::form.control-group.label
								class="required">
								@lang('cms::app.blog-categories.form.title')
							</x-admin::form.control-group.label>

							<x-admin::form.control-group.control type="text"
								id="translations_{{ $locale }}_title"
								name="translations[{{ $locale }}][title]"
								rules="required"
								:value="old('translations.'.$locale.'.title') ?? ($row?->title ?? '')"
								:label="trans('cms::app.blog-categories.form.title')" />

							<x-admin::form.control-group.error
								control-name="translations.{{ $locale }}.title" />
						</x-admin::form.control-group>

						<x-admin::form.control-group>
							<x-admin::form.control-group.label>
								@lang('cms::app.blog-categories.form.description')
							</x-admin::form.control-group.label>

							<x-admin::form.control-group.control
								type="textarea"
								id="translations_{{ $locale }}_description"
								name="translations[{{ $locale }}][description]"
								:value="old('translations.'.$locale.'.description') ?? ($row?->description ?? '')"
								:label="trans('cms::app.blog-categories.form.description')" />

							<x-admin::form.control-group.error
								control-name="translations.{{ $locale }}.description" />
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

	const initGroup = (group) => {
		const first = document.querySelector(
			`.cms-locale-tab[data-tab-group="${group}"]`);

		if (!first) {
			return;
		}

		setActive(group, first.getAttribute('data-tab'));
	};

	document.addEventListener('click', (e) => {
		const btn = e.target.closest('.cms-locale-tab');

		if (!btn) {
			return;
		}

		setActive(btn.getAttribute('data-tab-group'), btn.getAttribute(
			'data-tab'));
	});

	initGroup(@json($tabId));
})();
</script>
@endPushOnce