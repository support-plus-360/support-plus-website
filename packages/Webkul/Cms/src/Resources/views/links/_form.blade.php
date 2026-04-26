@php
$linkableTypeLabels = [
\Webkul\Cms\Models\Page::class => __('cms::app.links.form.linkable_page'),
\Webkul\Cms\Models\Section::class => __('cms::app.links.form.linkable_section'),
\Webkul\Cms\Models\Item::class => __('cms::app.links.form.linkable_item'),
];
$linkTypeLabels = [
'social' => __('cms::app.links.form.link_type_social'),
'contact' => __('cms::app.links.form.link_type_contact'),
'quick' => __('cms::app.links.form.link_type_quick'),
'custom' => __('cms::app.links.form.link_type_custom'),
];
$targetLabels = [
'_self' => __('cms::app.links.form.target_self'),
'_blank' => __('cms::app.links.form.target_blank'),
];
$tabId = 'cms-link-translations';

/** Admin icomoon classes from `Webkul/Admin/.../app.css` — used by the link icon picker. */
$cmsAdminIconClasses = [
'icon-cms', 'icon-mail', 'icon-user', 'icon-profile', 'icon-contact', 'icon-leads', 'icon-organization', 'icon-activity',
'icon-attribute', 'icon-bookmark', 'icon-bookmark-active',
'icon-calendar', 'icon-call', 'icon-meeting', 'icon-message', 'icon-note', 'icon-video', 'icon-attachment',
'icon-attached-file', 'icon-forward', 'icon-reply',
'icon-reply-all', 'icon-sent', 'icon-notification', 'icon-configuration', 'icon-setting', 'icon-filter', 'icon-search',
'icon-add', 'icon-add-2', 'icon-edit', 'icon-delete',
'icon-dashboard', 'icon-kanban', 'icon-list', 'icon-enter', 'icon-move', 'icon-location', 'icon-pin', 'icon-print',
'icon-tag', 'icon-stats-down', 'icon-stats-up',
'icon-file', 'icon-folder', 'icon-image', 'icon-product', 'icon-rotten', 'icon-percentage', 'icon-dollar', 'icon-quote',
'icon-perosnal', 'icon-system-generate', 'icon-download',
'icon-info', 'icon-error', 'icon-success', 'icon-warning', 'icon-eye', 'icon-eye-hide', 'icon-left-arrow',
'icon-right-arrow', 'icon-up-arrow', 'icon-down-arrow',
'icon-menu', 'icon-more', 'icon-tick', 'icon-cross-large', 'icon-restore', 'icon-forceDelete', 'icon-mail',
'icon-settings-mail', 'icon-settings-group', 'icon-settings-webforms',
'icon-light', 'icon-dark', 'icon-checkbox-outline', 'icon-checkbox-select', 'icon-radio-selected', 'icon-radio-normal',
];
$cmsAdminIconClasses = array_values(array_unique($cmsAdminIconClasses));
@endphp

