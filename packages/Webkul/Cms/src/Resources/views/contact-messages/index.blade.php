@php($companyParams = $activeCompanyId ? ['company_id' => $activeCompanyId] : [])

<x-cms::index-with-company-tabs
    :page-title="__('cms::app.contact-messages.index.title')"
    breadcrumb-name="cms.contact-messages"
    :datagrid-src="route('admin.cms.contact-messages.index', $companyParams)"
    :companies="$companies"
    :active-company-id="$activeCompanyId"
    :show-create="false"
/>
