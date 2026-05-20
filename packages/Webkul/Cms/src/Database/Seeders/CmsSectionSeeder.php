<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Webkul\Cms\Models\Section;
use Webkul\Cms\Models\SectionTranslation;

class CmsSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

// home page sections
        $homeSection1 = Section::create([
            'name' => 'Home Page Section 1',
            'section_layout' => 'hero_section_style_1',
            'settings' => [],
            'is_active' => true,
            'order' => 1,
            'company_id' => 1,
            'page_id' => 1,
        ]);

	SectionTranslation::create([
		'cms_section_id'=>$homeSection1->id,
		'locale'=>'en',
		'title'=>'Scale Your Medical Practice With Precision',
		'subtitle'=>'Strategic Healthcare Growth Partner',
		'description'=>'Support Plus 360 provides specialized **Marketing**, **Software**, and **Call Center** solutions designed exclusively for healthcare providers to maximize revenue and patient trust.',
	]);


	SectionTranslation::create([
		'cms_section_id'=>$homeSection1->id,
		'locale'=>'ar',
		'title'=>'قم بتحقيق نمو طبي عالي بدقة',
		'subtitle'=>'شريك نمو طبي مهمل',
		'description'=>'Support Plus 360 يقدم حلول **التسويق**، **البرمجيات**، و **مركز الاتصال** المخصص لممارسات الطب المحددة بشكل خاص لزيادة الإيرادات والثقة المرضية.',
	]);



        $homeSection2 = Section::create([
            'name' => 'Home Page Section 2',
            'section_layout' => '3_items_in_row_section_style_1',
            'settings' => [],
            'order' => 2,
            'company_id' => 1,
            'page_id' => 1,
        ]);
        SectionTranslation::create([
	'cms_section_id'=>$homeSection2->id,
	'locale'=>'en',
	'title'=>"Why Your Business Doesn't Grow",
	'subtitle'=> '',
	'description'=>"Three critical gaps limiting your facility's growth and operational excellence.",
	]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection2->id,
	'locale'=>'ar',
	'title'=>'لماذا لا ينمو مؤسستك',
	'subtitle'=>'',
	'description'=>'ثلاث فجوات مهمة لا تقيد نمو مركزك والفعالية التشغيلية.',
	]);

// --------------------------

	$homeSection3 = Section::create([
            'name' => 'Home Page Section 3',
            'section_layout' => '3_items_in_row_section_style_2',
            'settings' => [],
            'order' => 3,
            'company_id' => 1,
            'page_id' => 1,
        ]);
        SectionTranslation::create([
	'cms_section_id'=>$homeSection3->id,
	'locale'=>'en',
	'title'=>'Our Core Pillars',
	'subtitle'=>'',
	'description'=>'Integrated solutions designed for exponential healthcare growth.',
	]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection3->id,
	'locale'=>'ar',
	'title'=>'العوامل الأساسية لدينا',
	'subtitle'=> '',
	'description'=>'الحلول المدمجة المصممة للنمو الطبي الأسي.',
	]);


// --------------------------

	$homeSection4 = Section::create([
            'name' => 'Home Page Section 4',
            'section_layout' => 'left_image_section_style_1',
            'settings' => [],
            'order' => 4,
            'company_id' => 1,
            'page_id' => 1,
        ]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection4->id,
	'locale'=>'en',
	'title'=>'The Support Plus 360 Growth Ecosystem',
	'subtitle'=>"",
	'description'=>"We don't just consult—we partner. Our integrated ecosystem covers every aspect of healthcare business growth.",
	]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection4->id,
	'locale'=>'ar',
	'title'=>'مجموعة النمو الطبي ل Support Plus 360',
	'subtitle'=>'',
	'description'=>"نحن لا نقدم فقط الاستشارات - بل نعمل كشركاء. مجموعتنا المدمجة يغطي كل جانب من جوانب نمو مركز الطب المهني.",
	]);