<div class="flex flex-col gap-2.5 max-xl:flex-wrap" data-cms-link-api="{{ e($linkableOptionsUrl) }}">
	<div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
		<div
			class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
			<div class="mb-4 flex items-center justify-between gap-4">
				<div class="flex flex-col gap-1">
					<p class="text-base font-semibold text-gray-800 dark:text-white">
						@lang('cms::app.links.form.general')
					</p>
				</div>
			</div>

			<div class="flex flex-col gap-4">
			

				<div class="grid grid-cols-3 gap-4 md:grid-cols-3">
						<x-admin::form.control-group>
					<x-admin::form.control-group.label>
						@lang('cms::app.links.form.company')
					</x-admin::form.control-group.label>
					<x-admin::form.control-group.control type="select" id="company_id"
						name="company_id"
						:value="old('company_id', $link?->company_id)"
						:label="trans('cms::app.links.form.company')">
						<option value="">
							{{ __('cms::app.links.form.company_placeholder') }}
						</option>
						@foreach ($companies as $company)
						<option value="{{ $company->id }}" @selected((string)
							old('company_id', $link?->company_id) === (string)
							$company->id)>
							{{ $company->name }}
						</option>
						@endforeach
					</x-admin::form.control-group.control>
					<x-admin::form.control-group.error control-name="company_id" />
				</x-admin::form.control-group>
					<x-admin::form.control-group>
						<x-admin::form.control-group.label class="required">
							@lang('cms::app.links.form.linkable_type')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="select"
							id="linkable_type" name="linkable_type"
							rules="required"
							:value="old('linkable_type', $link?->linkable_type)"
							:label="trans('cms::app.links.form.linkable_type')">
							<option value="">
								{{ __('cms::app.links.form.linkable_placeholder') }}
							</option>
							@foreach ($linkableTypeLabels as $class =>
							$ltitle)
							<option value="{{ $class }}"
								@selected(old('linkable_type', $link?->
								linkable_type) === $class)>
								{{ $ltitle }}
							</option>
							@endforeach
						</x-admin::form.control-group.control>
						<x-admin::form.control-group.error
							control-name="linkable_type" />
					</x-admin::form.control-group>

					@php
					$linkableIdValue = old('linkable_id', $link?->linkable_id);
					@endphp
					<x-admin::form.control-group>
						<x-admin::form.control-group.label class="required">
							@lang('cms::app.links.form.linkable')
						</x-admin::form.control-group.label>
						{{-- Native select: v-field/vee-validate re-renders and blocks choosing values after JS repopulates options. Server LinkRequest still validates. --}}
						<select name="linkable_id" id="linkable_id"
							class="custom-select w-full rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400">
							<option value="">
								{{ __('cms::app.links.form.linkable_placeholder') }}
							</option>
							@if($linkableIdValue !== null && $linkableIdValue
							!== '')
							<option value="{{ $linkableIdValue }}"
								@selected(true)>
								#{{ $linkableIdValue }}
							</option>
							@endif
						</select>
						<x-admin::form.control-group.error
							control-name="linkable_id" />
					</x-admin::form.control-group>
				</div>
                <div  class="grid grid-cols-2 gap-4 md:grid-cols-2">


				<x-admin::form.control-group>
					<x-admin::form.control-group.label class="required">
						@lang('cms::app.links.form.link')
					</x-admin::form.control-group.label>
					<x-admin::form.control-group.control type="text" id="link" name="link"
						rules="required" :value="old('link', $link?->link)"
						:label="trans('cms::app.links.form.link')" />
					<x-admin::form.control-group.error control-name="link" />
				</x-admin::form.control-group>

							<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.links.form.type')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="select" id="type"
							name="type" :value="old('type', $link?->type)"
							:label="trans('cms::app.links.form.type')">
							<option value="">
								{{ __('cms::app.links.form.type_placeholder') }}
							</option>
							@foreach ($linkTypeLabels as $val => $tlabel)
							<option value="{{ $val }}" @selected((string)
								old('type', $link?->type) === (string)
								$val)>
								{{ $tlabel }}
							</option>
							@endforeach
						</x-admin::form.control-group.control>
						<x-admin::form.control-group.error control-name="type" />
					</x-admin::form.control-group>

