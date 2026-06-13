<div class="flex flex-col gap-2.5 max-xl:flex-wrap">
	<div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
		<div
			class="box-shadow rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-900">
			<div class="mb-4 flex items-center justify-between gap-4">
				<div class="flex flex-col gap-1">
					<p class="text-base font-semibold text-gray-800 dark:text-white">
						@lang('cms::app.case-study-categories.form.general')
					</p>
				</div>
			</div>

			<div class="flex flex-col gap-4">
				<x-admin::form.control-group>
					<x-admin::form.control-group.label class="required">
						@lang('cms::app.case-study-categories.form.company')
					</x-admin::form.control-group.label>

					<x-admin::form.control-group.control type="select" id="company_id"
						name="company_id" rules="required"
						:value="old('company_id') ?? ($caseStudyCategory?->company_id ?? '')"
						:label="trans('cms::app.case-study-categories.form.company')">
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
						@lang('cms::app.case-study-categories.form.name')
					</x-admin::form.control-group.label>

					<x-admin::form.control-group.control type="text" id="name"
						name="name" rules="required"
						:value="old('name') ?? ($caseStudyCategory?->name ?? '')"
						:label="trans('cms::app.case-study-categories.form.name')" />

					<x-admin::form.control-group.error control-name="name" />
				</x-admin::form.control-group>

				<x-admin::form.control-group>
					<x-admin::form.control-group.label>
						@lang('cms::app.case-study-categories.form.description')
					</x-admin::form.control-group.label>

					<x-admin::form.control-group.control type="textarea" id="description"
						name="description"
						:value="old('description') ?? ($caseStudyCategory?->description ?? '')"
						:label="trans('cms::app.case-study-categories.form.description')" />

					<x-admin::form.control-group.error control-name="description" />
				</x-admin::form.control-group>

				<x-admin::form.control-group class="!mb-0">
					<x-admin::form.control-group.label>
						@lang('cms::app.case-study-categories.form.active')
					</x-admin::form.control-group.label>

					<label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-300">
						<input type="checkbox" name="is_active" value="1"
							class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
							@checked(old('is_active', $caseStudyCategory?->is_active ?? true))
						/>
						<span>@lang('cms::app.case-study-categories.form.active')</span>
					</label>

					<x-admin::form.control-group.error control-name="is_active" />
				</x-admin::form.control-group>
			</div>
		</div>
	</div>
</div>
