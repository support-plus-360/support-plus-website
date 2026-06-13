<x-admin::layouts>
	<x-slot:title>
		@lang('cms::app.service-types.create.title')
	</x-slot>

	<x-admin::form :action="route('admin.cms.service-types.store')">
		<div class="flex flex-col gap-4">
			<div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
				<div class="flex flex-col gap-2">
					<x-admin::breadcrumbs name="cms.service-types.create" />
					<div class="text-xl font-bold dark:text-white">
						@lang('cms::app.service-types.create.title')
					</div>
				</div>
				<button type="submit" class="primary-button">
					@lang('cms::app.service-types.create.save-btn')
				</button>
			</div>

			@include('cms::service-types._form', ['serviceType' => null, 'companies' => $companies])
		</div>
	</x-admin::form>
</x-admin::layouts>
