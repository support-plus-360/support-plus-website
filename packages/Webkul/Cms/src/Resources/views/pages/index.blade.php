@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.pages.index.title')"
    breadcrumb-name="cms.pages"
    :create-route="route('admin.cms.pages.create', $companyParams)"
    :create-btn-label="__('cms::app.pages.index.create-btn')"
    :datagrid-src="route('admin.cms.pages.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
