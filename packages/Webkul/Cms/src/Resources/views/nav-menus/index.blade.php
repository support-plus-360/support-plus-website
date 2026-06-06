@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.nav-menus.index.title')"
    breadcrumb-name="cms.nav-menus"
    :create-route="route('admin.cms.nav-menus.create', $companyParams)"
    :create-btn-label="__('cms::app.nav-menus.index.create-btn')"
    :datagrid-src="route('admin.cms.nav-menus.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
