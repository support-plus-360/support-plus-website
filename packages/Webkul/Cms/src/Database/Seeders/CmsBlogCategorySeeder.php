<?php

namespace Webkul\Cms\Database\Seeders;

use Illuminate\Database\Seeder;
use Webkul\Cms\Models\BlogCategory;

class CmsBlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->companyCategories() as $companyId => $config) {
            foreach ($config['categories'] as $order => $category) {
                BlogCategory::create([
                    'name'       => $category['name'],
                    'slug'       => $config['prefix'].'-'.$category['slug'],
                    'is_active'  => true,
                    'order'      => $order + 1,
                    'company_id' => $companyId,
                    'en'         => [
                        'title'       => $category['en']['title'],
                        'description' => $category['en']['description'],
                    ],
                    'ar'         => [
                        'title'       => $category['ar']['title'],
                        'description' => $category['ar']['description'],
                    ],
                ]);
            }
        }
    }

    /**
     * @return array<int, array{prefix: string, categories: array<int, array<string, mixed>>}>
     */
    protected function companyCategories(): array
    {
        return [
            1 => [
                'prefix'     => 'support-plus',
                'categories' => [
                    [
                        'slug' => 'industry-news',
                        'name' => 'Industry News',
                        'en'   => [
                            'title'       => 'Industry News',
                            'description' => 'Latest trends and updates from the BPO and customer support industry.',
                        ],
                        'ar'   => [
                            'title'       => 'أخبار الصناعة',
                            'description' => 'أحدث الاتجاهات والتحديثات في صناعة خدمات العملاء ومراكز الاتصال.',
                        ],
                    ],
                    [
                        'slug' => 'customer-experience',
                        'name' => 'Customer Experience',
                        'en'   => [
                            'title'       => 'Customer Experience',
                            'description' => 'Strategies and insights for delivering exceptional customer experiences.',
                        ],
                        'ar'   => [
                            'title'       => 'تجربة العملاء',
                            'description' => 'استراتيجيات ورؤى لتقديم تجارب عملاء متميزة.',
                        ],
                    ],
                    [
                        'slug' => 'healthcare-bpo',
                        'name' => 'Healthcare BPO',
                        'en'   => [
                            'title'       => 'Healthcare BPO',
                            'description' => 'Best practices for healthcare outsourcing and patient support services.',
                        ],
                        'ar'   => [
                            'title'       => 'خدمات العملاء في الرعاية الصحية',
                            'description' => 'أفضل الممارسات للتعهيد في الرعاية الصحية ودعم المرضى.',
                        ],
                    ],
                    [
                        'slug' => 'digital-marketing',
                        'name' => 'Digital Marketing',
                        'en'   => [
                            'title'       => 'Digital Marketing',
                            'description' => 'Tips on SEO, social media, content marketing, and lead generation.',
                        ],
                        'ar'   => [
                            'title'       => 'التسويق الرقمي',
                            'description' => 'نصائح حول تحسين محركات البحث، التسويق عبر وسائل التواصل، وتوليد العملاء.',
                        ],
                    ],
                    [
                        'slug' => 'technology-insights',
                        'name' => 'Technology Insights',
                        'en'   => [
                            'title'       => 'Technology Insights',
                            'description' => 'Software development, automation, and digital transformation topics.',
                        ],
                        'ar'   => [
                            'title'       => 'رؤى تقنية',
                            'description' => 'مواضيع تطوير البرمجيات، الأتمتة، والتحول الرقمي.',
                        ],
                    ],
                    [
                        'slug' => 'company-updates',
                        'name' => 'Company Updates',
                        'en'   => [
                            'title'       => 'Company Updates',
                            'description' => 'News, milestones, and announcements from Support Plus.',
                        ],
                        'ar'   => [
                            'title'       => 'أخبار الشركة',
                            'description' => 'أخبار وإنجازات وإعلانات من Support Plus.',
                        ],
                    ],
                ],
            ],
            2 => [
                'prefix'     => 'mena-support',
                'categories' => [
                    [
                        'slug' => 'regional-insights',
                        'name' => 'Regional Insights',
                        'en'   => [
                            'title'       => 'Regional Insights',
                            'description' => 'Perspectives on customer support across the MENA region.',
                        ],
                        'ar'   => [
                            'title'       => 'رؤى إقليمية',
                            'description' => 'رؤى حول دعم العملاء في منطقة الشرق الأوسط وشمال أفريقيا.',
                        ],
                    ],
                    [
                        'slug' => 'outsourcing-best-practices',
                        'name' => 'Outsourcing Best Practices',
                        'en'   => [
                            'title'       => 'Outsourcing Best Practices',
                            'description' => 'Guidance on selecting partners and managing outsourced operations.',
                        ],
                        'ar'   => [
                            'title'       => 'أفضل ممارسات التعهيد',
                            'description' => 'إرشادات لاختيار الشركاء وإدارة العمليات المُعهَدة.',
                        ],
                    ],
                    [
                        'slug' => 'customer-success',
                        'name' => 'Customer Success',
                        'en'   => [
                            'title'       => 'Customer Success',
                            'description' => 'Stories and tactics for retaining and growing customer relationships.',
                        ],
                        'ar'   => [
                            'title'       => 'نجاح العملاء',
                            'description' => 'قصص وتكتيكات للاحتفاظ بالعملاء وتنمية علاقاتهم.',
                        ],
                    ],
                    [
                        'slug' => 'industry-trends',
                        'name' => 'Industry Trends',
                        'en'   => [
                            'title'       => 'Industry Trends',
                            'description' => 'Emerging trends shaping contact centers and support services.',
                        ],
                        'ar'   => [
                            'title'       => 'اتجاهات الصناعة',
                            'description' => 'الاتجاهات الناشئة التي تشكل مراكز الاتصال وخدمات الدعم.',
                        ],
                    ],
                    [
                        'slug' => 'workforce-management',
                        'name' => 'Workforce Management',
                        'en'   => [
                            'title'       => 'Workforce Management',
                            'description' => 'Hiring, training, and scaling support teams effectively.',
                        ],
                        'ar'   => [
                            'title'       => 'إدارة القوى العاملة',
                            'description' => 'التوظيف والتدريب وتوسيع فرق الدعم بفعالية.',
                        ],
                    ],
                    [
                        'slug' => 'company-news',
                        'name' => 'Company News',
                        'en'   => [
                            'title'       => 'Company News',
                            'description' => 'Updates and announcements from Mena Support.',
                        ],
                        'ar'   => [
                            'title'       => 'أخبار الشركة',
                            'description' => 'تحديثات وإعلانات من Mena Support.',
                        ],
                    ],
                ],
            ],
        ];
    }
}
