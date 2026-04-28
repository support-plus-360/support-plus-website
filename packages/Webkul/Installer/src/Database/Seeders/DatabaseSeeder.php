<?php

namespace Webkul\Installer\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Installer\Database\Seeders\Attribute\DatabaseSeeder as AttributeSeeder;
use Webkul\Installer\Database\Seeders\Core\DatabaseSeeder as CoreSeeder;
use Webkul\Installer\Database\Seeders\EmailTemplate\DatabaseSeeder as EmailTemplateSeeder;
use Webkul\Installer\Database\Seeders\Lead\DatabaseSeeder as LeadSeeder;
use Webkul\Installer\Database\Seeders\User\DatabaseSeeder as UserSeeder;
use Webkul\Installer\Database\Seeders\Workflow\DatabaseSeeder as WorkflowSeeder;
use Webkul\Company\Database\Seeders\CompanySeeder as CompanySeeder;
use Webkul\Cms\Database\Seeders\CmsBlogCategorySeeder;
use Webkul\Cms\Database\Seeders\CmsBlogPostSeeder;
use Webkul\Cms\Database\Seeders\CmsPageSeeder;
use Webkul\Cms\Database\Seeders\CmsSectionSeeder;
use Webkul\Cms\Database\Seeders\CmsItemSeeder;
use Webkul\Cms\Database\Seeders\CmsLinkSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @param  array  $parameters
     * @return void
     */
    public function run($parameters = [])
    {
        $this->call(AttributeSeeder::class, false, ['parameters' => $parameters]);
        $this->call(CoreSeeder::class, false, ['parameters' => $parameters]);
        $this->call(EmailTemplateSeeder::class, false, ['parameters' => $parameters]);
        $this->call(LeadSeeder::class, false, ['parameters' => $parameters]);
        $this->call(UserSeeder::class, false, ['parameters' => $parameters]);
        $this->call(WorkflowSeeder::class, false, ['parameters' => $parameters]);
        $this->call(CompanySeeder::class, false, ['parameters' => $parameters]);
        $this->call(CmsBlogCategorySeeder::class, false, ['parameters' => $parameters]);
        $this->call(CmsBlogPostSeeder::class, false, ['parameters' => $parameters]);
        $this->call(CmsPageSeeder::class, false, ['parameters' => $parameters]);
        $this->call(CmsSectionSeeder::class, false, ['parameters' => $parameters]);
        $this->call(CmsItemSeeder::class, false, ['parameters' => $parameters]);
        $this->call(CmsLinkSeeder::class, false, ['parameters' => $parameters]);
    }
}
