<x-admin::layouts>
	<x-slot:title>
		@lang('cms::app.links.create.title')
		</x-slot>

		<x-admin::form :action="route('admin.cms.links.store')" id="cms-link-form">
			<div class="flex flex-col gap-4">
				<div
					class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
					<div class="flex flex-col gap-2">
						<x-admin::breadcrumbs name="cms.links.create" />

						<div class="text-xl font-bold dark:text-white">
							@lang('cms::app.links.create.title')
						</div>
					</div>

					<div class="flex items-center gap-x-2.5">
						<button type="submit" class="primary-button">
							@lang('cms::app.links.create.save-btn')
						</button>
					</div>
				</div>

				@include('cms::links._form', ['link' => null, 'companies' => $companies, 'locales' => $locales, 'linkableOptionsUrl' => $linkableOptionsUrl, 'currentLinkable' => null])
			</div>
		</x-admin::form>
</x-admin::layouts>