// --------------------------

	$homeSection5 = Section::create([
            'name' => 'Home Page Section 5',
            'section_layout' => 'two_items_in_row_section_style_1',
            'settings' => [],
            'order' => 5,
            'company_id' => 1,
            'page_id' => 1,
        ]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection5->id,
	'locale'=>'en',
	'title'=>'Clinical success stories',
	'subtitle'=>'',
	'description'=>'Real results from healthcare facilities transformed by our strategies.',
	]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection5->id,
	'locale'=>'ar',
	'title'=>'قصص نجاح العيادات الطبية',
	'subtitle'=> '',
	'description'=>'نتائج حقيقية من مراكز الطب المحولة باستراتيجياتنا.',
	]);

// --------------------------

	$homeSection6 = Section::create([
            'name' => 'Home Page Section 6',
            'section_layout' => 'right_testimonial_section',
            'settings' => [],
            'order' => 6,
            'company_id' => 1,
            'page_id' => 1,
        ]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection6->id,
	'locale'=>'en',
	'title'=>'Why the Elite',
	'subtitle'=>'Choose Support Plus',
	'description'=>'',
	]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection6->id,
	'locale'=>'ar',
	'title'=>'لماذا النخبة',
	'subtitle'=>'تختار Support Plus',
	'description'=>'',
	]);

// --------------------------

	$homeSection7 = Section::create([
            'name' => 'Home Page Section 7',
            'section_layout' => 'info_section',
            'settings' => [],
            'order' => 7,
            'company_id' => 1,
            'page_id' => 1,
        ]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection7->id,
	'locale'=>'en',
	'title'=>'Secure Your Clinical Dominance',
	'subtitle'=>'',
	'description'=>'Elite healthcare facilities are architecturing their strategies for sustained growth. Let\'s architect yours too.',
	]);

	SectionTranslation::create([
	'cms_section_id'=>$homeSection7->id,
	'locale'=>'ar',
	'title'=>'حماية مهارتك الطبية المهيمنة',
	'subtitle'=>'',
	'description'=>'مراكز الطب المهني المتميزة هي تصميم استراتيجياتها للنمو المستدام. دعنا نصمم استراتيجيتك أيضا.',
	]);

// -------------------------- end of home page sections ----------------------------------

// -------------------------- start of healthcare page sections ----------------------------------

	$healthcareSection1 = Section::create([
		'name' => 'Healthcare Page Section 1',
		'section_layout' => 'hero_section_style_1',
		'settings' => [],
		'order' => 1,
		'company_id' => 1,
		'page_id' => 2,
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection1->id,
		'locale' => 'en',
		'title' => 'Healthcare Facility Growth',
		'subtitle' => '',
		'description' => 'Specialized growth strategies designed for clinics, polyclinics, and hospitals. Transform patient acquisition, operational efficiency, and revenue.',
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection1->id,
		'locale' => 'ar',
		'title' => 'نمو مراكز الطب المهني',
		'subtitle' => '',
		'description' => 'استراتيجيات نمو مخصصة لمراكز الطب المهني. تحويل الحصول على المرضى، الفعالية التشغيلية، والإيرادات.',
	]);

// --------------------------

	$healthcareSection2 = Section::create([
		'name' => 'Healthcare Page Section 2',
		'section_layout' => 'right_image_section_style_1',
		'settings' => [],
		'order' => 2,
		'company_id' => 1,
		'page_id' => 2,
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection2->id,
		'locale' => 'en',
		'title' => 'Clinic Solutions',
		'subtitle' => '',
		'description' => 'Small clinics need agile strategies',
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection2->id,
		'locale' => 'ar',
		'title' => 'حلول العيادات الصغيرة',
		'subtitle' => '',
		'description' => 'العيادات الصغيرة يحتاجون إلى استراتيجيات ذكية',
	]);

