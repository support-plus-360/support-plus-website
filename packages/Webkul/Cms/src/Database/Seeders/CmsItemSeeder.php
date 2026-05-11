<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\Item;
use Webkul\Cms\Models\ItemTranslation;
use Webkul\Cms\Models\Section;

class CmsItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homeSection2 = Section::where('name', 'Home Page Section 2')->first();
        $homeSection2Item1 = Item::create([
            'section_id' => $homeSection2->id,
            'type' => 'default',
            'settings' => null,
            'order' => 1,
            'company_id' => 1,
        ]);

	 ItemTranslation::create([
	'cms_item_id'=>$homeSection2Item1->id,
	'locale'=>'en',
	'title'=>'Patient Trust Deficit',
	'sub_title'=>"",
	'content'=>'Lack of digital presence and patient testimonials leads to lower trust and reduced patient acquisition through word-of-mouth.',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection2Item1->id,
	'locale'=>'ar',
	'title'=>'نقص الثقة المرضي',
	'sub_title'=>'',
	'content'=>'عدم وجود وجود على الانترنت وتقييمات المرضى يؤدي إلى خفض الثقة وتقليل الحصول على المرضى من خلال الكلمة العتيقة.',
	]);

// --------------------------

	$homeSection2Item2 = Item::create([
		'section_id' => $homeSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection2Item2->id,
	'locale'=>'en',
	'title'=>'Flow Inefficiency',
	'sub_title'=>"",
	'content'=>'Manual processes, scheduling conflicts, and disorganized patient management systems drain resources without maximizing capacity.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection2Item2->id,
	'locale'=>'ar',
	'title'=>'عدم الكفاءة في التدفق',
	'sub_title'=>'',
	'content'=>'عمليات يدوية، تضارب الجداول، وأنظمة مديرية المرضى غير منظمة تستهلك الموارد دون تحقيق الحد الأقصى من السعة.',
	]);

// --------------------------

	$homeSection2Item3 = Item::create([
		'section_id' => $homeSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection2Item3->id,
	'locale'=>'en',
	'title'=>'Doctor Burnout',
	'sub_title'=>"",
	'content'=>'Overwhelming administrative burdens and lack of strategic support lead to practitioner burnout and compromised patient care quality.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection2Item3->id,
	'locale'=>'ar',
	'title'=>'تعب الطبيب',
	'sub_title'=>'',
	'content'=>'الحملات الإدارية المكثفة وعدم وجود دعم استراتيجي يؤدي إلى تعب الطبيب وتدهور جودة الرعاية المرضية.',
	]);

