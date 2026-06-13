@php
$publishedValue = old('published_at');
if ($publishedValue !== null) {
$publishedValue = is_string($publishedValue) && $publishedValue !== ''
? \Illuminate\Support\Carbon::parse($publishedValue)->format('Y-m-d\TH:i')
: '';
} elseif ($blogPost?->published_at) {
$publishedValue = $blogPost->published_at->format('Y-m-d\TH:i');
} else {
$publishedValue = '';
}
@endphp
<div class="flex flex-col gap-2.5 max-xl:flex-wrap">
	<div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
		<div
			class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
			<div class="mb-4 flex items-center justify-between gap-4">
				<div class="flex flex-col gap-1">
					<p class="text-base font-semibold text-gray-800 dark:text-white">
						@lang('cms::app.blog-posts.form.general')
					</p>
				</div>
			</div>

			<div class="flex flex-col gap-4">
				<x-admin::form.control-group>
					<x-admin::form.control-group.label class="required">
						@lang('cms::app.blog-posts.form.company')
					</x-admin::form.control-group.label>

					<x-admin::form.control-group.control type="select" id="company_id"
						name="company_id"
						:value="old('company_id', $blogPost?->company_id ?? '')"
						:label="trans('cms::app.blog-posts.form.company')">
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
						@lang('cms::app.blog-posts.form.category')
					</x-admin::form.control-group.label>

					<x-admin::form.control-group.control type="select"
						id="cms_blog_category_id" name="cms_blog_category_id"
						rules="required"
						:value="old('cms_blog_category_id', $blogPost?->blogCategories?->first()?->id ?? '')"
						:label="trans('cms::app.blog-posts.form.category')">
						<option value=""></option>
						@foreach($blogCategories as $category)
						<option value="{{ $category->id }}">
							{{ $category->name }} ({{ $category->slug }})
						</option>
						@endforeach
					</x-admin::form.control-group.control>

					<x-admin::form.control-group.error
						control-name="cms_blog_category_ids" />
				</x-admin::form.control-group>

				<div class="grid grid-cols-3 gap-4 md:grid-cols-3">
					<x-admin::form.control-group>
						<x-admin::form.control-group.label class="required">
							@lang('cms::app.blog-posts.form.slug')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="text" id="slug"
							name="slug" rules="required"
							:value="old('slug', $blogPost?->slug ?? '')"
							:label="trans('cms::app.blog-posts.form.slug')" />

						<x-admin::form.control-group.error control-name="slug" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label class="required">
							@lang('cms::app.blog-posts.form.status')
						</x-admin::form.control-group.label>

						<x-admin::form.control-group.control type="select"
							id="status" name="status" rules="required"
							:value="old('status', $blogPost?->status ?? 'draft')"
							:label="trans('cms::app.blog-posts.form.status')">
							<option value="draft">
								@lang('cms::app.blog-posts.form.status_draft')
							</option>
							<option value="published">
								@lang('cms::app.blog-posts.form.status_published')
							</option>
							<option value="archived">
								@lang('cms::app.blog-posts.form.status_archived')
							</option>
						</x-admin::form.control-group.control>

						<x-admin::form.control-group.error control-name="status" />
					</x-admin::form.control-group>


					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.blog-posts.form.canonical_url')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="text"
							id="canonical_url" name="canonical_url"
							:value="old('canonical_url', $blogPost?->canonical_url ?? '')"
							:label="trans('cms::app.blog-posts.form.canonical_url')" />
						<x-admin::form.control-group.error
							control-name="canonical_url" />
					</x-admin::form.control-group>
				</div>

				<div class="grid grid-cols-3 gap-4">
					<div>
						<x-admin::form.control-group>
							<x-admin::form.control-group.label>
								@lang('cms::app.blog-posts.form.published_at')
							</x-admin::form.control-group.label>
							<input type="datetime-local" id="published_at"
								name="published_at"
								value="{{ $publishedValue }}"
								class="w-full rounded border border-gray-200 px-2.5 py-1.5 text-sm dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200" />
							<x-admin::form.control-group.error
								control-name="published_at" />
						</x-admin::form.control-group>
					</div>
					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.blog-posts.form.reading_time')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="number"
							id="reading_time_minutes"
							name="reading_time_minutes" min="0" step="1"
							:value="old('reading_time_minutes', $blogPost?->reading_time_minutes ?? '')"
							:label="trans('cms::app.blog-posts.form.reading_time')" />
						<x-admin::form.control-group.error
							control-name="reading_time_minutes" />
					</x-admin::form.control-group>

					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.blog-posts.form.order')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="number"
							id="order" name="order" min="0" step="1"
							:value="old('order', $blogPost?->order ?? 0)"
							:label="trans('cms::app.blog-posts.form.order')" />
						<x-admin::form.control-group.error control-name="order" />
					</x-admin::form.control-group>
				</div>

				<div class="grid grid-cols-2 gap-4 md:grid-cols-2">

					@if($blogPost)
					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.blog-posts.form.views')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="number"
							id="views_count" name="views_count" min="0"
							step="1"
							:value="old('views_count', $blogPost->views_count)"
							:label="trans('cms::app.blog-posts.form.views')" />
						<x-admin::form.control-group.error
							control-name="views_count" />
					</x-admin::form.control-group>
					@endif
					<x-admin::form.control-group>
						<x-admin::form.control-group.label>
							@lang('cms::app.blog-posts.form.author_name')
						</x-admin::form.control-group.label>
						<x-admin::form.control-group.control type="text"
							id="author_name" name="author_name"
							:value="old('author_name', $blogPost?->author_name ?? '')"
							:label="trans('cms::app.blog-posts.form.author_name')" />
					</x-admin::form.control-group>

				</div>

				<div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
					<x-admin::form.control-group class="!mb-0">
						<label
							class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
							<input type="checkbox" name="is_featured"
								value="1"
								class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
								@checked(old('is_featured',
								$blogPost?->is_featured
							?? false)) />
							<span>@lang('cms::app.blog-posts.form.featured')</span>
						</label>
					</x-admin::form.control-group>
					<x-admin::form.control-group class="!mb-0">
						<label
							class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
							<input type="checkbox" name="allow_comments"
								value="1"
								class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
								@checked(old('allow_comments',
								$blogPost?->allow_comments
							?? false)) />
							<span>@lang('cms::app.blog-posts.form.allow_comments')</span>
						</label>
					</x-admin::form.control-group>
					<x-admin::form.control-group class="!mb-0">
						<label
							class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
							<input type="checkbox" name="is_indexable"
								value="1"
								class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
								@checked(old('is_indexable',
								$blogPost?->is_indexable
							?? true)) />
							<span>@lang('cms::app.blog-posts.form.indexable')</span>
						</label>
					</x-admin::form.control-group>
					<x-admin::form.control-group class="!mb-0">
						<label
							class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
							<input type="checkbox" name="is_active" value="1"
								class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
								@checked(old('is_active',
								$blogPost?->is_active
							?? true)) />
							<span>@lang('cms::app.blog-posts.form.active')</span>
						</label>
					</x-admin::form.control-group>
				</div>

				<div class="grid grid-cols-2 gap-4">

				</div>
			</div>
		</div>
	</div>

	@include('cms::components.media-manager', [
	'entity' => $blogPost ?? null,
	'uid' => 'blog-post-media-manager',
	])

	<div class="flex w-full flex-col gap-2">
		<x-admin::accordion>
			<x-slot:header>
				<div class="flex items-center justify-between">
					<p
						class="p-2.5 text-base font-semibold text-gray-800 dark:text-white">
						@lang('cms::app.blog-posts.form.translations')
					</p>
				</div>
				</x-slot>

				<x-slot:content>
					@php($tabId = 'cms-blog-post-translations')
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
					@php($row = $blogPost?->translations?->firstWhere('locale',
					$locale))
					<div class="cms-locale-panel {{ $locale === $firstLocale ? '' : 'hidden' }}"
						data-tab-group="{{ $tabId }}"
						data-tab-panel="{{ $locale }}">
						<div class="flex flex-col gap-4">
							<x-admin::form.control-group>
								<x-admin::form.control-group.label
									class="required">
									@lang('cms::app.blog-posts.form.title')
								</x-admin::form.control-group.label>
								<x-admin::form.control-group.control
									type="text"
									id="translations_{{ $locale }}_title"
									name="translations[{{ $locale }}][title]"
									rules="required"
									:value="old('translations.'.$locale.'.title', $row?->title ?? '')"
									:label="trans('cms::app.blog-posts.form.title')" />
								<x-admin::form.control-group.error
									control-name="translations.{{ $locale }}.title" />
							</x-admin::form.control-group>

							<x-admin::form.control-group>
								<x-admin::form.control-group.label>
									@lang('cms::app.blog-posts.form.excerpt')
								</x-admin::form.control-group.label>
								<x-admin::form.control-group.control
									type="textarea"
									id="translations_{{ $locale }}_excerpt"
									name="translations[{{ $locale }}][excerpt]"
									rows="3"
									:value="old('translations.'.$locale.'.excerpt', $row?->excerpt ?? '')"
									:label="trans('cms::app.blog-posts.form.excerpt')" />
								<x-admin::form.control-group.error
									control-name="translations.{{ $locale }}.excerpt" />
							</x-admin::form.control-group>

							<x-admin::form.control-group>
								<x-admin::form.control-group.label>
									@lang('cms::app.blog-posts.form.content')
								</x-admin::form.control-group.label>
								@include('cms::components.blog-content-editor',
								[
								'locale' => $locale,
								'value' =>
								old('translations.'.$locale.'.content',
								$row?->content ?? ''),
								])
								<x-admin::form.control-group.error
									control-name="translations.{{ $locale }}.content" />
							</x-admin::form.control-group>

							<div
								class="grid grid-cols-1 gap-4 md:grid-cols-2">
								<x-admin::form.control-group>
									<x-admin::form.control-group.label>
										@lang('cms::app.blog-posts.form.meta_title')
									</x-admin::form.control-group.label>
									<x-admin::form.control-group.control
										type="text"
										id="translations_{{ $locale }}_meta_title"
										name="translations[{{ $locale }}][meta_title]"
										:value="old('translations.'.$locale.'.meta_title', $row?->meta_title ?? '')"
										:label="trans('cms::app.blog-posts.form.meta_title')" />
								</x-admin::form.control-group>
								<x-admin::form.control-group>
									<x-admin::form.control-group.label>
										@lang('cms::app.blog-posts.form.meta_keywords')
									</x-admin::form.control-group.label>
									<x-admin::form.control-group.control
										type="text"
										id="translations_{{ $locale }}_meta_keywords"
										name="translations[{{ $locale }}][meta_keywords]"
										:value="old('translations.'.$locale.'.meta_keywords', $row?->meta_keywords ?? '')"
										:label="trans('cms::app.blog-posts.form.meta_keywords')" />
								</x-admin::form.control-group>
							</div>
							<x-admin::form.control-group>
								<x-admin::form.control-group.label>
									@lang('cms::app.blog-posts.form.meta_description')
								</x-admin::form.control-group.label>
								<x-admin::form.control-group.control
									type="textarea"
									id="translations_{{ $locale }}_meta_description"
									name="translations[{{ $locale }}][meta_description]"
									rows="2"
									:value="old('translations.'.$locale.'.meta_description', $row?->meta_description ?? '')"
									:label="trans('cms::app.blog-posts.form.meta_description')" />
							</x-admin::form.control-group>
							<div
								class="grid grid-cols-1 gap-4 md:grid-cols-2">
								<x-admin::form.control-group>
									<x-admin::form.control-group.label>
										@lang('cms::app.blog-posts.form.og_title')
									</x-admin::form.control-group.label>
									<x-admin::form.control-group.control
										type="text"
										id="translations_{{ $locale }}_og_title"
										name="translations[{{ $locale }}][og_title]"
										:value="old('translations.'.$locale.'.og_title', $row?->og_title ?? '')"
										:label="trans('cms::app.blog-posts.form.og_title')" />
								</x-admin::form.control-group>
								<x-admin::form.control-group>
									<x-admin::form.control-group.label>
										@lang('cms::app.blog-posts.form.og_description')
									</x-admin::form.control-group.label>
									<x-admin::form.control-group.control
										type="textarea"
										id="translations_{{ $locale }}_og_description"
										name="translations[{{ $locale }}][og_description]"
										rows="2"
										:value="old('translations.'.$locale.'.og_description', $row?->og_description ?? '')"
										:label="trans('cms::app.blog-posts.form.og_description')" />
								</x-admin::form.control-group>
							</div>
						</div>
					</div>
					@endforeach
					</x-slot>
		</x-admin::accordion>
	</div>
