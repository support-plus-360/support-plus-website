@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.services.index.title')"
    breadcrumb-name="cms.services"
    :create-route="route('admin.cms.services.create', $companyParams)"
    :create-btn-label="__('cms::app.services.index.create-btn')"
    :datagrid-src="route('admin.cms.services.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