// --------------------------	

	$homeSection3 = Section::where('name', 'Home Page Section 3')->first();
	$homeSection3Item1 = Item::create([
		'section_id' => $homeSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([	
	'cms_item_id'=>$homeSection3Item1->id,
	'locale'=>'en',
	'title'=>'Healthcare Marketing',
	'sub_title'=>"",
	'content'=>'SEO, performance ads, and social media strategies tailored to attract and retain patients.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection3Item1->id,
	'locale'=>'ar',
	'title'=>'التسويق الطبي',
	'sub_title'=>'',
	'content'=>'التسويق البحثي، الإعلانات الأداء، والاستراتيجيات الاجتماعية المخصصة لجذب والاحتفاظ بالمرضى.',
	]);

// --------------------------

	$homeSection3Item2 = Item::create([
		'section_id' => $homeSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection3Item2->id,
	'locale'=>'en',
	'title'=>'Software Development',
	'sub_title'=>"",
	'content'=>'Custom HIS, patient apps, and medical websites built with the latest technologies.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection3Item2->id,
	'locale'=>'ar',
	'title'=>'تطوير البرمجيات',
	'sub_title'=>'',
	'content'=>'نظم HIS المخصصة، تطبيقات المرضى، ومواقع الطب المبنية بأحدث التكنولوجيا.',
	]);

// --------------------------

	$homeSection3Item3 = Item::create([
		'section_id' => $homeSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection3Item3->id,
	'locale'=>'en',
	'title'=>'Dedicated Call Centers',
	'sub_title'=>"",
	'content'=>'Professional 24/7 patient support and appointment booking to maximize conversion.'
	]);

	ItemTranslation::create([	
	'cms_item_id'=>$homeSection3Item3->id,
	'locale'=>'ar',
	'title'=>'مراكز الاتصال المخصصة',
	'sub_title'=>'',
	'content'=>'دعم 24/7 للمرضى وجدولة المواعيد لزيادة التحويل.'
	]);

// --------------------------

	$homeSection4 = Section::where('name', 'Home Page Section 4')->first();
	$homeSection4Item1 = Item::create([
		'section_id' => $homeSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection4Item1->id,
	'locale'=>'en',
	'title'=>'Digital Commerce Phase',
	'sub_title'=>"",
	'content'=>'Implementing digital patient engagement and e-commerce capabilities.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection4Item1->id,
	'locale'=>'ar',
	'title'=>'المرحلة الرقمية للتجارة',
	'sub_title'=>'',
	'content'=>'تنفيذ التعامل الرقمي مع المرضى وقدرات التجارة الإلكترونية.'
	]);

// --------------------------

	$homeSection4Item2 = Item::create([
		'section_id' => $homeSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);
	
	
	ItemTranslation::create([
	'cms_item_id'=>$homeSection4Item2->id,
	'locale'=>'en',
	'title'=>'Consultation Expansion',
	'sub_title'=>"",
	'content'=>'Expanding specialist consultation networks and referral partnerships.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection4Item2->id,
	'locale'=>'ar',
	'title'=>'توسيع الاستشارات الخاصة',
	'sub_title'=>'',
	'content'=>'توسيع شبكات الاستشارات الخاصة والشراكات الإحالة.'
	]);
	
// --------------------------

	$homeSection4Item3 = Item::create([
		'section_id' => $homeSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection4Item3->id,
	'locale'=>'en',
	'title'=>'Patient Lifetime Expansion',
	'sub_title'=>"",
	'content'=>'Building long-term patient relationships and maximizing lifetime value.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$homeSection4Item3->id,
	'locale'=>'ar',
	'title'=>'توسيع قيمة العمر المرضي',
	'sub_title'=>'',
	'content'=>'توسيع قيمة العمر المرضي من خلال برامج اللايفلي، الاستراتيجيات الاحتفاظ، والرعاية الشخصية.'
	]);


// -------------------------- end of home page items ----------------------------------

// -------------------------- start of healthcare page items ----------------------------------

	$healthcareSection2 = Section::where('name', 'Healthcare Page Section 2')->first();
	$healthcareSection2Item1 = Item::create([
		'section_id' => $healthcareSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection2Item1->id,
	'locale'=>'en',
	'title'=>'Patient Acquisition',
	'sub_title'=>"",
	'content'=>'Digital marketing and local SEO strategies to attract new patients consistently.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection2Item1->id,
	'locale'=>'ar',
	'title'=>'الحصول على المرضى',
	'sub_title'=>'',
	'content'=>'استراتيجيات التسويق الرقمي والبحث الإلكتروني المحلي لجذب المرضى باستمرار.'
	]);

// --------------------------

	$healthcareSection2Item2 = Item::create([
		'section_id' => $healthcareSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection2Item2->id,
	'locale'=>'en',
	'title'=>'Operations Streamlining',
	'sub_title'=>"",
	'content'=>'Appointment scheduling, patient management, and workflow optimization.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection2Item2->id,
	'locale'=>'ar',
	'title'=>'تدفق العمليات',
	'sub_title'=>'',
	'content'=>'جدولة المواعيد، مديرية المرضى، وتحسين سير العمليات.'
	]);

// --------------------------

	$healthcareSection2Item3 = Item::create([
		'section_id' => $healthcareSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection2Item3->id,
	'locale'=>'en',
	'title'=>'Revenue Growth',
	'sub_title'=>"",
	'content'=>'Service expansion, pricing strategy, and patient lifetime value maximization.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection2Item3->id,
	'locale'=>'ar',
	'title'=>'نمو الإيرادات',
	'sub_title'=>'',
	'content'=>'توسيع الخدمات، استراتيجية الأسعار، وتعظيم قيمة العمر المرضي.'
	]);

// --------------------------

	$healthcareSection3 = Section::where('name', 'Healthcare Page Section 3')->first();
	$healthcareSection3Item1 = Item::create([
		'section_id' => $healthcareSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection3Item1->id,
	'locale'=>'en',
	'title'=>'Cross-Specialty Integration',
	'sub_title'=>"",
	'content'=>'Unified systems connecting multiple specialties and departments seamlessly.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection3Item1->id,
	'locale'=>'ar',
	'title'=>'التكامل المتعدد التخصصات',
	'sub_title'=>'',
	'content'=>'نظم موحدة للتكامل بين التخصصات والأقسام بشكل سلس.'
	]);

// --------------------------

	$healthcareSection3Item2 = Item::create([
		'section_id' => $healthcareSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection3Item2->id,
	'locale'=>'en',
	'title'=>'Complex Workflows',
	'sub_title'=>"",
	'content'=>'Managing patient journeys across multiple departments with precision.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection3Item2->id,
	'locale'=>'ar',
	'title'=>'عمليات معقدة',
	'sub_title'=>'',
	'content'=>'إدارة مسارات المرضى عبر عدة أقسام بدقة.'
	]);

// --------------------------

	$healthcareSection3Item3 = Item::create([
		'section_id' => $healthcareSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection3Item3->id,
	'locale'=>'en',
	'title'=>'Referral Networks',
	'sub_title'=>"",
	'content'=>'Building internal and external referral systems for exponential growth.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection3Item3->id,
	'locale'=>'ar',
	'title'=>'شبكات الإحالة',
	'sub_title'=>'',
	'content'=>'بناء نظم الإحالة الداخلية والخارجية للنمو الأسي.'
	]);

// --------------------------

	$healthcareSection4 = Section::where('name', 'Healthcare Page Section 4')->first();
	$healthcareSection4Item1 = Item::create([
		'section_id' => $healthcareSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection4Item1->id,
	'locale'=>'en',
	'title'=>'Departmental Optimization',
	'sub_title'=>"",
	'content'=>'Individual department performance tracking and revenue maximization.'
	]);	

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection4Item1->id,
	'locale'=>'ar',
	'title'=>'تحسين الأقسام',
	'sub_title'=>'',
	'content'=>'تتبع الأداء الفردي للأقسام وتعظيم الإيرادات.'
	]);

// --------------------------

	$healthcareSection4Item2 = Item::create([
		'section_id' => $healthcareSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection4Item2->id,
	'locale'=>'en',
	'title'=>'Staff Coordination',
	'sub_title'=>"",
	'content'=>'Doctor and staff management with performance incentive systems.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection4Item2->id,
	'locale'=>'ar',
	'title'=>'تنسيق الموظفين',
	'sub_title'=>'',
	'content'=>'إدارة الطبيبين والموظفين بنظم إثارة الأداء.'
	]);

// --------------------------

	$healthcareSection4Item3 = Item::create([
		'section_id' => $healthcareSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection4Item3->id,
	'locale'=>'en',
	'title'=>'Strategic Positioning',
	'sub_title'=>"",
	'content'=>'Market positioning and competitive advantage in hospital segments.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection4Item3->id,
	'locale'=>'ar',
	'title'=>'الوضع الاستراتيجي',
	'sub_title'=>'',
	'content'=>'الوضع الاستراتيجي في الأسواق المستشفياتية.'
	]);
// --------------------------

// --------------------------- end of healthcare page items ----------------------------------

// --------------------------- start of digital marketing page items ----------------------------------

	$digitalMarketingSection2 = Section::where('name', 'Digital Marketing Page Section 2')->first();
	$digitalMarketingSection2Item1 = Item::create([
		'section_id' => $digitalMarketingSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection2Item1->id,
	'locale'=>'en',
	'title'=>'Healthcare SEO',
	'sub_title'=>"Dominating local and specialized search results for clinics and hospitals.",
	'content'=>'<ul> <li> Local SEO Optimization </li> <li> Medical Content Strategy </li> <li> Technical Audits </li> </ul>'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection2Item1->id,
	'locale'=>'ar',
	'title'=>'التسويق البحثي',
	'sub_title'=>'التسويق البحثي المحلي والتخصصي لجذب المرضى بشكل مستمر.',
	'content'=>'<ul> <li> تحسين SEO المحلي </li> <li> استراتيجية المحتوى الطبي </li> <li> التدقيق التقني </li> </ul>',
	]);

// ----------------------------------

	$digitalMarketingSection2Item2 = Item::create([
		'section_id' => $digitalMarketingSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection2Item2->id,
	'locale'=>'en',
	'title'=>'Performance Ads',
	'sub_title'=>"High-conversion Google and Meta ad campaigns focused on bookings.",
	'content'=>'<ul> <li> Search & Display Ads </li> <li> Patient Retargeting </li> <li> CRO Optimization </li> </ul>'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection2Item2->id,
	'locale'=>'ar',
	'title'=>'الإعلانات الأداء',
	'sub_title'=>'الإعلانات البحثية والعرضية المركزة على الحجز في Google وMeta.',
	'content'=>'<ul> <li> الإعلانات البحثية والعرضية </li> <li> إعادة التوجيه للمرضى </li> <li> تحسين CRO </li> </ul>',
	]);

// ----------------------------------

	$digitalMarketingSection2Item3 = Item::create([
		'section_id' => $digitalMarketingSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection2Item3->id,
	'locale'=>'en',
	'title'=>'Social Media',
	'sub_title'=>"Building trust and authority through professional social presence.",
	'content'=>'<ul> <li> Content Creation </li> <li> Community Management </li> <li> Patient Stories </li> </ul>'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection2Item3->id,
	'locale'=>'ar',
	'title'=>'الوسائط الاجتماعية',
	'sub_title'=>'بناء الثقة والسلطة من خلال الوسائط الاجتماعية المهنية.',
	'content'=>'<ul> <li> إنشاء المحتوى </li> <li> إدارة المجتمع </li> <li> قصص المرضى </li> </ul>',
	]);

// ----------------------------------

         $digitalMarketingSection3 = Section::where('name', 'Digital Marketing Page Section 3')->first();
         $digitalMarketingSection3Item1 = Item::create([
		'section_id' => $digitalMarketingSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection3Item1->id,
	'locale'=>'en',
	'title'=>'What We Deliver',
	'sub_title'=>"",
	'content'=>'<ul> <li> Strategic ad campaign planning and execution</li> 
	<li> Performance metrics and continuous optimization </li> 
	<li> Multi-channel advertising (Google, Facebook, Instagram) </li> 
	<li>Patient acquisition cost reduction</li>
	<li>ROI tracking and reporting dashboards</li>
	<li>A/B testing and conversion optimization</li>
</ul>'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection3Item1->id,
	'locale'=>'ar',
	'title'=>'ما نقدمه',
	'sub_title'=>"",
	'content'=>'<ul> <li> الخطط الاستراتيجية للإعلانات وتنفيذها </li> 
	<li> القياسات الأدائية والتحسين المستمر </li> 
	<li> الإعلانات المتعددة القنوات (Google, Facebook, Instagram) </li> 
	<li> تقليل تكلفة الحصول على المرضى </li>
	<li> تتبع العائد والتقارير المرصودة </li>
	<li> A/B testing and conversion optimization</li>
</ul>'
	]);

// ----------------------------------

	$digitalMarketingSection3Item2= Item::create([
		'section_id' => $digitalMarketingSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection3Item2->id,
	'locale'=>'en',
	'title'=>'Healthcare Specific KPIs',
	'sub_title'=>"",
	'content'=>'<ul> <li> Patient Acquisition Cost (PAC)</li> 
	<li> Appointment Conversion Rate </li> 
	<li> Cost Per Qualified Lead </li> 
	<li> Search Visibility for Specialists </li>
	<li> Patient Lifetime Value (LTV) </li>
	<li>Review Sentiment Score</li>
	</ul>'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection3Item2->id,
	'locale'=>'ar',
	'title'=>'المقاييس المخصصة للطب الصحي',
	'sub_title'=>"",
	'content'=>'<ul> <li> تكلفة الحصول على المرضى (PAC) </li> 
	<li> معدل تحويل المواعيد </li> 
	<li> تكلفة الحصول على المرضى (PAC) </li> 
	<li> معدل تحويل المواعيد </li> 
	<li> تكلفة الحصول على المرضى (PAC) </li> 
	<li> تتبع العائد والتقارير المرصودة </li>
	</ul>'
	]);

// ----------------------------------

        $digitalMarketingSection4 = Section::where('name', 'Digital Marketing Page Section 4')->first();
        $digitalMarketingSection4Item1 = Item::create([
		'section_id' => $digitalMarketingSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection4Item1->id,
	'locale'=>'en',
	'title'=>'Audit',
	'sub_title'=>"",
	'content'=>'',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection4Item1->id,
	'locale'=>'ar',
	'title'=>'التدقيق',
	'sub_title'=>"",
	'content'=>'',
	]);

// ----------------------------------

	$digitalMarketingSection4Item2= Item::create([
		'section_id' => $digitalMarketingSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection4Item2->id,
	'locale'=>'en',
	'title'=>'Strategy',
	'sub_title'=>"",
	'content'=>'',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection4Item2->id,
	'locale'=>'ar',
	'title'=>'الاستراتيجية',
	'sub_title'=>"",
	'content'=>'',
	]);

// ----------------------------------

	$digitalMarketingSection4Item3= Item::create([
		'section_id' => $digitalMarketingSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection4Item3->id,
	'locale'=>'en',
	'title'=>'Launch',
	'sub_title'=>"",
	'content'=>'',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection4Item3->id,
	'locale'=>'ar',
	'title'=>'الإطلاق',
	'sub_title'=>"",
	'content'=>'',
	]);

// ----------------------------------

	$digitalMarketingSection4Item4= Item::create([
		'section_id' => $digitalMarketingSection4->id,
		'type' => 'default',
		'settings' => null,
		'order' => 4,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection4Item4->id,
	'locale'=>'en',
	'title'=>'Optimize',
	'sub_title'=>"",
	'content'=>'',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$digitalMarketingSection4Item4->id,
	'locale'=>'ar',
	'title'=>'تحسين',
	'sub_title'=>"",
	'content'=>'',
	]);

// --------------------------- end of digital marketing page items ----------------------------------

// --------------------------- start of software house page items ----------------------------------
// 
	$softwareHouseSection2 = Section::where('name', 'Software House Page Section 2')->first();
	$softwareHouseSection2Item1 = Item::create([
		'section_id' => $softwareHouseSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$softwareHouseSection2Item1->id,
	'locale'=>'en',
	'title'=>'Hospital Systems (HIS)',
	'sub_title'=>"Full-scale management systems for hospitals and large clinics.",
	'content'=>'<ul> 
		<li> EMR/EHR </li> 
		<li> Billing </li> 
		<li> Pharmacy </li> 
		<li> Lab </li> 
		</ul>',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$softwareHouseSection2Item1->id,
	'locale'=>'ar',
	'title'=>'نظم المستشفيات (HIS)',
	'sub_title'=>'نظم مديرية المرضى الكاملة للمستشفيات والمراكز الطبية الكبيرة.',
	'content'=>'<ul> 
		<li> EMR/EHR </li> 
		<li> الفواتير </li> 
		<li> الصيدلية </li> 
		<li> المختبر </li> 
		</ul>',
	]);

// ----------------------------------

	$softwareHouseSection2Item2 = Item::create([
		'section_id' => $softwareHouseSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$softwareHouseSection2Item2->id,
	'locale'=>'en',
	'title'=>'Patient Mobile Apps',
	'sub_title'=>"Native iOS/Android apps for patient engagement and telemedicine.",
	'content'=>'<ul> 
	<li> Video Calls </li> 
	<li> Bookings </li> 
	<li> Health Tracking </li> 
	<li> Chat </li> 
	</ul>',
	]);

	ItemTranslation::create([	
	'cms_item_id'=>$softwareHouseSection2Item2->id,
	'locale'=>'ar',
	'title'=>'تطبيقات المرضى المحمولة',
	'sub_title'=>'تطبيقات iOS/Android المخصصة للتعامل الرقمي مع المرضى والطب التشخيصي.',
	'content'=>'<ul> 
	<li> مكالمات الفيديو </li> 
	<li> الحجز </li> 
	<li> التتبع الصحي </li> 
	<li> الدردشة </li> 
	</ul>',
	]);

// ----------------------------------

	$softwareHouseSection2Item3 = Item::create([
		'section_id' => $softwareHouseSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$softwareHouseSection2Item3->id,
	'locale'=>'en',
	'title'=>'Medical Websites',
	'sub_title'=>"Conversion-optimized websites built for healthcare providers.",
	'content'=>'<ul> 
	<li> SEO Ready </li> 
	<li> Online Booking </li> 
	<li> Doctor Portfolios </li> 
	<li> CMS </li> 
	</ul>',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$softwareHouseSection2Item3->id,
	'locale'=>'ar',
	'title'=>'مواقع الطب المخصصة للتحويل',
	'sub_title'=>'مواقع الطب المخصصة لمزودي الرعاية الصحية.',
	'content'=>'<ul> 
	<li> SEO مستعد </li> 
	<li> الحجز الإلكتروني </li> 
	<li> مناقشات الطبيب </li> 
	<li> نظام الإدارة </li> 
	</ul>',
	]);

// ----------------------------------

	$softwareHouseSection3 = Section::where('name', 'Software House Page Section 3')->first();
	$softwareHouseSection3Item1 = Item::create([
		'section_id' => $softwareHouseSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$softwareHouseSection3Item1->id,
	'locale'=>'en',
	'title'=>'Modern Tech Stack',
	'sub_title'=>"We use the most reliable and scalable technologies to ensure your medical software is fast, secure, and future-proof.",
	'content'=>'<ul> 
	<li> Next.js </li> 
	<li> React Native </li> 
	<li> Node.js </li> 
	<li> Python </li> 
	<li> AWS </li> 
	<li> PostgreSQL </li> 
	<li> Docker </li> 
	<li> Redis </li> 
	</ul>',
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$softwareHouseSection3Item1->id,
	'locale'=>'ar',
	'title'=>'التكنولوجيا الحديثة',
	'sub_title'=>'نستخدم التكنولوجيا الأكثر موثوقية وقابلة للتحجيم لضمان أن برمجياتك الطبية هي سريعة وآمنة ومستقبلية.',
	'content'=>'<ul> 
	<li> Next.js </li> 
	<li> React Native </li> 
	<li> Node.js </li> 
	<li> Python </li> 
	<li> AWS </li> 
	<li> PostgreSQL </li> 
	<li> Docker </li> 
	<li> Redis </li> 
	</ul>',
	'content'=>'',
	]);

// ----------------------------------

	$softwareHouseSection3Item2 = Item::create([
		'section_id' => $softwareHouseSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$softwareHouseSection3Item2->id,
	'locale'=>'en',
	'title'=>'Compliance & Security',
	'sub_title'=>"",
	'content'=>'<ul> 
	<li> HIPAA-Compliant Architecture </li> 
	<li> End-to-End Data Encryption </li> 
	<li> ISO 27001 Standards </li> 
	<li> Regular Security Audits </li> 
	<li> Secure API Integrations </li> 
	<li> Redundant Cloud Storage </li> 
	</ul>',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$softwareHouseSection3Item2->id,
	'locale'=>'ar',
	'title'=>'التوافق والأمان',
	'sub_title'=>'',
	'content'=>'<ul> 
	<li> بنية توافقية HIPAA </li> 
	<li> تشفير البيانات من البداية إلى النهاية </li> 
	<li> معايير ISO 27001 </li> 
	<li> مراجعات أمان منتظمة </li> 
	<li> اتصالات API الآمنة </li> 
	<li> تخزين البيانات المزدوج في السحابة </li> 
	</ul>',
	]);

// --------------------------- end of software house page items ----------------------------------


// --------------------------- start of call center page items ----------------------------------
// 
	$callCenterSection2 = Section::where('name', 'Call Center Page Section 2')->first();
	$callCenterSection2Item1 = Item::create([
		'section_id' => $callCenterSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection2Item1->id,
	'locale'=>'en',
	'title'=>'Appointment Booking',
	'sub_title'=>"Dedicated agents to manage and confirm appointments across all specialties.",
	'content'=>'<ul> 
	<li> Specialist Availability Check </li> 
	<li> Multi-location Management </li> 
	<li> Direct HIS Integration </li> 
	</ul>',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection2Item1->id,
	'locale'=>'ar',
	'title'=>'جدولة المواعيد',
	'sub_title'=>'عمليات جدولة المواعيد المخصصة لجميع التخصصات.',
	'content'=>'<ul> 
	<li> التحقق من توفر الطبيب </li> 
	<li> الإدارة المتعددة المواقع </li> 
	<li> التكامل مع HIS </li> 
	</ul>',
	]);

// ----------------------------------

	$callCenterSection2Item2 = Item::create([
		'section_id' => $callCenterSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection2Item2->id,
	'locale'=>'en',
	'title'=>'Patient Support',
	'sub_title'=>"Professional handling of patient inquiries and post-visit follow-ups.",
	'content'=>'<ul> 
	<li> Educational Information </li> 
	<li> Medication Reminders </li> 
	<li> Feedback Collection </li> 
	</ul>',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection2Item2->id,
	'locale'=>'ar',
	'title'=>'دعم المرضى',
	'sub_title'=>'التعامل المهني مع الاستفسارات المرضى ومتابعة الزيارات اللاحقة.',
	'content'=>'<ul> 
	<li> المعلومات التعليمية </li> 
	<li> تذكيرات الأدوية </li> 
	<li> التقييمات </li> 
	</ul>',
	]);

// ----------------------------------

	$callCenterSection2Item3 = Item::create([
		'section_id' => $callCenterSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection2Item3->id,
	'locale'=>'en',
	'title'=>'Lead Qualification',
	'sub_title'=>"Filtering leads from marketing campaigns to ensure high-value bookings.",
	'content'=>'<ul> 
	<li> Insurance Verification </li> 
	<li> Patient Pre-screening </li> 
	<li> Priority Routing </li> 
	</ul>',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection2Item3->id,
	'locale'=>'ar',
	'title'=>'تحديد القيمة المضافة',
	'sub_title'=>'تصفية القيم المضافة من الحملات التسويقية لضمان الحجز المرغوب.',
	'content'=>'<ul> 
	<li> التحقق من تأمين المرضى </li> 
	<li> التحقق من تأمين المرضى </li> 
	<li> التحويل الأساسي </li> 
	</ul>',
	]);

// ----------------------------------

	$callCenterSection2Item4 = Item::create([
		'section_id' => $callCenterSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 4,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection2Item4->id,
	'locale'=>'en',
	'title'=>'Crisis & Urgent Routing',
	'sub_title'=>"Trained agents to handle urgent patient calls and route them appropriately.",
	'content'=>'<ul> 
	<li> Triage Protocols </li> 
	<li> Emergency Routing </li> 
	<li> Doctor Paging Systems </li> 
	</ul>',
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection2Item4->id,
	'locale'=>'ar',
	'title'=>'الطوارئ والتحويل السريع',
	'sub_title'=>'التدريب المهني للموظفين للتعامل مع المكالمات الطوارئ وتحويلها بشكل صحيح.',
	'content'=>'<ul> 
	<li> التحقق من تأمين المرضى </li> 
	<li> التحويل السريع </li> 
	<li> نظام تدبير الطوارئ </li> 
	</ul>',
	]);

// ----------------------------------

	$callCenterSection3 = Section::where('name', 'Call Center Page Section 3')->first();
	$callCenterSection3Item1 = Item::create([
		'section_id' => $callCenterSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection3Item1->id,
	'locale'=>'en',
	'title'=>'AHT',
	'sub_title'=>"Average Handle Time",
	'content'=>'',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection3Item1->id,
	'locale'=>'ar',
	'title'=>'متوسط زمن التعامل',
	'sub_title'=>'متوسط زمن التعامل مع المكالمات.',
	'content'=>'',
	]);
	
// ----------------------------------

	$callCenterSection3Item2 = Item::create([
		'section_id' => $callCenterSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection3Item2->id,
	'locale'=>'en',
	'title'=>'FCR',
	'sub_title'=>"First Call Resolution",
	'content'=>'',
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection3Item2->id,
	'locale'=>'ar',
	'title'=>'FCR',
	'sub_title'=>"First Call Resolution",
	'content'=>'',
	]);

// ----------------------------------

	$callCenterSection3Item3 = Item::create([
		'section_id' => $callCenterSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection3Item3->id,
	'locale'=>'en',
	'title'=>'Conversion',
	'sub_title'=>"Lead to Appointment Rate",
	'content'=>'',
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection3Item3->id,
	'locale'=>'ar',
	'title'=>'تحويل',
	'sub_title'=>'معدل تحويل القيم المضافة إلى مواعيد.',
	'content'=>'',
	]);
	
// ----------------------------------

	$callCenterSection3Item4 = Item::create([
		'section_id' => $callCenterSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 4,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection3Item4->id,
	'locale'=>'en',
	'title'=>'CSAT',
	'sub_title'=>"Customer Satisfaction Score",
	'content'=>'',
	]);
	
	ItemTranslation::create([
	'cms_item_id'=>$callCenterSection3Item4->id,
	'locale'=>'ar',
	'title'=>'CSAT',
	'sub_title'=>'رضا العملاء',
	'content'=>'',
	]);
	
}
}