</div>

@pushOnce('scripts', 'cms.blog-posts-tinymce')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.6.2/tinymce.min.js" crossorigin="anonymous"
	referrerpolicy="no-referrer"></script>
<script>
(function() {
	const uploadUrl = @json(route('admin.tinymce.upload'));
	const csrfToken = @json(csrf_token());
	const documentBaseUrl = @json(asset('/'));

	const skin = () => document.documentElement.classList.contains('dark') ? 'oxide-dark' : 'oxide';
	const contentCss = () => document.documentElement.classList.contains('dark') ? 'dark' : 'default';

	const uploadImage = (blobInfo, progress) => new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		xhr.open('POST', uploadUrl);
		xhr.upload.onprogress = (e) => progress((e.loaded / e.total) * 100);
		xhr.onload = () => {
			if (xhr.status < 200 || xhr.status >= 300) {
				reject('Upload failed');
				return;
			}
			const json = JSON.parse(xhr.responseText);
			if (!json?.location) {
				reject('Invalid upload response');
				return;
			}
			resolve(json.location);
		};
		xhr.onerror = () => reject('Upload failed');
		const formData = new FormData();
		formData.append('_token', csrfToken);
		formData.append('file', blobInfo.blob(), blobInfo.filename());
		xhr.send(formData);
	});

	const baseEditorConfig = () => ({
		relative_urls: false,
		remove_script_host: false,
		document_base_url: documentBaseUrl,
		plugins: 'lists link image table code preview fullscreen searchreplace wordcount media autolink',
		toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media table blockquote hr | removeformat | searchreplace preview fullscreen code',
		min_height: 420,
		menubar: 'edit view insert format tools table help',
		image_advtab: true,
		promotion: false,
		branding: false,
		skin: skin(),
		content_css: contentCss(),
		images_upload_handler: uploadImage,
	});

	const initPendingEditors = () => {
		if (typeof tinymce === 'undefined') {
			return false;
		}

		const pending = Array.from(document.querySelectorAll(
				'textarea.blog-post-content-editor'))
			.filter((el) => el.id && !tinymce.get(el.id));

		if (!pending.length) {
			return document.querySelectorAll('textarea.blog-post-content-editor')
				.length > 0;
		}

		const config = baseEditorConfig();

		pending.forEach((target) => {
			tinymce.init({
				...config,
				target
			});
		});

		return true;
	};

	const bootEditors = (attempt = 0) => {
		if (typeof tinymce === 'undefined') {
			if (attempt < 80) {
				window.setTimeout(() => bootEditors(attempt + 1), 150);
			}

			return;
		}

		const textareas = document.querySelectorAll(
			'textarea.blog-post-content-editor');

		if (textareas.length === 0) {
			if (attempt < 80) {
				window.setTimeout(() => bootEditors(attempt + 1), 150);
			}

			return;
		}

		initPendingEditors();
	};

	window.addEventListener('load', () => {
		window.setTimeout(() => bootEditors(0), 100);
	});

	document.addEventListener('submit', (event) => {
		if (typeof tinymce === 'undefined') {
			return;
		}
		const form = event.target;
		if (form?.querySelector?.('textarea.blog-post-content-editor')) {
			tinymce.triggerSave();
		}
	}, true);

	window.cmsBlogContentEditorResize = (panel) => {
		if (!panel || typeof tinymce === 'undefined') {
			return;
		}
		panel.querySelectorAll('textarea.blog-post-content-editor').forEach((
			textarea) => {
			const editor = tinymce.get(textarea.id);
			if (editor) {
				editor.fire('ResizeEditor');
			}
		});
	};
})();
</script>
@endPushOnce

@pushOnce('scripts', 'webkul.cms.blog-posts-form')
<script type="module">
(() => {
	const refreshTinyMceInPanel = (panel) => {
		if (typeof window.cmsBlogContentEditorResize === 'function') {
			window.cmsBlogContentEditorResize(panel);
		}
	};

	const setActive = (group, tab) => {
		document.querySelectorAll(`.cms-locale-tab[data-tab-group="${group}"]`)
			.forEach(
				(btn) => {
					const isActive = btn.getAttribute('data-tab') ===
						tab;
					btn.classList.toggle('bg-gray-100', isActive);
					btn.classList.toggle('dark:bg-gray-950',
						isActive);
					btn.classList.toggle('text-gray-900', isActive);
					btn.classList.toggle('dark:text-white',
						isActive);
				});
		document.querySelectorAll(`.cms-locale-panel[data-tab-group="${group}"]`)
			.forEach((panel) => {
				const isActive = panel.getAttribute(
					'data-tab-panel') === tab;
				panel.classList.toggle('hidden', !isActive);

				if (isActive) {
					window.requestAnimationFrame(() =>
						refreshTinyMceInPanel(
							panel));
				}
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