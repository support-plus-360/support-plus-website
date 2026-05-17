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



// -------------------------- start of home page section 5 items ----------------------------------

	$homeSection5 = Section::where('name', 'Home Page Section 5')->first();
	$homeSection5Item1 = Item::create([
		'section_id' => $homeSection5->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
		'cms_item_id'=>$homeSection5Item1->id,
		'locale'=>'en',
		'title'=>'24x Multi-Location Revenue Surge',
		'sub_title'=>"+160%",
		'content'=>''
	]);

	ItemTranslation::create([
		'cms_item_id'=>$homeSection5Item1->id,
		'locale'=>'ar',
		'title'=>'زيادة الإيرادات الشهرية لمركز طبي متعدد المواقع',
		'sub_title'=>"+160%",
		'content'=>''
	]);

	$homeSection5Item2 = Item::create([
		'section_id' => $homeSection5->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
		'cms_item_id'=>$homeSection5Item2->id,
		'locale'=>'en',
		'title'=>'Cross-Referral Architectural Shift',
		'sub_title'=>"+88%",
		'content'=>''
	]);

	ItemTranslation::create([
		'cms_item_id'=>$homeSection5Item2->id,
		'locale'=>'ar',
		'title'=>'انتقال البنية التحويلية للإحالات المتقاطعة',
		'sub_title'=>"+88%",
		'content'=>''
	]);


	// section 6 items
	$homeSection6 = Section::where('name', 'Home Page Section 6')->first();
	$homeSection6Item1 = Item::create([
		'section_id' => $homeSection6->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
		'cms_item_id'=>$homeSection6Item1->id,
		'locale'=>'en',
		'title'=>'Regularity desk',
		'sub_title'=>"",
		'content'=>'Advanced stargies and proven methodologies to deliver consistent results.'
	]);

	ItemTranslation::create([
		'cms_item_id'=>$homeSection6Item1->id,
		'locale'=>'ar',
		'title'=>'الجدول المنتظم',
		'sub_title'=>"",
		'content'=>'استراتيجيات متقدمة وطرق موثوق بها لتحقيق نتائج منتظمة.'
	]);

	$homeSection6Item2 = Item::create([
		'section_id' => $homeSection6->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
		'cms_item_id'=>$homeSection6Item2->id,
		'locale'=>'en',
		'title'=>'Patient Psychology',
		'sub_title'=>"",
		'content'=>'Advanced psychological strategies to attract and retain patients.'
	]);
	
	
	ItemTranslation::create([
		'cms_item_id'=>$homeSection6Item2->id,
		'locale'=>'ar',
		'title'=>'علم النفس المرضي',
		'sub_title'=>'',
		'content'=>'استراتيجيات علم النفس المتقدمة لجذب والاحتفاظ بالمرضى.'
	]);


	$homeSection6Item3 = Item::create([
		'section_id' => $homeSection6->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
		'cms_item_id'=>$homeSection6Item3->id,
		'locale'=>'en',
		'title'=>'Growth Architecture',
		'sub_title'=>"",
		'content'=>'Advanced psychological strategies to attract and retain patients.'
	]);
	
	ItemTranslation::create([
		'cms_item_id'=>$homeSection6Item3->id,
		'locale'=>'ar',
		'title'=>'البنية التحويلية للنمو',
		'sub_title'=>'',
		'content'=>'استراتيجيات علم النفس المتقدمة لجذب والاحتفاظ بالمرضى.'
	]);

	// testimonial item
	$homeSection6Item4 = Item::create([
		'section_id' => $homeSection6->id,
		'type' => 'testimonial',
		'settings' => null,
		'order' => 4,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
		'cms_item_id'=>$homeSection6Item4->id,
		'locale'=>'en',
		'title'=>'Dr. Mohamed',
		'sub_title'=>"Healthcare Administrator • Healthcare Excellence",
		'content'=>'Support Plus transformed our clinic from struggling to thriving. Their integrated approach to marketing and operations was exactly what we needed.'
	]);

	ItemTranslation::create([
		'cms_item_id'=>$homeSection6Item4->id,
		'locale'=>'ar',
		'title'=>'د. محمد',
		'sub_title'=>"مدير الطب الصحي • الرعاية الصحية المتميزة",
		'content'=>'Support Plus حولت مركزنا من متأرجح إلى متألق. النظام المدمج للتسويق والعمليات كان مثاليا لما كنا نحتاجه.'
	]);
	
	
	
