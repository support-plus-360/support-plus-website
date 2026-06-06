@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.blog-posts.index.title')"
    breadcrumb-name="cms.blog-posts"
    :create-route="route('admin.cms.blog-posts.create', $companyParams)"
    :create-btn-label="__('cms::app.blog-posts.index.create-btn')"
    :datagrid-src="route('admin.cms.blog-posts.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
/>
