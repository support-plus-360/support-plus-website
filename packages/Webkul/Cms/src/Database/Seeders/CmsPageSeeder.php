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

	// support plus pages
	// home page
	$homePage = Page::create([
		'slug' => 'support-plus-home',
		'name' => 'Support Plus Home',
		'is_active' => true,
		'order' => 1,
		'company_id' => 1,
	]);

	// page translation
	PageTranslation::create([
		'cms_page_id'=>$homePage->id,
		'locale'=>'en',
		'title'=>'Support Plus Home',
		'meta_description'=>'',
		'meta_keywords'=>'',
	]);

	PageTranslation::create([
		'cms_page_id'=>$homePage->id,
		'locale'=>'ar',
		'title'=>'الرئيسية',
		'meta_description'=>'',
		'meta_keywords'=>'',
	]);

	// healthcare page
	$healthcarePage = Page::create([
		'slug' => 'support-plus-healthcare',
		'name' => 'Support Plus Healthcare',
		'is_active' => true,
		'order' => 2,
		'company_id' => 1,
	]);

	PageTranslation::create([
		'cms_page_id'=>$healthcarePage->id,
		'locale'=>'en',
		'title'=>'Support Plus Healthcare',
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
		'slug' => 'support-plus-digital-marketing',
		'name' => 'Support Plus Digital Marketing',
		'is_active' => true,
		'order' => 3,
		'company_id' => 1,
	]);

	PageTranslation::create([
		'cms_page_id'=>$digitalMarketingPage->id,
		'locale'=>'en',
		'title'=>'Support Plus Digital Marketing',
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
            'slug' => 'support-plus-software-house',
            'name' => 'Support Plus Software House',
            'is_active' => true,
            'order' => 4,
            'company_id' => 1,
          ]);

	PageTranslation::create([
		'cms_page_id'=>$softwareHousePage->id,
		'locale'=>'en',
		'title'=>'Support Plus Software House',
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
            'slug' => 'support-plus-call-center',
            'name' => 'Support Plus Call Center',
            'is_active' => true,
            'order' => 5,
            'company_id' => 1,
          ]);

	PageTranslation::create([
		'cms_page_id'=>$callCenterPage->id,
		'locale'=>'en',
		'title'=>'Support Plus Call Center',
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
            'slug' => 'support-plus-services',
            'name' => 'Support Plus Services',
            'is_active' => true,
            'order' => 6,
            'company_id' => 1,
        ]);

	PageTranslation::create([
	'cms_page_id'=>$servicesPage->id,
	'locale'=>'en',
	'title'=>'Support Plus Services',
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
            'slug' => 'support-plus-case-studies',
            'name' => 'Support Plus Case Studies',
            'is_active' => true,
            'order' => 7,
            'company_id' => 1,
        ]);

	PageTranslation::create([
        'cms_page_id'=>$caseStudiesPage->id,
        'locale'=>'en',
        'title'=>'Support Plus Case Studies',
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
            'slug' => 'support-plus-contact',
            'name' => 'Support Plus Contact',
            'is_active' => true,
            'order' => 8,
            'company_id' => 1,
        ]);

	PageTranslation::create([
        'cms_page_id'=>$contactPage->id,
        'locale'=>'en',
        'title'=>'Support Plus Contact',
        'meta_description'=>'',
        'meta_keywords'=>'',
	]);

	PageTranslation::create([
        'cms_page_id'=>$contactPage->id,
        'locale'=>'ar',
        'title'=>' اتصل بنا',
        'meta_description'=>'',
        'meta_keywords'=>'',
	]);



// -------------------------- end of support plus pages ----------------------------------

	// mena support plus pages
	$homePage = Page::create([
		'slug' => 'mena-support-home',
		'name' => 'Mena Support Home',
		'is_active' => true,
		'order' => 1,
		'company_id' => 2,
	]);

	PageTranslation::create([
		'cms_page_id'=>$homePage->id,
		'locale'=>'en',
		'title'=>'Home',
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

	// services page
	$servicesPage = Page::create([
		'slug' => 'mena-support-services',
		'name' => 'Mena Support Services',
		'is_active' => true,
		'order' => 2,
		'company_id' => 2,
	]);

	PageTranslation::create([
		'cms_page_id'=>$servicesPage->id,
		'locale'=>'en',
		'title'=>'Services',
		'meta_description'=>'',
		'meta_keywords'=>'',
	]);

	PageTranslation::create([
		'cms_page_id'=>$servicesPage->id,
		'locale'=>'ar',
		'title'=>'الخدمات',
		'meta_description'=>'',
		'meta_keywords'=>'',
	]);

    // mena case studies page
    $caseStudiesPage = Page::create([
		'slug' => 'mena-support-case-studies',
		'name' => 'Mena Support Case Studies',
		'is_active' => true,
		'order' => 3,
		'company_id' => 2,
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



    // about us page
    $aboutUsPage = Page::create([
		'slug' => 'mena-support-about-us',
		'name' => 'Mena Support About Us',
		'is_active' => true,
		'order' => 4,
		'company_id' => 2,
	]);

	PageTranslation::create([
		'cms_page_id'=>$aboutUsPage->id,
		'locale'=>'en',
		'title'=>'About Us',
		'meta_description'=>'',
		'meta_keywords'=>'',
	]);

	PageTranslation::create([
		'cms_page_id'=>$aboutUsPage->id,
		'locale'=>'ar',
		'title'=>'عن الشركة',
		'meta_description'=>'',
		'meta_keywords'=>'',
	]);


    // blog page
    $blogPage = Page::create([
		'slug' => 'mena-support-blog',
		'name' => 'Mena Support Blog',
		'is_active' => true,
		'order' => 5,
		'company_id' => 2,
	]);

	PageTranslation::create([
		'cms_page_id'=>$blogPage->id,
		'locale'=>'en',
		'title'=>'Blog',
		'meta_description'=>'',
		'meta_keywords'=>'',
	]);

	PageTranslation::create([
		'cms_page_id'=>$blogPage->id,
		'locale'=>'ar',
		'title'=>'المدونة',
		'meta_description'=>'',
		'meta_keywords'=>'',
	]);
    }
}