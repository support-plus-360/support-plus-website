@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.case-studies.index.title')"
    breadcrumb-name="cms.case-studies"
    :create-route="route('admin.cms.case-studies.create', $companyParams)"
    :create-btn-label="__('cms::app.case-studies.index.create-btn')"
    :datagrid-src="route('admin.cms.case-studies.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