// --------------------------

	$healthcareSection3 = Section::create([
		'name' => 'Healthcare Page Section 3',
		'section_layout' => 'left_image_section_style_2',
		'settings' => [],
		'order' => 3,
		'company_id' => 1,
		'page_id' => 2,
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection3->id,
		'locale' => 'en',
		'title' => 'Polyclinic Solutions',
		'subtitle' => '',
		'description' => 'Multi-specialty coordination at scale',
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection3->id,
		'locale' => 'ar',
		'title' => 'حلول العيادات المتعددة التخصصات',
		'subtitle' => '',
		'description' => 'التعاون المتعدد التخصصات على المستوى الكبير',
	]);

// --------------------------

	$healthcareSection4 = Section::create([
		'name' => 'Healthcare Page Section 4',
		'section_layout' => 'right_image_section_style_1',
		'settings' => [],
		'order' => 4,
		'company_id' => 1,
		'page_id' => 2,
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection4->id,
		'locale' => 'en',
		'title' => 'Hospital Solutions',
		'subtitle' => '',
		'description' => 'Enterprise-scale healthcare management',
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection4->id,
		'locale' => 'ar',
		'title' => 'حلول المستشفيات',
		'subtitle' => '',
		'description' => 'إدارة الرعاية الصحية الكبيرة',
	]);


// --------------------------

	$healthcareSection5 = Section::create([
		'name' => 'Healthcare Page Section 5',
		'section_layout' => 'testimonials_section_style_1',
		'settings' => [],
		'order' => 5,
		'company_id' => 1,
		'page_id' => 2,
	]);


	SectionTranslation::create([
		'cms_section_id' => $healthcareSection5->id,
		'locale' => 'en',
		'title' => 'Healthcare Leaders Trust Us',
		'subtitle' => '',
		'description' => 'Real testimonials from healthcare facility owners and administrators.',
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection5->id,
		'locale' => 'ar',
		'title' => 'تثق المرضى الطبيون بنا',
		'subtitle' => '',
		'description' => 'تقييمات حقيقية من أصحاب مراكز الطب والمديرين.',
	]);
// --------------------------



	$healthcareSection6 = Section::create([
		'name' => 'Healthcare Page Section 6',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 6,
		'company_id' => 1,
		'page_id' => 2,
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection6->id,
		'locale' => 'en',
		'title' => 'Ready to Transform Your Healthcare Facility?',
		'subtitle' => '',
		'description' => 'Schedule a free growth assessment to discover specific strategies for your facility type.',
	]);

	SectionTranslation::create([
		'cms_section_id' => $healthcareSection6->id,
		'locale' => 'ar',
		'title' => 'هل أنت مستعد لتحويل مركزك الطبي؟',
		'subtitle' => '',
		'description' => 'احجز استشارة مجانية للنمو لاكتشاف استراتيجيات مخصصة لنوع مركزك.',
	]);
// -------------------------- end of healthcare page sections ----------------------------------

// -------------------------- start of digital marketing page sections ----------------------------------

	$digitalMarketingSection1 = Section::create([
		'name' => 'Digital Marketing Page Section 1',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 1,
		'company_id' => 1,
		'page_id' => 3,
	]);

	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection1->id,
		'locale' => 'en',
		'title' => 'Digital Marketing & Performance',
		'subtitle' => '',
		'description' => 'Data-driven advertising and performance marketing to acquire patients and drive measurable business growth',
	]);


	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection1->id,
		'locale' => 'ar',
		'title' => 'التسويق الرقمي والأداء',
		'subtitle' => '',
		'description' => 'الإعلانات البحثية والتسويق الأداء لجذب المرضى وتحقيق نمو الأعمال القابل للقياس',
	]);

// --------------------------

	$digitalMarketingSection2 = Section::create([
		'name' => 'Digital Marketing Page Section 2',
		'section_layout' => '3_items_in_row_section_style_3',
		'settings' => [],
		'order' => 2,
		'company_id' => 1,
		'page_id' => 3,
	]);

	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection2->id,
		'locale' => 'en',
		'title' => 'Our Marketing Specializations',
		'subtitle' => '',
		'description' => '',
	]);

	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection2->id,
		'locale' => 'ar',
		'title' => 'التخصصات التسويقية لدينا',
		'subtitle' => '',
		'description' => '',
	]);