</div>

				@php
				$iconValue = old('icon', $link?->icon);
				@endphp
				<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.links.form.icon')
						</x-admin::form.control-group.label>
						{{-- Native text field so the picker and typing stay in sync without v-field fighting updates. --}}
						<div
							class="flex flex-col gap-2 sm:flex-row sm:items-center">
							<div
								class="flex min-w-0 flex-1 items-center gap-2">
								<input type="text" name="icon" id="icon"
									value="{{ $iconValue }}"
									autocomplete="off"
									placeholder="icon-mail"
									class="w-full min-w-0 rounded border border-gray-200 px-2.5 py-2 text-sm font-normal text-gray-800 transition-all hover:border-gray-400 focus:border-gray-400 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300 dark:hover:border-gray-400" />
								<span class="flex h-10 w-10 shrink-0 items-center justify-center rounded border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-800"
									title="{{ __('cms::app.links.form.icon') }}"
									aria-hidden="true">
									<i id="cms-icon-preview-i"
										class="@if($iconValue){{ $iconValue }}@endif text-2xl @if($iconValue) text-gray-800 dark:text-gray-200 @else text-gray-300 dark:text-gray-600 @endif"></i>
								</span>
							</div>
							<div class="flex flex-wrap items-center gap-2">
								<button type="button"
									class="secondary-button !py-1.5 text-sm"
									id="cms-icon-picker-open">
									@lang('cms::app.links.form.icon_picker')
								</button>
								<button type="button"
									class="rounded border border-gray-200 px-2.5 py-1.5 text-sm text-gray-600 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-950"
									id="cms-icon-picker-clear">
									@lang('cms::app.links.form.icon_picker_clear')
								</button>
							</div>
						</div>
						<p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
							@lang('cms::app.links.form.icon_picker_custom_hint')
						</p>
						<x-admin::form.control-group.error control-name="icon" />
					</x-admin::form.control-group>

		
				</div>

				<div class="grid grid-cols-3 gap-4">
					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.links.form.target')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="select"
							id="target" name="target"
							:value="old('target', $link?->target ?? '_self')"
							:label="trans('cms::app.links.form.target')">
							@foreach ($targetLabels as $val => $tlabel)
							<option value="{{ $val }}" @selected((string)
								old('target', $link?->target ?? '_self')
								=== (string) $val)>
								{{ $tlabel }}
							</option>
							@endforeach
						</x-admin::form.control-group.control>
						<x-admin::form.control-group.error control-name="target" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.links.form.order')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="number"
							id="order" name="order" rules="integer|min:0"
							:value="old('order', $link?->order ?? 0)"
							:label="trans('cms::app.links.form.order')" />
						<x-admin::form.control-group.error control-name="order" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
					<x-admin::form.control-group.label>
						@lang('cms::app.links.form.active')
					</x-admin::form.control-group.label>
					<label
						class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
						<input type="checkbox" name="is_active" value="1"
							class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
							@checked((bool) old('is_active', $link?->is_active
						?? true)) />
						<span>@lang('cms::app.links.form.active')</span>
					</label>
					<x-admin::form.control-group.error control-name="is_active" />
				</x-admin::form.control-group>
				</div>

				
			</div>
		</div>
	</div>

	<div class="flex w-full flex-col gap-2">
		<x-admin::accordion>
			<x-slot:header>
				<div class="flex items-center justify-between">
					<p
						class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
						@lang('cms::app.links.form.translations')
					</p>
				</div>
				</x-slot>

				<x-slot:content>
					@php($firstLocale = array_key_first($locales))
					<div class="mb-4 flex flex-wrap gap-2">
						@foreach ($locales as $locale => $localeLabel)
						<button type="button"
							class="cms-locale-tab rounded-md border border-gray-200 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-200 dark:hover:bg-gray-950 {{ $locale === $firstLocale ? 'bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-white' : '' }}"
							data-tab-group="{{ $tabId }}"
							data-tab="{{ $locale }}">
							{{ $localeLabel }} ({{ $locale }})
						</button>
						@endforeach
					</div>

					@foreach ($locales as $locale => $localeLabel)
					@php($row = $link?->translations?->firstWhere('locale', $locale))
					<div class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
						data-tab-group="{{ $tabId }}"
						data-tab-panel="{{ $locale }}">
						<input type="hidden"
							name="translations[{{ $locale }}][locale]"
							value="{{ $locale }}" />

						<x-admin::form.control-group>
							<x-admin::form.control-group.label
								class="required">
								@lang('cms::app.links.form.name')
							</x-admin::form.control-group.label>
							<x-admin::form.control-group.control type="text"
								id="translations_{{ $locale }}_name"
								name="translations[{{ $locale }}][name]"
								rules="required"
								:value="old('translations.' . $locale . '.name', $row?->name)"
								:label="trans('cms::app.links.form.name')" />
							<x-admin::form.control-group.error
								control-name="translations.{{ $locale }}.name" />
						</x-admin::form.control-group>
					</div>
					@endforeach
					</x-slot>
		</x-admin::accordion>
	</div>

	<dialog id="cms-icon-picker-dialog"
		class="w-[min(98vw,1400px)] max-w-none rounded-lg border-0 p-0 text-gray-800 shadow-2xl open:flex open:flex-col dark:bg-gray-900 dark:text-gray-200">
		<div
			class="flex items-center justify-between border-b border-gray-200 px-4 py-3 dark:border-gray-800">
			<p class="text-base font-semibold">@lang('cms::app.links.form.icon_picker_title')</p>
			<button type="button"
				class="cms-icon-picker-close flex h-8 w-8 items-center justify-center rounded hover:bg-gray-100 dark:hover:bg-gray-800"
				aria-label="Close">
				<span class="icon-cross-large text-2xl"></span>
			</button>
		</div>
		<div class="border-b border-gray-200 px-4 py-2 dark:border-gray-800">
			<input type="search" id="cms-icon-search"
				class="w-full rounded border border-gray-200 px-2.5 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-800"
				placeholder="@lang('cms::app.links.form.icon_picker_filter')"
				autocomplete="off" />
		</div>
		<div id="cms-icon-picker-grid"
			class="grid max-h-[min(70vh,28rem)] grid-cols-6 gap-1.5 overflow-y-auto p-3 sm:grid-cols-10 sm:gap-2 sm:p-4 md:grid-cols-12 lg:grid-cols-16">
			@foreach ($cmsAdminIconClasses as $iconClass)
			<button type="button" data-cms-icon-class="{{ $iconClass }}"
				class="flex aspect-square items-center justify-center rounded border border-gray-200 text-gray-700 transition-colors hover:border-gray-400 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:border-gray-500 dark:hover:bg-gray-800"
				title="{{ $iconClass }}">
				<span class="{{ $iconClass }} text-2xl" aria-hidden="true"></span>
			</button>
			@endforeach
		</div>
	</dialog>
