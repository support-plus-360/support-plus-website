<x-admin::layouts>
	<x-slot:title>
		@lang('cms::app.case-studies.create.title')
	</x-slot>

	<x-admin::form :action="route('admin.cms.case-studies.store')" enctype="multipart/form-data">
		<div class="flex flex-col gap-4">
			<div
				class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
				<div class="flex flex-col gap-2">
					<x-admin::breadcrumbs name="cms.case-studies.create" />

					<div class="text-xl font-bold dark:text-white">
						@lang('cms::app.case-studies.create.title')
					</div>
				</div>

				<div class="flex items-center gap-x-2.5">
					<button type="submit" class="primary-button">
						@lang('cms::app.case-studies.create.save-btn')
					</button>
				</div>
			</div>

			@include('cms::case-studies._form', [
				'caseStudy' => null,
				'companies' => $companies,
				'caseStudyCategories' => $caseStudyCategories,
				'locales' => $locales,
			])
		</div>
	</x-admin::form>
</x-admin::layouts>