// --------------------------

	$digitalMarketingSection3 = Section::create([
		'name' => 'Digital Marketing Page Section 3',
		'section_layout' => 'list_in_columns_section_style_1',
		'settings' => [],
		'order' => 3,
		'company_id' => 1,
		'page_id' => 3,
	]);

	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection3->id,
		'locale' => 'en',
		'title' => '',
		'subtitle' => '',
		'description' => '',
	]);

	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection3->id,
		'locale' => 'ar',
		'title' => '',
		'subtitle' => '',
		'description' => '',
	]);

// --------------------------

	$digitalMarketingSection4 = Section::create([
		'name' => 'Digital Marketing Page Section 4',
		'section_layout' => 'steps_section_style_1',
		'settings' => [],
		'order' => 4,
		'company_id' => 1,
		'page_id' => 3,
	]);

	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection4->id,
		'locale' => 'en',
		'title' => 'Our Process',
		'subtitle' => '',
		'description' => '',
	]);

	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection4->id,
		'locale' => 'ar',
		'title' => 'عمليتنا',
		'subtitle' => '',
		'description' => '',
	]);

// --------------------------

	$digitalMarketingSection5 = Section::create([
		'name' => 'Digital Marketing Page Section 5',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 5,
		'company_id' => 1,
		'page_id' => 3,
	]);

	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection5->id,
		'locale' => 'en',
		'title' => 'Ready to Lower Your CAC?',
		'subtitle' => '',
		'description' => "Let's audit your current advertising performance and build a custom growth strategy",
	]);

	SectionTranslation::create([
		'cms_section_id' => $digitalMarketingSection5->id,
		'locale' => 'ar',
		'title' => 'هل أنت مستعد لتقليل تكلفة الحصول على المرضى؟',
		'subtitle' => '',
		'description' => 'دعنا نرحب بك للتحقق من أداء الإعلانات الحالية وبناء استراتيجية نمو مخصصة',
	]);

// -------------------------- end of digital marketing page sections ----------------------------------

// -------------------------- start of software house page sections ----------------------------------

	$softwareHouseSection1 = Section::create([
		'name' => 'Software House Page Section 1',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 1,
		'company_id' => 1,
		'page_id' => 4,
	]);

	SectionTranslation::create([
		'cms_section_id' => $softwareHouseSection1->id,
		'locale' => 'en',
		'title' => 'Software House Solutions',
		'subtitle' => '',
		'description' => 'Custom web and mobile platforms built specifically for healthcare growth and operational excellence',
	]);

	SectionTranslation::create([
		'cms_section_id' => $softwareHouseSection1->id,
		'locale' => 'ar',
		'title' => 'حلول البرمجيات المخصصة لمراكز الطب المهني',
		'subtitle' => '',
		'description' => 'المنصات الويب والمحمول المخصصة للنمو الطبي والفعالية التشغيلية',
	]);

// --------------------------

	$softwareHouseSection2 = Section::create([
		'name' => 'Software House Page Section 2',
		'section_layout' => '3_items_in_row_section_style_5',
		'settings' => [],
		'order' => 2,
		'company_id' => 1,
		'page_id' => 4,
	]);

	SectionTranslation::create([
		'cms_section_id' => $softwareHouseSection2->id,
		'locale' => 'en',
		'title' => 'Our Healthcare Software Suite',
		'subtitle' => '',
		'description' => '',
	]);

	SectionTranslation::create([
		'cms_section_id' => $softwareHouseSection2->id,
		'locale' => 'ar',
		'title' => 'مجموعة البرمجيات الطبية لدينا',
		'subtitle' => '',
		'description' => '',
	]);

// --------------------------

	$softwareHouseSection3 = Section::create([
		'name' => 'Software House Page Section 3',
		'section_layout' => 'list_in_columns_section_style_3',
		'settings' => [],
		'order' => 3,
		'company_id' => 1,
		'page_id' => 4,
	]);

	SectionTranslation::create([
		'cms_section_id' => $softwareHouseSection3->id,
		'locale' => 'en',
		'title' => 'Our Technology & Compliance',
		'subtitle' => '',
		'description' => '',
	]);

	SectionTranslation::create([
		'cms_section_id' => $softwareHouseSection3->id,
		'locale' => 'ar',
		'title' => 'التكنولوجيا والتوافق',
		'subtitle' => '',
		'description' => '',
	]);

