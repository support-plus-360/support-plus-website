<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\ServiceType;
use Webkul\Cms\Models\Service;
use Webkul\Cms\Models\ServiceTranslation;

class CmsServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//         service 1
	// service type 1
        $serviceType1 = ServiceType::create([
	'name' => 'Financial Precision',
            'is_active' => true,
            'company_id' => 2,
        ]);

	$serviceType2 = ServiceType::create([
	'name' => 'HR Solutions',
		'is_active' => true,
		'company_id' => 2,
	]);


        // service 1
        $service1 = Service::create([
            'cms_service_type_id' => $serviceType1->id,
	  'name' => 'Bookkeeping & VAT Filing',
	  'slug' => 'bookkeeping-and-vat-filing',
            'company_id' => 2,	
            'is_active' => true,
        ]);


	// service translation 1
	ServiceTranslation::create([
		'cms_service_id' => $service1->id,
		'locale' => 'en',
		'title' => 'Bookkeeping & VAT Filing',
		'sub_title' => 'Daily transactions, e-invoicing, quarterly VAT returns',
		'problems' => 'Hands-on finance services that improve control, visibility, and confidence across healthcare operations.',
		'solutions' => 'Hands-on finance services that improve control, visibility, and confidence across healthcare operations.',
		'key_benefits' => 'Hands-on finance services that improve control, visibility, and confidence across healthcare operations.',
		'deliverables' => 'Hands-on finance services that improve control, visibility, and confidence across healthcare operations.',
	]);
	ServiceTranslation::create([
		'cms_service_id' => $service1->id,
		'locale' => 'ar',
		'title' => 'الحسابات وتقديم القيمة المضافة السنوية',
		'sub_title' => 'المعاملات اليومية، الفواتير الإلكترونية، تقديم القيمة المضافة السنوية',
		'problems' => 'المعاملات اليومية، الفواتير الإلكترونية، تقديم القيمة المضافة السنوية',
		'solutions' => 'المعاملات اليومية، الفواتير الإلكترونية، تقديم القيمة المضافة السنوية',
		'key_benefits' => 'المعاملات اليومية، الفواتير الإلكترونية، تقديم القيمة المضافة السنوية',
		'deliverables' => 'المعاملات اليومية، الفواتير الإلكترونية، تقديم القيمة المضافة السنوية',
	]);


	// service 2
	$service2 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Feasibility Studies',
		'slug' => 'feasibility-studies',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 2
	ServiceTranslation::create([
		'cms_service_id' => $service2->id,
		'locale' => 'en',
		'title' => 'Feasibility Studies',
		'sub_title' => 'Market analysis, demand forecasting, break-even timelines',
		'problems' => 'Market research, financial analysis, and feasibility report',
		'solutions' => 'Market research, financial analysis, and feasibility report',
		'key_benefits' => 'Market research, financial analysis, and feasibility report',
		'deliverables' => 'Market research, financial analysis, and feasibility report',
	]);
	ServiceTranslation::create([
		'cms_service_id' => $service2->id,
		'locale' => 'ar',
		'title' => 'دراسات الجدوى',
		'sub_title' => 'تحليل السوق، توقعات الطلب، خطوط التعادل',
		'problems' => 'تحليل السوق، توقعات الطلب، خطوط التعادل',
		'solutions' => 'تحليل السوق، توقعات الطلب، خطوط التعادل',
		'key_benefits' => 'تحليل السوق، توقعات الطلب، خطوط التعادل',
		'deliverables' => 'تحليل السوق، توقعات الطلب، خطوط التعادل',
	]);
	
	// service 3
	$service3 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Financial Modeling',
		'slug' => 'financial-modeling',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 3
	ServiceTranslation::create([
		'cms_service_id' => $service3->id,
		'locale' => 'en',
		'title' => 'Financial Modeling',
		'sub_title' => 'Scenario models for revenue, payor mix, staffing',
		'problems' => 'Financial projections, sensitivity analysis, scenario planning',
		'solutions' => 'Financial projections, sensitivity analysis, scenario planning',
		'key_benefits' => 'Financial projections, sensitivity analysis, scenario planning',
		'deliverables' => 'Financial projections, sensitivity analysis, scenario planning',
	]);
	
	ServiceTranslation::create([
		'cms_service_id' => $service3->id,
		'locale' => 'ar',
		'title' => 'النماذج المالية',
		'sub_title' => 'النماذج المالية للإيرادات، المزيج المدفوع، الموظفين',
		'problems' => 'النماذج المالية للإيرادات، المزيج المدفوع، الموظفين',
		'solutions' => 'النماذج المالية للإيرادات، المزيج المدفوع، الموظفين',
		'key_benefits' => 'النماذج المالية للإيرادات، المزيج المدفوع، الموظفين',
		'deliverables' => 'النماذج المالية للإيرادات، المزيج المدفوع، الموظفين',
	]);


	// service 4
	$service4 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Profitability Analysis',
		'slug' => 'profitability-analysis',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 4
	ServiceTranslation::create([
		'cms_service_id' => $service4->id,
		'locale' => 'en',
		'title' => 'Profitability Analysis',
		'sub_title' => 'Department-level margins by specialty & procedure',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);
	ServiceTranslation::create([
		'cms_service_id' => $service4->id,
		'locale' => 'ar',
		'title' => 'تحليل الربحية',
		'sub_title' => 'الربحية في المختبرات الطبية',
		'problems' => 'الربحية في المختبرات الطبية',
		'solutions' => 'الربحية في المختبرات الطبية',
		'key_benefits' => 'الربحية في المختبرات الطبية',
		'deliverables' => 'الربحية في المختبرات الطبية',
	]);


	// service 5
	$service5 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Virtual CFO',
		'slug' => 'virtual-cfo',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 5
	ServiceTranslation::create([
		'cms_service_id' => $service5->id,
		'locale' => 'en',
		'title' => 'Virtual CFO',
		'sub_title' => 'Monthly reporting, cash flow, KPIs, strategic guidance',
		'problems' => 'Financial activity supported',
		'solutions' => 'Financial activity supported',
		'key_benefits' => 'Financial activity supported',
		'deliverables' => 'Financial activity supported',
	]);
	ServiceTranslation::create([
		'cms_service_id' => $service5->id,
		'locale' => 'ar',
		'title' => 'المدير المالي الافتراضي',
		'sub_title' => 'التقارير الشهرية، التدفق النقدي، المقاييس الرئيسية، الإرشادات الاستراتيجية',
		'problems' => 'النشاط المالي المدعوم بالتنظيم المالي الدورة المالية',
		'solutions' => 'النشاط المالي المدعوم بالتنظيم المالي الدورة المالية',
		'key_benefits' => 'النشاط المالي المدعوم بالتنظيم المالي الدورة المالية',
		'deliverables' => 'النشاط المالي المدعوم بالتنظيم المالي الدورة المالية',
	]);


	// service 6
	$service6 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Financial Planning & Budgeting',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 6
	ServiceTranslation::create([
		'cms_service_id' => $service6->id,
		'locale' => 'en',
		'title' => 'Financial Planning & Budgeting',
		'sub_title' => 'Strategic budget planning aligned with expansion targets, staffing realities, and margin goals',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);
	ServiceTranslation::create([
		'cms_service_id' => $service6->id,
		'locale' => 'ar',
		'title' => 'التخطيط المالي والميزانية',
		'sub_title' => 'التخطيط الاستراتيجي للميزانية متوافق مع أهداف التوسع، الواقع الموظفين، وهامش المركز',
		'problems' => 'التقارير المالية المدعومة بالتحكم',
		'solutions' => 'التقارير المالية المدعومة بالتحكم',
		'key_benefits' => 'التقارير المالية المدعومة بالتحكم',
		'deliverables' => 'التقارير المالية المدعومة بالتحكم',
	]);


	// service 7
	$service7 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Business Valuation',
		'slug' => 'business-valuation',
		'company_id' => 2,	
		'is_active' => true,
	]);
	
	// service translation 7
	ServiceTranslation::create([
		'cms_service_id' => $service7->id,
		'locale' => 'en',
		'title' => 'Business Valuation',
		'sub_title' => 'SOCPA-aligned for partnerships, investment, exit',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);
	ServiceTranslation::create([
		'cms_service_id' => $service7->id,
		'locale' => 'ar',
		'title' => 'تقييم الأعمال',
		'sub_title' => 'متوافق مع SOCPA للشراكات، الاستثمار، الخروج',
		'problems' => 'عمليات القيمة المضافة الواضحة، التقديم المنظم للمستندات، ودعم التقارير',
		'solutions' => 'عمليات القيمة المضافة الواضحة، التقديم المنظم للمستندات، ودعم التقارير',
		'key_benefits' => 'عمليات القيمة المضافة الواضحة، التقديم المنظم للمستندات، ودعم التقارير',
		'deliverables' => 'عمليات القيمة المضافة الواضحة، التقديم المنظم للمستندات، ودعم التقارير',
	]);


	// service 8
	$service8 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Internal Audit',
		'slug' => 'internal-audit',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 8
	ServiceTranslation::create([
		'cms_service_id' => $service8->id,
		'locale' => 'en',
		'title' => 'Internal Audit',
		'sub_title' => 'Controls review, billing accuracy, fraud prevention',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);
	ServiceTranslation::create([
		'cms_service_id' => $service8->id,
		'locale' => 'ar',
		'title' => 'المراجعة الداخلية',
		'sub_title' => 'مراجعة التحكم، دقة الفواتير، منع الاحتيال',
		'problems' => 'المراجعة المرتبطة بالامتثال للكفاءة العملية',
		'solutions' => 'المراجعة المرتبطة بالامتثال للكفاءة العملية',
		'key_benefits' => 'المراجعة المرتبطة بالامتثال للكفاءة العملية',
		'deliverables' => 'المراجعة المرتبطة بالامتثال للكفاءة العملية',
	]);
	


	// service 9
	$service9 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Financial Statements Prep',
		'slug' => 'financial-statements-prep',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 9
	ServiceTranslation::create([
		'cms_service_id' => $service9->id,
		'locale' => 'en',
		'title' => 'Financial Statements Prep',
		'sub_title' => 'IFRS-compliant P&L, balance sheet, cash flow',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);

	ServiceTranslation::create([
		'cms_service_id' => $service9->id,
		'locale' => 'ar',
		'title' => 'تحضير البيانات المالية',
		'sub_title' => 'موافقة IFRS للبيانات المالية',
		'problems' => 'التقارير المالية المستعدة للإدارة التي تحول بيانات العمليات إلى معلومات قابلة للتطبيق.',
		'solutions' => 'التقارير المالية المستعدة للإدارة التي تحول بيانات العمليات إلى معلومات قابلة للتطبيق.',
		'key_benefits' => 'التقارير المالية المستعدة للإدارة التي تحول بيانات العمليات إلى معلومات قابلة للتطبيق.',
		'deliverables' => 'التقارير المالية المستعدة للإدارة التي تحول بيانات العمليات إلى معلومات قابلة للتطبيق.',
	]);
	

	// service 10
	$service10 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Zakat & Tax Review',
		'slug' => 'zakat-and-tax-review',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 10
	ServiceTranslation::create([
		'cms_service_id' => $service10->id,
		'locale' => 'en',
		'title' => 'Zakat & Tax Review',
		'sub_title' => 'Zakat base calculations, ZATCA communications',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);
	ServiceTranslation::create([
		'cms_service_id' => $service10->id,
		'locale' => 'ar',
		'title' => 'مراجعة الضرائب والذكرى ' ,
		'sub_title' => 'حسابات الذكرى الأساسية، الاتصالات الضريبية ل ZATCA',
		'problems' => 'المراجعة المرتبطة بالامتثال للضرائب الاسلامية',
		'solutions' => 'المراجعة المرتبطة بالامتثال للضرائب الاسلامية',
		'key_benefits' => 'المراجعة المرتبطة بالامتثال للضرائب الاسلامية',
		'deliverables' => 'المراجعة المرتبطة بالامتثال للضرائب الاسلامية',
	]);


	// service 11
	$service11 = Service::create([
		'cms_service_type_id' => $serviceType1->id,
		'name' => 'Payroll',
		'slug' => 'payroll',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 11
	ServiceTranslation::create([
		'cms_service_id' => $service11->id,
		'locale' => 'en',
		'title' => 'Payroll',
		'sub_title' => 'GOSI, WPS, leave calculations, end-of-service benefits',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);
	ServiceTranslation::create([
		'cms_service_id' => $service11->id,
		'locale' => 'ar',
		'title' => 'الرواتب',
		'sub_title' => 'GOSI، WPS، حسابات الإجازات، فوائد خروج الخدمة',
		'problems' => 'الرواتب المستعدة للإدارة التي تحول بيانات العمليات إلى معلومات قابلة للتطبيق.',
		'solutions' => 'الرواتب المستعدة للإدارة التي تحول بيانات العمليات إلى معلومات قابلة للتطبيق.',
		'key_benefits' => 'الرواتب المستعدة للإدارة التي تحول بيانات العمليات إلى معلومات قابلة للتطبيق.',
		'deliverables' => 'الرواتب المستعدة للإدارة التي تحول بيانات العمليات إلى معلومات قابلة للتطبيق.',
	]);
	

	// HR Solutions service 12
	$service12 = Service::create([
		'cms_service_type_id' => $serviceType2->id,
		'name' => 'Compliance',
		'slug' => 'compliance',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 12
	ServiceTranslation::create([
		'cms_service_id' => $service12->id,
		'locale' => 'en',
		'title' => 'Compliance',
		'sub_title' => 'Labor law adherence, MOL requirements, Saudization (Nitaqat) quotas, workplace safety regulations for healthcare',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);

	ServiceTranslation::create([
		'cms_service_id' => $service12->id,
		'locale' => 'ar',
		'title' => 'الامتثال',
		'sub_title' => 'الامتثال لقواعد العمل، متطلبات MOL، عدد السعودة المخصص للإشراف على العمل في الطب الصحي',
		'solutions' => 'التوظيف المرتبط بالامتثال للكفاءة العملية',
		'key_benefits' => 'التوظيف المرتبط بالامتثال للكفاءة العملية',
		'deliverables' => 'التوظيف المرتبط بالامتثال للكفاءة العملية',
	]);


	// HR Solutions service 13
	$service13 = Service::create([
		'cms_service_type_id' => $serviceType2->id,
		'name' => 'Organization Development (OD)',
		'slug' => 'organization-development-od',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 13
	ServiceTranslation::create([
		'cms_service_id' => $service13->id,
		'locale' => 'en',
		'title' => 'Organization Development (OD)',
		'sub_title' => 'Org structure design, change management, leadership development programs for growing medical centers',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);

	ServiceTranslation::create([
		'cms_service_id' => $service13->id,
		'locale' => 'ar',
		'title' => 'تطوير المؤسسة (OD)',
		'sub_title' => 'تصميم بنية المؤسسة، إدارة التغييرات، برامج تطوير القيادة لمراكز الطب المركزة',
		'problems' => 'التطوير المرتبط بالامتثال للكفاءة العملية',
		'solutions' => 'التطوير المرتبط بالامتثال للكفاءة العملية',
		'key_benefits' => 'التطوير المرتبط بالامتثال للكفاءة العملية',
		'deliverables' => 'التطوير المرتبط بالامتثال للكفاءة العملية',
	]);
	




	// HR Solutions service 14
	$service14 = Service::create([
		'cms_service_type_id' => $serviceType2->id,
		'name' => 'Recruitment',
		'slug' => 'recruitment',
		'company_id' => 2,	
		'is_active' => true,
	]);

	// service translation 14
	ServiceTranslation::create([
		'cms_service_id' => $service14->id,
		'locale' => 'en',
		'title' => 'Recruitment',
		'sub_title' => 'End-to-end healthcare talent acquisition — physicians, nurses, admin staff — with licensure & credentialing support',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);

	ServiceTranslation::create([
		'cms_service_id' => $service14->id,
		'locale' => 'ar',
		'title' => 'التوظيف',
		'sub_title' => 'التوظيف المرتبط بالامتثال للكفاءة العملية',
		'problems' => 'التوظيف المرتبط بالامتثال للكفاءة العملية',
		'solutions' => 'التوظيف المرتبط بالامتثال للكفاءة العملية',
		'key_benefits' => 'التوظيف المرتبط بالامتثال للكفاءة العملية',
		'deliverables' => 'التوظيف المرتبط بالامتثال للكفاءة العملية',
	]);
	


	// HR Solutions service 15
	$service15 = Service::create([
		'cms_service_type_id' => $serviceType2->id,
		'name' => 'Performance Management',
		'slug' => 'performance-management',
		'company_id' => 2,	
		'is_active' => true,
	]);
	
	// service translation 15
	ServiceTranslation::create([
		'cms_service_id' => $service15->id,
		'locale' => 'en',
		'title' => 'Performance Management',
		'sub_title' => 'KPI frameworks, appraisal systems, 360-degree feedback, and productivity tracking for clinical & non-clinical staff',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);

	ServiceTranslation::create([
		'cms_service_id' => $service15->id,
		'locale' => 'ar',
		'title' => 'إدارة الأداء',
		'sub_title' => 'إطارات KPI، أنظمة التقييم، التقييم الشامل 360 درجة، وتتبع الإنتاجية للموظفين الطبيين والغير الطبيين',
		'problems' => 'الأداء المرتبط بالامتثال للكفاءة العملية',
		'solutions' => 'الأداء المرتبط بالامتثال للكفاءة العملية',
		'key_benefits' => 'الأداء المرتبط بالامتثال للكفاءة العملية',
		'deliverables' => 'الأداء المرتبط بالامتثال للكفاءة العملية',
	]);


	// HR Solutions service 16
	$service16 = Service::create([
		'cms_service_type_id' => $serviceType2->id,
		'name' => 'HR Policy & Procedures',
		'slug' => 'hr-policy-and-procedures',
		'company_id' => 2,	
		'is_active' => true,
	]);
	
	
	// service translation 15
	ServiceTranslation::create([
		'cms_service_id' => $service16->id,
		'locale' => 'en',
		'title' => 'HR Policy & Procedures',
		'sub_title' => 'Employee handbooks, disciplinary procedures, leave management, and workplace policies compliant with Saudi labor law',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);

	ServiceTranslation::create([
		'cms_service_id' => $service16->id,
		'locale' => 'ar',
		'title' => 'السياسات والإجراءات الموظفين',
		'sub_title' => 'كتب الموظفين، إجراءات التنبيه، إدارة الإجازات، وسياسات العمل المتوافقة مع قواعد العمل السعودي',
		'problems' => 'السياسات والإجراءات الموظفين المرتبطة بالامتثال للكفاءة العملية',
		'solutions' => 'السياسات والإجراءات الموظفين المرتبطة بالامتثال للكفاءة العملية',
		'key_benefits' => 'السياسات والإجراءات الموظفين المرتبطة بالامتثال للكفاءة العملية',
		'deliverables' => 'السياسات والإجراءات الموظفين المرتبطة بالامتثال للكفاءة العملية',
	]);



	// HR Solutions service 17
	$service17 = Service::create([
		'cms_service_type_id' => $serviceType2->id,
		'name' => 'Compensation & Benefits',
		'slug' => 'compensation-and-benefits',
		'company_id' => 2,	
		'is_active' => true,
	]);
	
	
	// service translation 17
	ServiceTranslation::create([
		'cms_service_id' => $service17->id,
		'locale' => 'en',
		'title' => 'Compensation & Benefits',
		'sub_title' => 'Salary benchmarking, benefits structuring, GOSI optimization, and total rewards strategy for healthcare workforce',
		'problems' => 'Financial reporting, management reporting, financial reporting',
		'solutions' => 'Financial reporting, management reporting, financial reporting',
		'key_benefits' => 'Financial reporting, management reporting, financial reporting',
		'deliverables' => 'Financial reporting, management reporting, financial reporting',
	]);

	ServiceTranslation::create([
		'cms_service_id' => $service17->id,
		'locale' => 'ar',
		'title' => 'المرتبات والفوائد',
		'sub_title' => 'مقارنة المرتبات، بنية الفوائد، تحسين GOSI، واستراتيجية المكافآت الكلية لعمالة الطب الصحي',
		'problems' => 'المرتبات والفوائد المرتبطة بالامتثال للكفاءة العملية',
		'solutions' => 'المرتبات والفوائد المرتبطة بالامتثال للكفاءة العملية',
		'key_benefits' => 'المرتبات والفوائد المرتبطة بالامتثال للكفاءة العملية',
		'deliverables' => 'المرتبات والفوائد المرتبطة بالامتثال للكفاءة العملية',
	]);


    }
}
