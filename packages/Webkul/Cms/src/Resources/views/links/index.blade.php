@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.links.index.title')"
    breadcrumb-name="cms.links"
    :create-route="route('admin.cms.links.create', $companyParams)"
    :create-btn-label="__('cms::app.links.index.create-btn')"
    :datagrid-src="route('admin.cms.links.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
