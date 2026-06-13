<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\CaseStudy;
use Webkul\Cms\Models\CaseStudyCategory;
use Webkul\Cms\Models\CaseStudyTranslation;

class CmsCaseStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//         case study 1
	// case study category 1
        $caseStudyCategory1 = CaseStudyCategory::create([
            'name' => 'Case Study Category 1',
            'is_active' => true,
            'company_id' => 1,
        ]);
        // case study 1
        $caseStudy1 = CaseStudy::create([
            'cms_case_study_category_id' => $caseStudyCategory1->id,
            'city' => 'City 1',
            'slug' => 'case-study-1',
            'kpis' => [
                [
                    'key' => 'KPI 1',
                    'value' => 'Value 1',
                ],
                [
                    'key' => 'KPI 2',
                    'value' => 'Value 2',
                ],
                [
                    'key' => 'KPI 3',
                    'value' => 'Value 3',
                ],
            ],
            'rate' => 100,
            'company_id' => 2,	
            'is_active' => true,
            'is_featured' => false,
            'order' => 1,
        ]);
	// case study translation 1
	CaseStudyTranslation::create([
		'cms_case_study_id' => $caseStudy1->id,
		'locale' => 'en',
		'title' => 'Case Study 1',
		'sub_title' => 'Sub Title 1',
		'content' => 'Content 1',
		'challenges' => 'Challenges 1',
		'solutions' => 'Solutions 1',
	]);
	CaseStudyTranslation::create([
		'cms_case_study_id' => $caseStudy1->id,
		'locale' => 'ar',
		'title' => 'Case Study 1',
		'sub_title' => 'Sub Title 1',
		'content' => 'Content 1',
		'challenges' => 'Challenges 1',
		'solutions' => 'Solutions 1',
	]);


	$caseStudy2 = CaseStudy::create([
		'cms_case_study_category_id' => $caseStudyCategory1->id,
		'city' => 'City 2',
		'slug' => 'case-study-2',
		'kpis' => [
			[
				'key' => 'KPI 1',
				'value' => 'Value 1',
			],
		],
		'rate' => 100,
		'company_id' => 2,
		'is_active' => true,
		'is_featured' => false,
		'order' => 2,
	]);
	// case study translation 2
	CaseStudyTranslation::create([
		'cms_case_study_id' => $caseStudy2->id,
		'locale' => 'en',
		'title' => 'Case Study 2',
		'sub_title' => 'Sub Title 2',
		'content' => 'Content 2',
		'challenges' => 'Challenges 2',
		'solutions' => 'Solutions 2',
	]);
	CaseStudyTranslation::create([
		'cms_case_study_id' => $caseStudy2->id,
		'locale' => 'ar',
		'title' => 'Case Study 2',
		'sub_title' => 'Sub Title 2',
		'content' => 'Content 2',
		'challenges' => 'Challenges 2',
		'solutions' => 'Solutions 2',
	]);


	// case study 3
	$caseStudy3 = CaseStudy::create([
		'cms_case_study_category_id' => $caseStudyCategory1->id,
		'city' => 'City 3',
		'slug' => 'case-study-3',
		'kpis' => [
			[
				'key' => 'KPI 1',
				'value' => 'Value 1',
			],
		],
		'rate' => 100,
		'company_id' => 2,
		'is_active' => true,
		'is_featured' => true,
		'order' => 3,
	]);
	// case study translation 3
	CaseStudyTranslation::create([
		'cms_case_study_id' => $caseStudy3->id,
		'locale' => 'en',
		'title' => 'Case Study 3',
		'sub_title' => 'Sub Title 3',
		'content' => 'Content 3',
		'challenges' => 'Challenges 3',
		'solutions' => 'Solutions 3',
	]);
	CaseStudyTranslation::create([
		'cms_case_study_id' => $caseStudy3->id,
		'locale' => 'ar',
		'title' => 'Case Study 3',
		'sub_title' => 'Sub Title 3',
		'content' => 'Content 3',
		'challenges' => 'Challenges 3',
		'solutions' => 'Solutions 3',
	]);



	// case study 4
	$caseStudy4 = CaseStudy::create([
		'cms_case_study_category_id' => $caseStudyCategory1->id,
		'city' => 'City 4',
		'slug' => 'case-study-4',
		'kpis' => [
			[
				'key' => 'KPI 1',
				'value' => 'Value 1',
			],
		],
		'rate' => 100,
		'company_id' => 2,
		'is_active' => true,
		'is_featured' => true,
		'order' => 4,
	]);
	// case study translation 4
	CaseStudyTranslation::create([
		'cms_case_study_id' => $caseStudy4->id,	
		'locale' => 'en',
		'title' => 'Case Study 4',
		'sub_title' => 'Sub Title 4',
		'content' => 'Content 4',
		'challenges' => 'Challenges 4',
		'solutions' => 'Solutions 4',
	]);
	CaseStudyTranslation::create([
		'cms_case_study_id' => $caseStudy4->id,
		'locale' => 'ar',
		'title' => 'Case Study 4',
		'sub_title' => 'Sub Title 4',
		'content' => 'Content 4',
		'challenges' => 'Challenges 4',
		'solutions' => 'Solutions 4',
	]);
    }
}