// -------------------------- end of home page section 5 items ----------------------------------
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

	$healthcareSection5 = Section::where('name', 'Healthcare Page Section 5')->first();
	$healthcareSection5Item1 = Item::create([
		'section_id' => $healthcareSection5->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
		'cms_item_id'=>$healthcareSection5Item1->id,
		'locale'=>'en',
		'title'=>'Dr. Ahmed',
		'sub_title'=>"Clinic Director • Cairo Medical Center",
		'content'=>'Support Plus transformed our clinic from struggling to thriving. Their integrated approach to marketing and operations was exactly what we needed.'
	]);

	ItemTranslation::create([
		'cms_item_id'=>$healthcareSection5Item1->id,
		'locale'=>'ar',
		'title'=>'د. أحمد',
		'sub_title'=>"مدير العيادة • مركز الطب القاهرة",
		'content'=>'Support Plus حولت مركزنا من متأرجح إلى متألق. النظام المدمج للتسويق والعمليات كان مثاليا لما كنا نحتاجه.'
	]);

// --------------------------

	$healthcareSection5Item2 = Item::create([
		'section_id' => $healthcareSection5->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection5Item2->id,
	'locale'=>'en',
	'title'=>'Dr. Fatima',
	'sub_title'=>"Polyclinic Administrator • Healthcare Excellence",
	'content'=>'The multi-specialty coordination system revolutionized how our departments communicate. Patient satisfaction increased by 45%.',
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection5Item2->id,
	'locale'=>'ar',
	'title'=>'د. فاطمة',
	'sub_title'=>"مديرة العيادة • الرعاية الصحية المتميزة",
	'content'=>'نظام التعاون المتعدد التخصصات حولت كيفية التواصل بين الأقسام. ارتفع رضا المرضى بنسبة 45%.',
	]);