</div>

<script type="application/json" id="cms-link-config">
@json([
	'url' => $linkableOptionsUrl,
	'current' => $currentLinkable ?? null,
])
</script>

@pushOnce('styles', 'webkul.cms.links.icon-picker')
<style>
#cms-icon-picker-dialog::backdrop {
	background: rgba(15, 23, 42, 0.45);
}
</style>
@endpushOnce

@pushOnce('scripts', 'webkul.cms.links.form')
<script>
(function() {
	const initialLinkableId = @json(old('linkable_id', $link?->linkable_id));
	const placeholderLabel = @json(__('cms::app.links.form.linkable_placeholder'));
	const loadingLabel = @json(__('cms::app.links.form.linkable_loading'));

	function getCmsLinkConfig() {
		const raw = document.getElementById('cms-link-config');
		if (!raw) {
			return {
				current: null,
				url: ''
			};
		}
		try {
			return JSON.parse(raw.textContent);
		} catch (e) {
			return {
				current: null,
				url: ''
			};
		}
	}

	function getBaseUrl() {
		const fromData = document.querySelector('[data-cms-link-api]');
		if (fromData && fromData.getAttribute('data-cms-link-api')) {
			return String(fromData.getAttribute('data-cms-link-api'));
		}
		return String(getCmsLinkConfig().url || '');
	}

	/** Prefer #app so we do not hit other forms; v-form may not forward `id="cms-link-form"` to a parent that wraps fields. */
	function getSelects() {
		const root = document.getElementById('app') || document;
		return {
			type: root.querySelector('select[name="linkable_type"]') || root.querySelector(
				'select#linkable_type'),
			id: root.querySelector('select[name="linkable_id"]') || root.querySelector(
				'select#linkable_id'),
			company: root.querySelector('select[name="company_id"]') || root.querySelector(
				'select#company_id'),
		};
	}

	const current = getCmsLinkConfig().current;

	let lastMorphType = '';
	let requestCounter = 0;
	let delegateBound = false;

	const emptyFragment = (message) => {
		const frag = document.createDocumentFragment();
		const empty = document.createElement('option');
		empty.value = '';
		empty.textContent = message;
		frag.appendChild(empty);
		return frag;
	};

	const buildOptionsFromRows = (rows, morphType) => {
		let list = Array.isArray(rows) ? rows : [];
		if (current && String(current.type) === String(morphType)) {
			const has = list.some((r) => Number(r.id) === Number(current.id));
			if (!has) {
				list = [{
						id: current.id,
						name: current.name,
						company_id: null
					},
					...list,
				];
			}
		}
		const frag = document.createDocumentFragment();
		const empty = document.createElement('option');
		empty.value = '';
		empty.textContent = placeholderLabel;
		frag.appendChild(empty);
		list.forEach((r) => {
			const opt = document.createElement('option');
			opt.value = String(r.id);
			opt.textContent = r.name || ('#' + r.id);
			frag.appendChild(opt);
		});
		return frag;
	};

	const buildOptionsUrl = (morphType, companyEl) => {
		const baseUrl = getBaseUrl();
		const u = new URL(baseUrl, window.location.origin);
		u.searchParams.set('linkable_type', morphType);
		if (companyEl && companyEl.value) {
			u.searchParams.set('company_id', companyEl.value);
		}
		return u.toString();
	};

	const applySelection = (typeSelect, idSelect, typeChanged, previousId) => {
		const morphType = typeSelect.value;
		if (current && String(current.type) === String(morphType) && idSelect
			.querySelector(`option[value="${String(current.id)}"]`)) {
			idSelect.value = String(current.id);
			return;
		}
		if (!typeChanged && previousId && idSelect.querySelector(
				`option[value="${String(previousId)}"]`)) {
			idSelect.value = String(previousId);
			return;
		}
		if (initialLinkableId != null && String(initialLinkableId) !== '' && idSelect
			.querySelector(`option[value="${String(initialLinkableId)}"]`)) {
			idSelect.value = String(initialLinkableId);
		}
	};

	async function loadOptions() {
		const baseUrl = getBaseUrl();
		const {
			type: typeSelect,
			id: idSelect,
			company: companySelect
		} = getSelects();
		if (!baseUrl || !typeSelect || !idSelect) {
			return;
		}

		const morphType = typeSelect.value;
		const typeChanged = morphType !== lastMorphType;
		const previousId = idSelect.value;

		if (!morphType) {
			lastMorphType = '';
			idSelect.replaceChildren();
			idSelect.appendChild(emptyFragment(placeholderLabel));
			idSelect.disabled = false;
			return;
		}

		const myRequest = ++requestCounter;
		idSelect.disabled = true;
		idSelect.replaceChildren();
		idSelect.appendChild(emptyFragment(loadingLabel));

		try {
			const res = await fetch(buildOptionsUrl(morphType, companySelect), {
				method: 'GET',
				credentials: 'same-origin',
				headers: {
					'Accept': 'application/json',
					'X-Requested-With': 'XMLHttpRequest',
				},
			});
			if (myRequest !== requestCounter) {
				return;
			}
			if (!res.ok) {
				throw new Error('HTTP ' + res.status);
			}
			const body = await res.json();
			const rows = body.data;
			lastMorphType = morphType;
			idSelect.replaceChildren();
			idSelect.appendChild(buildOptionsFromRows(rows, morphType));
			applySelection(typeSelect, idSelect, typeChanged, previousId);
		} catch (e) {
			if (myRequest === requestCounter) {
				idSelect.replaceChildren();
				idSelect.appendChild(emptyFragment(placeholderLabel));
			}
			console.error(e);
		} finally {
			if (myRequest === requestCounter) {
				idSelect.disabled = false;
			}
		}
	}

	function bindDelegatedChange() {
		if (delegateBound) {
			return;
		}
		delegateBound = true;

		function isCmsLinkFilterSelect(t) {
			if (!t || t.tagName !== 'SELECT') {
				return false;
			}
			if (t.name === 'linkable_type' || t.name === 'company_id') {
				return true;
			}
			return t.id === 'linkable_type' || t.id === 'company_id';
		}
		document.addEventListener(
			'change',
			function(e) {
				const t = e.target;
				if (!isCmsLinkFilterSelect(t)) {
					return;
				}
				const {
					type: typeSelect
				} = getSelects();
				if ((t.name === 'company_id' || t.id === 'company_id') &&
					typeSelect && !typeSelect.value) {
					return;
				}
				void loadOptions();
			},
			true
		);
	}

	function runWhenReady() {
		const setActive = (group, tab) => {
			document
				.querySelectorAll(
					`.cms-locale-tab[data-tab-group="${group}"]`)
				.forEach((btn) => {
					const isActive = btn.getAttribute(
						'data-tab') === tab;
					btn.classList.toggle('bg-gray-100',
						isActive);
					btn.classList.toggle('dark:bg-gray-950',
						isActive);
					btn.classList.toggle('text-gray-900',
						isActive);
					btn.classList.toggle('dark:text-white',
						isActive);
				});

			document
				.querySelectorAll(
					`.cms-locale-panel[data-tab-group="${group}"]`)
				.forEach((panel) => {
					panel.classList.toggle('hidden', panel
						.getAttribute(
							'data-tab-panel'
						) !== tab);
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
			setActive(btn.getAttribute('data-tab-group'), btn
				.getAttribute('data-tab'));
		});

		initGroup(@json($tabId));

		bindDelegatedChange();

		let bootAttempts = 0;

		function tryInitialLoad() {
			bootAttempts += 1;
			if (bootAttempts > 20) {
				return;
			}
			const u = getBaseUrl();
			const s = getSelects();
			if (!u || !s.type || !s.id) {
				window.setTimeout(tryInitialLoad, 80);
				return;
			}
			void loadOptions();
		}
		window.setTimeout(tryInitialLoad, 0);

		initCmsLinkIconPicker();
	}

	function initCmsLinkIconPicker() {
		const input = document.getElementById('icon');
		const dialog = document.getElementById('cms-icon-picker-dialog');
		const openBtn = document.getElementById('cms-icon-picker-open');
		const clearBtn = document.getElementById('cms-icon-picker-clear');
		const previewI = document.getElementById('cms-icon-preview-i');
		const search = document.getElementById('cms-icon-search');
		const grid = document.getElementById('cms-icon-picker-grid');

		if (!input) {
			return;
		}

		const baseIconClass = 'text-2xl text-gray-800 dark:text-gray-200';
		const emptyIconClass = 'text-2xl text-gray-300 dark:text-gray-600';

		function syncIconPreview() {
			if (!previewI) {
				return;
			}
			const v = (input.value || '').trim();
			previewI.className = v ? (v + ' ' + baseIconClass) : emptyIconClass;
		}

		syncIconPreview();
		input.addEventListener('input', syncIconPreview);

		if (dialog && typeof dialog.showModal === 'function') {
			openBtn?.addEventListener('click', function() {
				dialog.showModal();
				if (search) {
					search.value = '';
					grid?.querySelectorAll(
						'[data-cms-icon-class]'
					).forEach(function(
						btn) {
						btn.classList
							.remove(
								'hidden'
							);
					});
					search.focus();
				}
			});

			document.querySelectorAll('.cms-icon-picker-close').forEach(function(b) {
				b.addEventListener('click', function() {
					dialog.close();
				});
			});

			dialog.addEventListener('click', function(e) {
				if (e.target === dialog) {
					dialog.close();
				}
			});

			dialog.querySelectorAll('[data-cms-icon-class]').forEach(function(btn) {
				btn.addEventListener('click', function() {
					const cls = btn
						.getAttribute(
							'data-cms-icon-class'
						);
					if (cls) {
						input.value =
							cls;
						syncIconPreview
							();
						input.dispatchEvent(new Event('input', {
							bubbles: true
						}));
					}
					dialog.close();
				});
			});

			search?.addEventListener('input', function() {
				const q = (search.value || '').toLowerCase()
					.trim();
				grid?.querySelectorAll('[data-cms-icon-class]')
					.forEach(function(btn) {
						const c = (btn.getAttribute(
									'data-cms-icon-class'
								) ||
								''
							)
							.toLowerCase();
						btn.classList
							.toggle('hidden',
								Boolean(q &&
									!
									c
									.includes(
										q
									)
								)
							);
					});
			});
		}

		clearBtn?.addEventListener('click', function() {
			input.value = '';
			syncIconPreview();
			input.dispatchEvent(new Event('input', {
				bubbles: true
			}));
		});
	}

	function scheduleCmsLinkForm() {
		window.setTimeout(runWhenReady, 0);
	}

	if (document.readyState === 'complete') {
		scheduleCmsLinkForm();
	} else {
		window.addEventListener('load', scheduleCmsLinkForm, {
			once: true
		});
	}
})();
</script>
@endPushOnce
