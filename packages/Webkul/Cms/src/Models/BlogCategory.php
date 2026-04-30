<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Webkul\Cms\Contracts\BlogCategory as BlogCategoryContract;
use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\Company\Models\Company;

class BlogCategory extends TranslatableModel implements HasMedia, BlogCategoryContract
{
    use InteractsWithMedia, SoftDeletes;

    protected $table = 'cms_blog_categories';

    /**
     * Astrotomic\Translatable config.
     */
    public array $translatedAttributes = [
        'title',
        'description',
    ];

    protected $translationModel = BlogCategoryTranslation::class;

    protected $translationForeignKey = 'cms_blog_category_id';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'order',
        'company_id',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'order'        => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function blogPosts(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogPost::class,
            'cms_blog_category_post',
            'cms_blog_category_id',
            'cms_blog_post_id'
        );
    }
}

