@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.items.index.title')"
    breadcrumb-name="cms.items"
    :create-route="route('admin.cms.items.create', $companyParams)"
    :create-btn-label="__('cms::app.items.index.create-btn')"
    :datagrid-src="route('admin.cms.items.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
