<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\Page;
use Webkul\Cms\Models\PageTranslation;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homePage = Page::create([
            'slug' => 'home',
            'name' => 'Home',
            'is_active' => true,
            'order' => 1,
            'company_id' => 1,
        ]);

	// page translation 
	PageTranslation::create([
	'cms_page_id'=>$homePage->id,
	'locale'=>'en',
	'title'=>'Home Page',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);

	PageTranslation::create([
	'cms_page_id'=>$homePage->id,
	'locale'=>'ar',
	'title'=>'الصفحة الرئيسية',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);



        $healthcarePage = Page::create([
            'slug' => 'healthcare',
            'name' => 'Health Care',
            'is_active' => true,
            'order' => 2,
            'company_id' => 1,
        ]);

	PageTranslation::create([
	'cms_page_id'=>$healthcarePage->id,
	'locale'=>'en',
	'title'=>'Health Care',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	PageTranslation::create([
	'cms_page_id'=>$healthcarePage->id,
	'locale'=>'ar',
	'title'=>'الرعاية الصحية',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);


        $digitalMarketingPage = Page::create([
            'slug' => 'digital-marketing',
            'name' => 'Digital Marketing',
            'is_active' => true,
            'order' => 3,
            'company_id' => 1,
        ]);

	PageTranslation::create([
	'cms_page_id'=>$digitalMarketingPage->id,
	'locale'=>'en',
	'title'=>'Digital Marketing',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	PageTranslation::create([
	'cms_page_id'=>$digitalMarketingPage->id,
	'locale'=>'ar',
	'title'=>'التسويق الرقمي',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	$softwareHousePage = Page::create([
            'slug' => 'software-house',
            'name' => 'Software House',
            'is_active' => true,
            'order' => 4,
            'company_id' => 1,
        ]);

	PageTranslation::create([
	'cms_page_id'=>$softwareHousePage->id,
	'locale'=>'en',
	'title'=>'Software House',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	PageTranslation::create([
	'cms_page_id'=>$softwareHousePage->id,
	'locale'=>'ar',
	'title'=>'منزل البرمجيات',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);

	// --------------------------

	$callCenterPage = Page::create([
            'slug' => 'call-center',
            'name' => 'Call Center',
            'is_active' => true,
            'order' => 5,
            'company_id' => 1,
        ]);

	PageTranslation::create([
	'cms_page_id'=>$callCenterPage->id,
	'locale'=>'en',
	'title'=>'Call Center',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	PageTranslation::create([
	'cms_page_id'=>$callCenterPage->id,
	'locale'=>'ar',
	'title'=>'مركز الاتصال',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	// --------------------------

	$servicesPage = Page::create([
            'slug' => 'services',
            'name' => 'All services',
            'is_active' => true,
            'order' => 6,
            'company_id' => 1,
        ]);

	PageTranslation::create([
	'cms_page_id'=>$servicesPage->id,
	'locale'=>'en',
	'title'=>'All services',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	PageTranslation::create([
	'cms_page_id'=>$servicesPage->id,
	'locale'=>'ar',
	'title'=>'جميع الخدمات',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	// --------------------------

	$caseStudiesPage = Page::create([
            'slug' => 'case-studies',
            'name' => 'Case Studies',
            'is_active' => true,
            'order' => 7,
            'company_id' => 1,
        ]);

	PageTranslation::create([
	'cms_page_id'=>$caseStudiesPage->id,
	'locale'=>'en',
	'title'=>'Case Studies',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	PageTranslation::create([
	'cms_page_id'=>$caseStudiesPage->id,
	'locale'=>'ar',
	'title'=>'الدراسات الميدانية',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	// --------------------------

	$contactPage = Page::create([
            'slug' => 'contact',
            'name' => 'Contact',
            'is_active' => true,
            'order' => 8,
            'company_id' => 1,
        ]);

	PageTranslation::create([
	'cms_page_id'=>$contactPage->id,
	'locale'=>'en',
	'title'=>'Contact',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
	
	PageTranslation::create([
	'cms_page_id'=>$contactPage->id,
	'locale'=>'ar',
	'title'=>'اتصل بنا',
	'meta_description'=>'',
	'meta_keywords'=>'',
	]);
    }
}
