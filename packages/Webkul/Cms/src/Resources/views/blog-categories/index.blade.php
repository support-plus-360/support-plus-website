@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.blog-categories.index.title')"
    breadcrumb-name="cms.blog-categories"
    :create-route="route('admin.cms.blog-categories.create', $companyParams)"
    :create-btn-label="__('cms::app.blog-categories.index.create-btn')"
    :datagrid-src="route('admin.cms.blog-categories.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