// --------------------------

	$softwareHouseSection4 = Section::create([
		'name' => 'Software House Page Section 4',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 4,
		'company_id' => 1,
		'page_id' => 4,
	]);

	SectionTranslation::create([
		'cms_section_id' => $softwareHouseSection4->id,
		'locale' => 'en',
		'title' => 'Need a Custom Platform?',
		'subtitle' => '',
		'description' => "Let's discuss your technology requirements and build a solution that drives growth",
	]);

	SectionTranslation::create([
		'cms_section_id' => $softwareHouseSection4->id,
		'locale' => 'ar',
		'title' => 'هل تحتاج إلى منصة مخصصة؟',
		'subtitle' => '',
		'description' => 'دعنا نناقش متطلباتك التكنولوجية ونبني حلاً يقود النمو',
	]);
// -------------------------- end of software house page sections ----------------------------------

// -------------------------- start of call center page sections ----------------------------------

	$callCenterSection1 = Section::create([
		'name' => 'Call Center Page Section 1',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 1,
		'company_id' => 1,
		'page_id' => 5,
	]);

	SectionTranslation::create([
		'cms_section_id' => $callCenterSection1->id,
		'locale' => 'en',
		'title' => 'Call Center & Sales Conversion',
		'subtitle' => '',
		'description' => 'Patient follow-up, appointment booking, and lead qualification powered by trained specialists and technology integration',
	]);

	SectionTranslation::create([
		'cms_section_id' => $callCenterSection1->id,
		'locale' => 'ar',
		'title' => 'المركز الهاتفي وتحويل المبيعات',
		'subtitle' => '',
		'description' => 'متابعة المرضى، جدولة المواعيد، وتحديد القيمة المضافة من خلال التدريب المهني وتكامل التكنولوجيا',
	]);

// --------------------------

	$callCenterSection2 = Section::create([
		'name' => 'Call Center Page Section 2',
		'section_layout' => 'list_in_columns_section_style_2',
		'settings' => [],
		'order' => 2,
		'company_id' => 1,
		'page_id' => 5,
	]);

	SectionTranslation::create([
		'cms_section_id' => $callCenterSection2->id,
		'locale' => 'en',
		'title' => 'Our Medical Call Center Capabilities',
		'subtitle' => '',
		'description' => '',
	]);

	SectionTranslation::create([
		'cms_section_id' => $callCenterSection2->id,
		'locale' => 'ar',
		'title' => 'قدرات المركز الهاتفي الطبي لدينا',
		'subtitle' => '',
		'description' => '',
	]);

// --------------------------

	$callCenterSection3 = Section::create([
		'name' => 'Call Center Page Section 3',
		'section_layout' => '4_items_in_row_section',
		'settings' => [],
		'order' => 3,
		'company_id' => 1,
		'page_id' => 5,
	]);

	SectionTranslation::create([
		'cms_section_id' => $callCenterSection3->id,
		'locale' => 'en',
		'title' => 'Performance Metrics We Track',
		'subtitle' => '',
		'description' => '',
	]);

	SectionTranslation::create([
		'cms_section_id' => $callCenterSection3->id,
		'locale' => 'ar',
		'title' => 'القياسات الأدائية التي نتتبعها',
		'subtitle' => '',
		'description' => '',
	]);

// --------------------------

	$callCenterSection4 = Section::create([
		'name' => 'Call Center Page Section 4',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 4,
		'company_id' => 1,
		'page_id' => 5,
	]);

	SectionTranslation::create([
		'cms_section_id' => $callCenterSection4->id,
		'locale' => 'en',
		'title' => 'Improve Your Follow-Up Operations?',
		'subtitle' => '',
		'description' => "Let's assess your current call center performance and identify improvement opportunities",
	]);

	SectionTranslation::create([
		'cms_section_id' => $callCenterSection4->id,
		'locale' => 'ar',
		'title' => 'هل أنت مستعد لتحسين عمليات متابعة المرضى؟',
		'subtitle' => '',
		'description' => "دعنا نقيس أداء مركز الاتصال الحالي ونحدد الفرص للتحسين",
	]);
