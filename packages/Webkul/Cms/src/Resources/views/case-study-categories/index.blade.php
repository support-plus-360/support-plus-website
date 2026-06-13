@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.case-study-categories.index.title')"
    breadcrumb-name="cms.case-study-categories"
    :create-route="route('admin.cms.case-study-categories.create', $companyParams)"
    :create-btn-label="__('cms::app.case-study-categories.index.create-btn')"
    :datagrid-src="route('admin.cms.case-study-categories.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
