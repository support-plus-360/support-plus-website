<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webkul\Cms\Contracts\BlogPost as BlogPostContract;
use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\Company\Models\Company;

class BlogPost extends TranslatableModel implements BlogPostContract
{
    use SoftDeletes;

    protected $table = 'cms_blog_posts';

    public array $translatedAttributes = [
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
    ];

    protected $translationModel = BlogPostTranslation::class;

    protected $translationForeignKey = 'cms_blog_post_id';

    protected $fillable = [
        'slug',
        'status',
        'published_at',
        'author_id',
        'is_featured',
        'reading_time_minutes',
        'allow_comments',
        'views_count',
        'canonical_url',
        'is_indexable',
        'is_active',
        'order',
        'company_id',
    ];

    protected $casts = [
        'is_active'            => 'boolean',
        'is_featured'          => 'boolean',
        'published_at'         => 'datetime',
        'allow_comments'       => 'boolean',
        'views_count'          => 'integer',
        'is_indexable'         => 'boolean',
        'reading_time_minutes' => 'integer',
        'order'                => 'integer',
    ];

    public function blogCategories(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogCategory::class,
            'cms_blog_category_post',
            'cms_blog_post_id',
            'cms_blog_category_id'
        );
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
