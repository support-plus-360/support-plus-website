<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webkul\Cms\Contracts\Page as PageContract;
use Webkul\Core\Eloquent\TranslatableModel;

class Page extends TranslatableModel implements PageContract
{
    use SoftDeletes;

    protected $table = 'cms_pages';

    /**
     * Astrotomic\Translatable config.
     */
    public array $translatedAttributes = [
        'title',
        'meta_description',
        'meta_keywords',
    ];

    protected $translationModel = PageTranslation::class;

    protected $translationForeignKey = 'cms_page_id';

    protected $fillable = [
        'slug',
        'name',
        'is_active',
        'order',
        'type',
        'status',
        'published_at',
        'author_id',
        'company_id',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'order'        => 'integer',
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