// -------------------------- end of call center page sections ----------------------------------

// -------------------------- start of services page sections ----------------------------------

	$servicesSection1 = Section::create([
		'name' => 'Services Page Section 1',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 1,
		'company_id' => 1,
		'page_id' => 6,
	]);

	SectionTranslation::create([
		'cms_section_id' => $servicesSection1->id,
		'locale' => 'en',
		'title' => 'Complete Healthcare Growth Services',
		'subtitle' => '',
		'description' => 'Integrated solutions covering digital marketing, software development, patient engagement, and operational optimization.',
	]);

	SectionTranslation::create([
		'cms_section_id' => $servicesSection1->id,
		'locale' => 'ar',
		'title' => 'خدمات النمو الطبي الشاملة',
		'subtitle' => '',
		'description' => 'الحلول المدمجة التي تغطي التسويق الرقمي، تطوير البرمجيات، تحسين المرضى، والتحسين التشغيلي.',
	]);

// --------------------------

	$servicesSection2 = Section::create([
		'name' => 'Services Page Section 2',
		'section_layout' => 'bundles_section',
		'settings' => [],
		'order' => 2,
		'company_id' => 1,
		'page_id' => 6,
	]);

	SectionTranslation::create([
		'cms_section_id' => $servicesSection2->id,
		'locale' => 'en',
		'title' => 'Recommended Service Bundles',
		'subtitle' => 'Strategic Packages',
		'description' => 'Proven combinations for specific growth stages.',
	]);

	SectionTranslation::create([
		'cms_section_id' => $servicesSection2->id,
		'locale' => 'ar',
		'title' => 'الحزم الخدمية الموصى بها',
		'subtitle' => 'الحزم الاستراتيجية',
		'description' => 'التوافقات المثبتة لمراحل النمو المخصصة.',
	]);

// --------------------------

	$servicesSection3 = Section::create([
		'name' => 'Services Page Section 3',
		'section_layout' => 'list_in_columns_section_style_4',
		'settings' => [],
		'order' => 3,
		'company_id' => 1,
		'page_id' => 6,
	]);

	SectionTranslation::create([
		'cms_section_id' => $servicesSection3->id,
		'locale' => 'en',
		'title' => 'Core Service Offerings',
		'subtitle' => '',
		'description' => 'Specialized services built for healthcare growth.',
	]);

	SectionTranslation::create([
		'cms_section_id' => $servicesSection3->id,
		'locale' => 'ar',
		'title' => 'الخدمات الأساسية المقدمة',
		'subtitle' => '',
		'description' => 'الخدمات المخصصة المبنية على النمو الطبي.',
	]);

// --------------------------

	$servicesSection4 = Section::create([
		'name' => 'Services Page Section 4',
		'section_layout' => 'testimonials_section_style_2',
		'settings' => [],
		'order' => 4,
		'company_id' => 1,
		'page_id' => 6,
	]);

	SectionTranslation::create([
		'cms_section_id' => $servicesSection4->id,
		'locale' => 'en',
		'title' => 'Why Choose Our Services',
		'subtitle' => '',
		'description' => 'Integrated approach designed specifically for healthcare growth.',
	]);

	SectionTranslation::create([
		'cms_section_id' => $servicesSection4->id,
		'locale' => 'ar',
		'title' => 'لماذا نختار خدماتنا',
		'subtitle' => '',
		'description' => 'النهج المدمج المصمم بشكل خاص للنمو الطبي.',
	]);

// -------------------------- end of services page sections ----------------------------------