// --------------------------

	$healthcareSection5Item3 = Item::create([
		'section_id' => $healthcareSection5->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection5Item3->id,
	'locale'=>'en',
	'title'=>'Dr. Karim',
	'sub_title'=>"Hospital Executive • National Health Group",
	'content'=>'As a hospital, we needed enterprise solutions. Their strategic framework increased our revenue and staff efficiency simultaneously.'
	]);

	ItemTranslation::create([
	'cms_item_id'=>$healthcareSection5Item3->id,
	'locale'=>'ar',
	'title'=>'د. كريم',
	'sub_title'=>"مدير عام • مجموعة الرعاية الصحية الوطنية",
	'content'=>'كمركز طبي، كنا بحاجة إلى حلول المؤسسة. المنظومة الاستراتيجية المدمجة زادت الإيرادات وكفاءة الموظفين معا.',
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



//-------------------------- end of call center page items ----------------------------------

//-------------------------- start of services page items ----------------------------------

	$servicesSection2 = Section::where('name', 'Services Page Section 2')->first();
	$servicesSection2Item1 = Item::create([
		'section_id' => $servicesSection2->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
		'cms_item_id'=>$servicesSection2Item1->id,
		'locale'=>'en',
		'title'=>'Brand & Launch',
		'sub_title'=>"Best for new premium clinics.",
		'content'=>'<ul> <li> Strategy & Identity <li> Web Platform </li> <li> Photo/Video Assets </li> </ul>',
	]);

	ItemTranslation::create([
		'cms_item_id'=>$servicesSection2Item1->id,
		'locale'=>'ar',
		'title'=>'العلامة التجارية والإطلاق',
		'sub_title'=>"",
		'content'=>'<ul> <li> الاستراتيجية والهوية <li> المنصة الويب </li> <li> الصور/الفيديو </li> </ul>',
	]);


    // item 2
    $servicesSection2Item2 = Item::create([
        'section_id' => $servicesSection2->id,
        'type' => 'default',
        'settings' => null,
        'order' => 2,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection2Item2->id,
        'locale'=>'en',
        'title'=>'Lead Gen',
        'sub_title'=>"High-volume patient acquisition.",
        'content'=>'<ul> <li> Meta & Google Ads </li> <li> High-Conv Landing Pages</li> <li> Weekly Optimization </li> </ul>',
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection2Item2->id,
        'locale'=>'ar',
        'title'=>'الحصول على المرضى',
        'sub_title'=>"الحصول على المرضى بالإعلانات المركزة على Meta وGoogle.",
        'content'=>'<ul> <li> الإعلانات المركزة على Meta وGoogle </li> <li> الصفحات المركزة على الحجز </li> <li> التحسين الأسبوعي </li> </ul>',
    ]);


    // item 3
    $servicesSection2Item3 = Item::create([
        'section_id' => $servicesSection2->id,
        'type' => 'default',
        'settings' => null,
        'order' => 3,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection2Item3->id,
        'locale'=>'en',
        'title'=>'Lead-to-Booking',
        'sub_title'=>"Bridging the gap to revenue.",
        'content'=>'<ul> <li> CRM Implementation </li> <li> Lead Nurturing Email </li> <li> Appointment Bot </li> </ul>',
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection2Item3->id,
        'locale'=>'ar',
        'title'=>'تحويل القيم المضافة إلى مواعيد',
        'sub_title'=>"",
        'content'=>'<ul> <li> تنفيذ CRM <li> البريد الإلكتروني لتنويع القيم المضافة </li> <li> بوت الحجز </li> </ul>',
    ]);


    // item 4
    $servicesSection2Item4 = Item::create([
        'section_id' => $servicesSection2->id,
        'type' => 'default',
        'settings' => null,
        'order' => 4,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection2Item4->id,
        'locale'=>'en',
        'title'=>'Software-Backed',
        'sub_title'=>"For multi-location scale.",
        'content'=>'<ul> <li> Custom Dashboards </li> <li> Patient Portal Dev </li> <li> API Integrations </li> </ul>',
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection2Item4->id,
        'locale'=>'ar',
        'title'=>'البرمجيات المدعومة',
        'sub_title'=>"للمقياس المتعدد للمواقع.",
        'content'=>'<ul> <li> لوحات التحكم المخصصة <li> تطوير لوحة المرضى </li> <li> اتصالات API </li> </ul>',
    ]);

    // item 5
    $servicesSection2Item5 = Item::create([
        'section_id' => $servicesSection2->id,
        'type' => 'default',
        'settings' => null,
        'order' => 5,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection2Item5->id,
        'locale'=>'en',
        'title'=>'Full Outsourced',
        'sub_title'=>"Your dedicated growth dept.",
        'content'=>'<ul> <li> All Services Included </li> <li> Daily Strategic Pivot </li> <li> Exclusive Partner Rep </li> </ul>',
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection2Item5->id,
        'locale'=>'ar',
        'title'=>'الخدمات الكاملة المنتجة',
        'sub_title'=>"القسم المخصص للنمو.",
        'content'=>'<ul> <li> جميع الخدمات مدمجة <li> التحديث اليومي للاستراتيجية </li> <li> الوكيل المميز المطلق </li> </ul>',
    ]);


    // section 3
    $servicesSection3 = Section::where('name', 'Services Page Section 3')->first();
    $servicesSection3Item1 = Item::create([
        'section_id' => $servicesSection3->id,
        'type' => 'default',
        'settings' => null,
        'order' => 1,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection3Item1->id,
        'locale'=>'en',
        'title'=>'Digital Marketing',
        'sub_title'=>"SEO, paid advertising, content marketing, and brand positioning to attract and convert patients.",
        'content'=>'<ul> <li> Google & Meta Advertising </li> <li> SEO & Content Strategy </li> <li> Social Media Management </li> </ul>',
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection3Item1->id,
        'locale'=>'ar',
        'title'=>'التسويق الرقمي',
        'sub_title'=>"التسويق البحثي والإعلانات الأداء والتسويق المحتوى والوضع الجذب والتحويل.",
        'content'=>'<ul> <li> الإعلانات المركزة على Google وMeta </li> <li> استراتيجية المحتوى والتسويق </li> <li> إدارة الوسائط الاجتماعية </li> </ul>',
    ]);


    // item 2
    $servicesSection3Item2 = Item::create([
        'section_id' => $servicesSection3->id,
        'type' => 'default',
        'settings' => null,
        'order' => 2,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection3Item2->id,
        'locale'=>'en',
        'title'=>'Software Solutions',
        'sub_title'=>"Custom platforms, patient portals, CRM systems, and operational software for healthcare facilities.",
        'content'=>'<ul> <li> CRM & Patient Management </li> <li> Custom Web Platforms </li> <li> Mobile Applications </li> </ul>',
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection3Item2->id,
        'locale'=>'ar',
        'title'=>'حلول البرمجيات المخصصة',
        'sub_title'=>"المنصات المخصصة، لوحات المرضى، نظم CRM، والبرمجيات التشغيلية لمراكز الطب المهني.",
        'content'=>'<ul> <li> نظم CRM وإدارة المرضى </li> <li> المنصات الويب المخصصة </li> <li> تطبيقات المرضى </li> </ul>',
    ]);


    // item 3
    $servicesSection3Item3 = Item::create([
        'section_id' => $servicesSection3->id,
        'type' => 'default',
        'settings' => null,
        'order' => 3,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection3Item3->id,
        'locale'=>'en',
        'title'=>'Call Center Solutions',
        'sub_title'=>"Patient follow-up, appointment booking, lead qualification, and customer support outsourcing.",
        'content'=>'<ul> <li> Lead Qualification </li> <li> Patient Follow-up </li> <li> Appointment Booking </li> </ul>',
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection3Item3->id,
        'locale'=>'ar',
        'title'=>'حلول مركز الاتصال',
        'sub_title'=>"متابعة المرضى، حجز المواعيد، تحديد القيمة المضافة، وخدمة العملاء المنتجة.",
        'content'=>'<ul> <li> تحديد القيمة المضافة </li> <li> متابعة المرضى </li> <li> حجز المواعيد </li> </ul>',
    ]);


    // item 4
    $servicesSection3Item4 = Item::create([
        'section_id' => $servicesSection3->id,
        'type' => 'default',
        'settings' => null,
        'order' => 4,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection3Item4->id,
        'locale'=>'en',
        'title'=>'Strategic Assessment',
        'sub_title'=>"In-depth analysis of your facility's growth gaps, competitive position, and personalized growth roadmap.",
        'content'=>'<ul> <li> Gap Analysis </li> <li> Competitive Audit </li> <li> Growth Roadmap </li> </ul>',
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection3Item4->id,
        'locale'=>'ar',
        'title'=>'التقييم الاستراتيجي',
        'sub_title'=>"التحليل العميق لفرص النمو والموضع التنافسي والخطة الاستراتيجية المخصصة للمركز.",
        'content'=>'<ul> <li> تحليل الفروقات  </li> <li> التحقق من التنافسية </li> <li> الخطة الاستراتيجية المخصصة </li> </ul>',
    ]);


    // section 4
    $servicesSection4 = Section::where('name', 'Services Page Section 4')->first();
    $servicesSection4Item1 = Item::create([
        'section_id' => $servicesSection4->id,
        'type' => 'default',
        'settings' => null,
        'order' => 1,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection4Item1->id,
        'locale'=>'en',
        'title'=>'Healthcare Director',
        'sub_title'=>"Integrated Approach",
        'content'=>'Their services work together seamlessly. Digital marketing brings patients, software converts them, and call center ensures follow-up.'
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection4Item1->id,
        'locale'=>'ar',
        'title'=>'مدير الطب الصحي',
        'sub_title'=>"النظام المدمج",
        'content'=>'خدماتهم تعمل معا بشكل متسق. التسويق الرقمي يجلب المرضى، البرمجيات تحولهم، ومركز الاتصال يضمن المتابعة.',
    ]);

    // item 2
    $servicesSection4Item2 = Item::create([
        'section_id' => $servicesSection4->id,
        'type' => 'default',
        'settings' => null,
        'order' => 2,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection4Item2->id,
        'locale'=>'en',
        'title'=>'Dr. Muhammad',
        'sub_title'=>"CEO, MEDCURE GROUP",
        'content'=>"Support Plus didn't just market our hospital; they re-architected how we interact with our patients. The growth wasn't just in numbers, but in the trust of our entire ecosystem.",
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection4Item2->id,
        'locale'=>'ar',
        'title'=>'د. محمد',
        'sub_title'=>"رئيس مجموعة ميدكر",
        'content'=>"Support Plus لم يقتصر على التسويق لمستشفينا; لقد أعادوا تصميم كيفية التعامل مع المرضى. النمو لم يكن فقط في الأرقام، ولكن في الثقة في المجتمع الكامل.",
    ]);

    // item 3
    $servicesSection4Item3 = Item::create([
        'section_id' => $servicesSection4->id,
        'type' => 'default',
        'settings' => null,
        'order' => 3,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection4Item3->id,
        'locale'=>'en',
        'title'=>'Hospital Admin',
        'sub_title'=>"Proven Results",
        'content'=>'Results speak louder than words. Our patient acquisition cost dropped 40% while conversion rates increased 60%.'
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$servicesSection4Item3->id,
        'locale'=>'ar',
        'title'=>'مدير المستشفى',
        'sub_title'=>"النتائج المباشرة",
        'content'=>"النتائج تتحدث أكثر من الكلمات. تنخفض تكلفة الحصول على المرضى بنسبة 40% بينما تزيد معدلات التحويل بنسبة 60%.",
    ]);

//---------- end of services page items ----------------------------------

// ---------- start of case studies page items ----------------------------------
    $caseStudiesSection2 = Section::where('name', 'Case Studies Page Section 2')->first();
    $caseStudiesSection2Item1 = Item::create([
        'section_id' => $caseStudiesSection2->id,
        'type' => 'default',
        'settings' => null,
        'order' => 1,
        'company_id' => 1,
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$caseStudiesSection2Item1->id,
        'locale'=>'en',
        'title'=>'24x Multi-Location Revenue Surge',
        'sub_title'=>"+160%",
        'content'=>"
	<p>A growing clinic network was struggling to scale operations across multiple locations. Patient acquisition was inconsistent, and marketing efforts weren't coordinated.</p>
	<ul>
	<li>The Challenge <br>
	Fragmented marketing, poor patient management systems, and no unified strategy across locations.
	</li>
	<li>Our Approach <br>
	Implemented unified digital marketing, centralized CRM, and location-specific optimization strategies.</li>
	<li>
	The Result <br>
	160% revenue increase in 12 months with improved patient satisfaction and operational efficiency.
	</li>
	</ul>
	",
    ]);

    ItemTranslation::create([
        'cms_item_id'=>$caseStudiesSection2Item1->id,
        'locale'=>'ar',
        'title'=>'زيادة الإيرادات الشهرية لمركز طبي متعدد المواقع',
        'sub_title'=>"الدراسة الميدانية 1 العنوان",
        'content'=>'الدراسة الميدانية 1 المحتوى',
    ]);


	// section 3
	$caseStudiesSection3 = Section::where('name', 'Case Studies Page Section 3')->first();
	$caseStudiesSection3Item1 = Item::create([
		'section_id' => $caseStudiesSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 1,
		'company_id' => 1,
	]);

	ItemTranslation::create([
		'cms_item_id'=>$caseStudiesSection3Item1->id,
		'locale'=>'en',
		'title'=>'Clinic Turnaround',
		'sub_title'=>"+240%",
		'content'=>'Patient acquisition growth through targeted digital marketing and local SEO optimization.'
	]);
	
	ItemTranslation::create([
		'cms_item_id'=>$caseStudiesSection3Item1->id,
		'locale'=>'ar',
		'title'=>'تحول المركز الطبي',
		'sub_title'=>"+240%",
		'content'=>'توسيع الحصول على المرضى عبر التسويق الرقمي والبحث الإلكتروني المحلي الموضوعي.'
	]);

	// item 2
	$caseStudiesSection3Item2 = Item::create([
		'section_id' => $caseStudiesSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 2,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
		'cms_item_id'=>$caseStudiesSection3Item2->id,
		'locale'=>'en',
		'title'=>'Hospital Efficiency',
		'sub_title'=>"+45%",
		'content'=>'Operational efficiency improvement through custom software and staff coordination systems.'
	]);
	
	ItemTranslation::create([
		'cms_item_id'=>$caseStudiesSection3Item2->id,
		'locale'=>'ar',
		'title'=>'كفاءة المستشفى',
		'sub_title'=>"+45%",
		'content'=>'تحسين الكفاءة التشغيلية عبر البرمجيات المخصصة ونظم التعاون بين الموظفين.'
	]);


	// item 3
	$caseStudiesSection3Item3 = Item::create([
		'section_id' => $caseStudiesSection3->id,
		'type' => 'default',
		'settings' => null,
		'order' => 3,
		'company_id' => 1,
	]);
	
	ItemTranslation::create([
		'cms_item_id'=>$caseStudiesSection3Item3->id,
		'locale'=>'en',
		'title'=>'Polyclinic Scale',
		'sub_title'=>"+175%",
		'content'=>'Revenue scaling across departments with unified patient management and referral systems.'
	]);
	
	ItemTranslation::create([
		'cms_item_id'=>$caseStudiesSection3Item3->id,
		'locale'=>'ar',
		'title'=>'توسيع العيادات المتعددة التخصصات',
		'sub_title'=>"+175%",
		'content'=>'توسيع الإيرادات عبر الأقسام بنظم موحدة لمديرية المرضى ونظم الإحالة.'
	]);
// ----------------------------------

}
}
