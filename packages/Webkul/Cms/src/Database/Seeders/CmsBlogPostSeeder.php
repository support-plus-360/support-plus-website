<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Webkul\Cms\Models\BlogCategory;
use Webkul\Cms\Models\BlogPost;

class CmsBlogPostSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = BlogCategory::query()->pluck('id', 'slug');

        foreach ($this->companyPosts() as $companyId => $config) {
            foreach ($config['posts'] as $index => $post) {
                $categorySlug = $config['prefix'].'-'.$post['category_slug'];
                $categoryId = $categoryIds->get($categorySlug);

                if (! $categoryId) {
                    continue;
                }

                $slug = $config['prefix'].'-'.$post['slug'];
                $publishedAt = Carbon::now()->subDays(($index + 1) * 3);

                $blogPost = BlogPost::create([
                    'slug'                 => $slug,
                    'status'               => 'published',
                    'is_active'            => true,
                    'order'                => $index + 1,
                    'company_id'           => $companyId,
                    'author_name'          => 'Support Plus',
                    'published_at'         => $publishedAt,
                    'views_count'          => random_int(50, 2500),
                    'is_featured'          => $post['is_featured'] ?? false,
                    'reading_time_minutes' => $post['reading_time_minutes'] ?? 5,
                    'allow_comments'       => false,
                    'is_indexable'         => true,
                    'en'                   => [
                        'title'            => $post['en']['title'],
                        'excerpt'          => $post['en']['excerpt'],
                        'content'          => $post['en']['content'],
                        'meta_title'       => $post['en']['meta_title'],
                        'meta_description' => $post['en']['meta_description'],
                        'meta_keywords'    => $post['en']['meta_keywords'],
                    ],
                    'ar'                   => [
                        'title'            => $post['ar']['title'],
                        'excerpt'          => $post['ar']['excerpt'],
                        'content'          => $post['ar']['content'],
                        'meta_title'       => $post['ar']['meta_title'],
                        'meta_description' => $post['ar']['meta_description'],
                        'meta_keywords'    => $post['ar']['meta_keywords'],
                    ],
                ]);

                $blogPost->blogCategories()->sync([$categoryId]);
            }
        }
    }

    /**
     * @return array<int, array{prefix: string, posts: array<int, array<string, mixed>>}>
     */
    protected function companyPosts(): array
    {
        return [
            1 => [
                'prefix' => 'support-plus',
                'posts'  => $this->supportPlusPosts(),
            ],
            2 => [
                'prefix' => 'mena-support',
                'posts'  => $this->menaSupportPosts(),
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function supportPlusPosts(): array
    {
        return [
            $this->post(
                'global-bpo-market-growth-2026',
                'industry-news',
                'Global BPO Market Growth in 2026',
                'نمو سوق التعهيد العالمي في 2026',
                'The business process outsourcing market continues to expand as companies prioritize cost efficiency and specialized expertise.',
                'يواصل سوق ت outsourcing النمو مع تركيز الشركات على الكفاءة والخبرة المتخصصة.',
                'BPO market trends, outsourcing growth, customer support industry',
                true,
                6,
            ),
            $this->post(
                'ai-transforming-contact-centers',
                'industry-news',
                'How AI Is Transforming Contact Centers',
                'كيف يغير الذكاء الاصطناعي مراكز الاتصال',
                'From intelligent routing to sentiment analysis, AI is reshaping how support teams operate at scale.',
                'من التوجيه الذكي إلى تحليل المشاعر، يغير الذكاء الاصطناعي عمل فرق الدعم على نطاق واسع.',
                'AI contact center, automation, customer support AI',
                false,
                7,
            ),
            $this->post(
                'building-empathetic-support-teams',
                'customer-experience',
                'Building Empathetic Support Teams',
                'بناء فرق دعم متعاطفة',
                'Empathy training and quality frameworks help agents resolve issues while strengthening customer loyalty.',
                'تساعد تدريبات التعاطف ومعايير الجودة الوكلاء على حل المشكلات وتعزيز ولاء العملاء.',
                'customer empathy, support training, CX best practices',
                false,
                5,
            ),
            $this->post(
                'omnichannel-customer-journey',
                'customer-experience',
                'Designing an Omnichannel Customer Journey',
                'تصميم رحلة عميل متعددة القنوات',
                'Customers expect seamless transitions between chat, email, phone, and social — consistency is key.',
                'يتوقع العملاء انتقالات سلسة بين الدردشة والبريد والهاتف ووسائل التواصل — الاتساق هو المفتاح.',
                'omnichannel CX, customer journey, support channels',
                false,
                6,
            ),
            $this->post(
                'hipaa-compliant-patient-support',
                'healthcare-bpo',
                'HIPAA-Compliant Patient Support Operations',
                'عمليات دعم المرضى المتوافقة مع HIPAA',
                'Healthcare outsourcing requires strict data handling, staff training, and audit-ready processes.',
                'يتطلب التعهيد في الرعاية الصحية التعامل الصارم مع البيانات وتدريب الموظفين وعمليات جاهزة للتدقيق.',
                'healthcare BPO, HIPAA, patient support',
                false,
                8,
            ),
            $this->post(
                'reducing-patient-wait-times',
                'healthcare-bpo',
                'Reducing Patient Wait Times with Smart Scheduling',
                'تقليل أوقات انتظار المرضى عبر الجدولة الذكية',
                'Optimized scheduling and triage workflows can significantly improve patient satisfaction scores.',
                'يمكن للجدولة المحسّنة وسير عمل الفرز تحسين درجات رضا المرضى بشكل ملحوظ.',
                'patient scheduling, healthcare CX, wait time reduction',
                false,
                5,
            ),
            $this->post(
                'seo-strategies-for-b2b-leads',
                'digital-marketing',
                'SEO Strategies That Drive B2B Leads',
                'استراتيجيات SEO لتوليد عملاء B2B',
                'Technical SEO, content clusters, and localized landing pages remain essential for B2B visibility.',
                'يظل SEO التقني ومجموعات المحتوى والصفحات المقصودة المحلية أساسية لظهور B2B.',
                'B2B SEO, lead generation, content marketing',
                false,
                6,
            ),
            $this->post(
                'social-media-roi-measurement',
                'digital-marketing',
                'Measuring Social Media ROI for Service Brands',
                'قياس عائد الاستثمار في التسويق عبر وسائل التواصل',
                'Attribution models and conversion tracking help marketing teams prove campaign value.',
                'تساعد نماذج الإسناد وتتبع التحويل فرق التسويق على إثبات قيمة الحملات.',
                'social media ROI, marketing analytics, service brands',
                false,
                5,
            ),
            $this->post(
                'custom-software-for-call-centers',
                'technology-insights',
                'Custom Software Solutions for Call Centers',
                'حلول برمجية مخصصة لمراكز الاتصال',
                'Tailored dashboards, CRM integrations, and workflow tools boost agent productivity.',
                'تعزز لوحات المعلومات المخصصة وتكامل CRM وأدوات سير العمل إنتاجية الوكلاء.',
                'call center software, custom development, CRM integration',
                false,
                7,
            ),
            $this->post(
                'cloud-migration-lessons',
                'technology-insights',
                'Lessons from Our Cloud Migration Journey',
                'دروس من رحلتنا في الانتقال إلى السحابة',
                'A phased approach to cloud adoption minimized downtime and improved system resilience.',
                'قلل نهج المراحل في اعتماد السحابة من وقت التوقف وتحسّن مرونة الأنظمة.',
                'cloud migration, infrastructure, digital transformation',
                false,
                6,
            ),
            $this->post(
                'support-plus-expands-healthcare-team',
                'company-updates',
                'Support Plus Expands Healthcare Support Team',
                'Support Plus توسّع فريق دعم الرعاية الصحية',
                'We welcomed 120 new specialists to strengthen our HIPAA-compliant patient support capacity.',
                'رحّبنا بـ 120 متخصصًا جديدًا لتعزيز قدرتنا على دعم المرضى المتوافق مع HIPAA.',
                'Support Plus news, healthcare team, company growth',
                false,
                4,
            ),
            $this->post(
                'award-winning-customer-service-2025',
                'company-updates',
                'Award-Winning Customer Service in 2025',
                'خدمة عملاء حائزة على جوائز في 2025',
                'Support Plus was recognized for excellence in multilingual customer support across three regions.',
                'حصلت Support Plus على تقدير للتميز في دعم العملاء متعدد اللغات عبر ثلاث مناطق.',
                'awards, customer service excellence, Support Plus',
                false,
                4,
            ),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function menaSupportPosts(): array
    {
        return [
            $this->post(
                'mena-customer-support-landscape',
                'regional-insights',
                'The MENA Customer Support Landscape',
                'مشهد دعم العملاء في منطقة الشرق الأوسط وشمال أفريقيا',
                'Rising digital adoption across MENA is driving demand for Arabic-first, 24/7 support operations.',
                'يدفع الاعتماد الرقمي المتزايد في المنطقة الطلب على عمليات دعم بالعربية على مدار الساعة.',
                'MENA support, Arabic customer service, regional CX',
                true,
                6,
            ),
            $this->post(
                'localizing-support-for-gulf-markets',
                'regional-insights',
                'Localizing Support for Gulf Markets',
                'توطين الدعم لأسواق الخليج',
                'Cultural nuance and dialect awareness improve resolution rates in Gulf customer interactions.',
                'تحسّن الفروق الثقافية والوعي باللهجات معدلات حل التفاعلات مع عملاء الخليج.',
                'Gulf markets, localization, Arabic dialects',
                false,
                5,
            ),
            $this->post(
                'choosing-right-bpo-partner',
                'outsourcing-best-practices',
                'How to Choose the Right BPO Partner',
                'كيفية اختيار شريك التعهيد المناسب',
                'Evaluate SLAs, security posture, language capabilities, and scalability before signing contracts.',
                'قيّم اتفاقيات مستوى الخدمة والأمان واللغات والقدرة على التوسع قبل توقيع العقود.',
                'BPO partner selection, outsourcing checklist',
                false,
                7,
            ),
            $this->post(
                'sla-frameworks-that-work',
                'outsourcing-best-practices',
                'SLA Frameworks That Actually Work',
                'اتفاقيات مستوى خدمة فعّالة فعلاً',
                'Clear KPIs, escalation paths, and quarterly reviews keep outsourced teams aligned with business goals.',
                'تحافظ مؤشرات الأداء الواضحة ومسارات التصعيد والمراجعات الربع سنوية على توافق الفرق مع الأهداف.',
                'SLA management, outsourcing KPIs, vendor management',
                false,
                6,
            ),
            $this->post(
                'retention-through-proactive-support',
                'customer-success',
                'Retention Through Proactive Support',
                'الاحتفاظ بالعملاء عبر الدعم الاستباقي',
                'Anticipating issues before customers escalate reduces churn and increases lifetime value.',
                'توقع المشكلات قبل تصعيد العملاء يقلل التسرب ويزيد القيمة مدى الحياة.',
                'customer retention, proactive support, churn reduction',
                false,
                5,
            ),
            $this->post(
                'onboarding-clients-for-long-term-success',
                'customer-success',
                'Onboarding Clients for Long-Term Success',
                'إعداد العملاء لنجاح طويل الأمد',
                'Structured onboarding playbooks set expectations and accelerate time-to-value for new accounts.',
                'تضع أدلة الإعداد المنظمة التوقعات وتسرّع تحقيق القيمة للحسابات الجديدة.',
                'client onboarding, customer success, BPO onboarding',
                false,
                6,
            ),
            $this->post(
                'contact-center-automation-trends',
                'industry-trends',
                'Contact Center Automation Trends to Watch',
                'اتجاهات أتمتة مراكز الاتصال التي يجب متابعتها',
                'Workflow automation, AI copilots, and self-service portals are reshaping tier-1 support.',
                'تغيّر أتمتة سير العمل ومساعدي الذكاء الاصطناعي وبوابات الخدمة الذاتية دعم المستوى الأول.',
                'contact center automation, AI trends, self-service',
                false,
                7,
            ),
            $this->post(
                'remote-work-in-support-operations',
                'industry-trends',
                'Remote Work in Modern Support Operations',
                'العمل عن بُعد في عمليات الدعم الحديثة',
                'Hybrid models balance flexibility with quality monitoring and team collaboration needs.',
                'توازن النماذج الهجينة بين المرونة ومراقبة الجودة وحاجات التعاون بين الفريق.',
                'remote support teams, hybrid work, contact center',
                false,
                5,
            ),
            $this->post(
                'scaling-support-during-peak-season',
                'workforce-management',
                'Scaling Support Teams During Peak Season',
                'توسيع فرق الدعم خلال موسم الذروة',
                'Forecasting, cross-training, and flexible staffing models prevent SLA breaches during spikes.',
                'تمنع التنبؤ والتدريب المتقاطع ونماذج التوظيف المرنة خرق اتفاقيات الخدمة أثناء الذروة.',
                'workforce planning, peak season, staffing',
                false,
                6,
            ),
            $this->post(
                'agent-training-program-best-practices',
                'workforce-management',
                'Agent Training Program Best Practices',
                'أفضل ممارسات برامج تدريب الوكلاء',
                'Blended learning, simulation labs, and continuous coaching improve first-contact resolution.',
                'يحسّن التعلم المدمج ومعامل المحاكاة والتوجيه المستمر حل المشكلة في أول اتصال.',
                'agent training, contact center coaching, FCR',
                false,
                6,
            ),
            $this->post(
                'mena-support-new-cairo-office',
                'company-news',
                'Mena Support Opens New Cairo Operations Hub',
                'Mena Support تفتح مركز عمليات جديد في القاهرة',
                'The new hub adds capacity for Arabic and English support across finance and telecom verticals.',
                'يضيف المركز الجديد القدرة على دعم العربية والإنجليزية في قطاعات المالية والاتصالات.',
                'Mena Support news, Cairo office, expansion',
                false,
                4,
            ),
            $this->post(
                'partnership-with-regional-fintech',
                'company-news',
                'Partnership with Leading Regional Fintech',
                'شراكة مع شركة fintech إقليمية رائدة',
                'Mena Support will provide 24/7 multilingual support for a fast-growing digital banking platform.',
                'ستوفر Mena Support دعمًا متعدد اللغات على مدار الساعة لمنصة بنكية رقمية سريعة النمو.',
                'Mena Support partnership, fintech support, company news',
                false,
                4,
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function post(
        string $slug,
        string $categorySlug,
        string $enTitle,
        string $arTitle,
        string $enExcerpt,
        string $arExcerpt,
        string $metaKeywords,
        bool $isFeatured = false,
        int $readingTime = 5,
    ): array {
        $enContent = $enExcerpt.' '.$this->loremEn();
        $arContent = $arExcerpt.' '.$this->loremAr();

        return [
            'slug'                  => $slug,
            'category_slug'         => $categorySlug,
            'is_featured'           => $isFeatured,
            'reading_time_minutes'  => $readingTime,
            'en'                    => [
                'title'            => $enTitle,
                'excerpt'          => $enExcerpt,
                'content'          => $enContent,
                'meta_title'       => $enTitle,
                'meta_description' => $enExcerpt,
                'meta_keywords'    => $metaKeywords,
            ],
            'ar'                    => [
                'title'            => $arTitle,
                'excerpt'          => $arExcerpt,
                'content'          => $arContent,
                'meta_title'       => $arTitle,
                'meta_description' => $arExcerpt,
                'meta_keywords'    => $metaKeywords,
            ],
        ];
    }

    protected function loremEn(): string
    {
        return 'Organizations that invest in structured processes, measurable outcomes, and continuous improvement '
            .'see stronger customer satisfaction and operational efficiency over time. '
            .'This article explores practical steps teams can adopt immediately.';
    }

    protected function loremAr(): string
    {
        return 'المنظمات التي تستثمر في عمليات منظمة ونتائج قابلة للقياس والتحسين المستمر '
            .'تحقق رضا عملاء أقوى وكفاءة تشغيلية بمرور الوقت. '
            .'تستكشف هذه المقالة خطوات عملية يمكن للفرق تطبيقها فورًا.';
    }
}
