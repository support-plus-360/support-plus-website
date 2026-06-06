@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.sections.index.title')"
    breadcrumb-name="cms.sections"
    :create-route="route('admin.cms.sections.create', $companyParams)"
    :create-btn-label="__('cms::app.sections.index.create-btn')"
    :datagrid-src="route('admin.cms.sections.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