// -------------------------- start of case studies page sections ----------------------------------

	$caseStudiesSection1 = Section::create([
		'name' => 'Case Studies Page Section 1',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 1,
		'company_id' => 1,
		'page_id' => 7,
	]);

	SectionTranslation::create([
		'cms_section_id' => $caseStudiesSection1->id,
		'locale' => 'en',
		'title' => 'Healthcare Success Stories',
		'subtitle' => '',
		'description' => 'Real results from healthcare facilities transformed by our strategic approach.',
	]);

	SectionTranslation::create([
		'cms_section_id' => $caseStudiesSection1->id,
		'locale' => 'ar',
		'title' => 'قصص نجاح مراكز الطب المهني',
		'subtitle' => '',
		'description' => 'نتائج حقيقية من مراكز الطب المحولة باستراتيجياتنا.',
	]);

// --------------------------


	$caseStudiesSection2 = Section::create([
		'name' => 'Case Studies Page Section 2',
		'section_layout' => 'case_study_section_style_1',
		'settings' => [],
		'order' => 2,
		'company_id' => 1,
		'page_id' => 7,
	]);

	SectionTranslation::create([
		'cms_section_id' => $caseStudiesSection2->id,
		'locale' => 'en',
		'title' => 'Case Studies',
		'subtitle' => '',
		'description' => '',
	]);

	SectionTranslation::create([
		'cms_section_id' => $caseStudiesSection2->id,
		'locale' => 'ar',
		'title' => 'الدراسات الميدانية',
		'subtitle' => '',
		'description' => '',
	]);


	$caseStudiesSection3 = Section::create([
		'name' => 'Case Studies Page Section 3',
		'section_layout' => '3_items_in_row_section_style_4',
		'settings' => [],
		'order' => 3,
		'company_id' => 1,
		'page_id' => 7,
	]);

	SectionTranslation::create([
		'cms_section_id' => $caseStudiesSection3->id,
		'locale' => 'en',
		'title' => 'Additional Success Stories',
		'subtitle' => '',
		'description' => 'Results from various healthcare facility types.',
	]);

	SectionTranslation::create([
		'cms_section_id' => $caseStudiesSection3->id,
		'locale' => 'ar',
		'title' => 'قصص نجاح إضافية',
		'subtitle' => '',
		'description' => 'نتائج من أنواع مختلفة من مراكز الطب.',
	]);


	$caseStudiesSection4 = Section::create([
		'name' => 'Case Studies Page Section 4',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 4,
		'company_id' => 1,
		'page_id' => 7,
	]);

	SectionTranslation::create([
		'cms_section_id' => $caseStudiesSection4->id,
		'locale' => 'en',
		'title' => 'Ready to Write Your Success Story?',
		'subtitle' => '',
		'description' => 'Schedule a free growth assessment and discover the strategies that transformed these healthcare facilities.
',
	]);

	SectionTranslation::create([
		'cms_section_id' => $caseStudiesSection4->id,
		'locale' => 'ar',
		'title' => 'هل أنت مستعد لكتابة قصتك النجاح؟',
		'subtitle' => '',
		'description' => 'احجز استشارة مجانية للنمو لاكتشاف استراتيجيات التحول التي حولت هذه مراكز الطب.',
	]);

// -------------------------- end of case studies page sections ----------------------------------

// -------------------------- start of contact page sections ----------------------------------

	$contactSection1 = Section::create([
		'name' => 'Contact Page Section 1',
		'section_layout' => 'info_section',
		'settings' => [],
		'order' => 1,
		'company_id' => 1,
		'page_id' => 8,
	]);

    SectionTranslation::create([
		'cms_section_id' => $contactSection1->id,
		'locale' => 'en',
		'title' => 'Contact Us',
		'subtitle' => '',
		'description' => 'Ready to grow your healthcare business? Let’s discuss your growth strategy.',
	]);

    SectionTranslation::create([
		'cms_section_id' => $contactSection1->id,
		'locale' => 'ar',
		'title' => 'تواصل معنا',
		'subtitle' => '',
		'description' => 'هل أنت مستعد لتنمية منشأتك الصحية؟ لنتحدث عن استراتيجية النمو.',
	]);

}
}
