<x-admin::layouts>
	<x-slot:title>
		@lang('cms::app.services.create.title')
	</x-slot>

	<x-admin::form :action="route('admin.cms.services.store')" enctype="multipart/form-data">
		<div class="flex flex-col gap-4">
			<div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
				<div class="flex flex-col gap-2">
					<x-admin::breadcrumbs name="cms.services.create" />
					<div class="text-xl font-bold dark:text-white">
						@lang('cms::app.services.create.title')
					</div>
				</div>
				<button type="submit" class="primary-button">
					@lang('cms::app.services.create.save-btn')
				</button>
			</div>

			@include('cms::services._form', [
				'service' => null,
				'companies' => $companies,
				'serviceTypes' => $serviceTypes,
				'locales' => $locales,
			])
		</div>
	</x-admin::form>

	@push('styles')
		@include('cms::components.icon-picker-styles')
	@endpush

	@push('scripts')
		@include('cms::components.icon-picker-modal', ['uid' => 'service-icon-picker'])
		@include('cms::components.icon-picker-scripts')
	@endpush
</x-admin::layouts>
