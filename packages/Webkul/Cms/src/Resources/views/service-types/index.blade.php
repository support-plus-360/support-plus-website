@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.service-types.index.title')"
    breadcrumb-name="cms.service-types"
    :create-route="route('admin.cms.service-types.create', $companyParams)"
    :create-btn-label="__('cms::app.service-types.index.create-btn')"
    :datagrid-src="route('admin.cms.service-types.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
