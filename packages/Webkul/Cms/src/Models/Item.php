<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Webkul\Cms\Contracts\Item as ItemContract;
use Webkul\Core\Eloquent\TranslatableModel;
use Webkul\Company\Models\Company;

class Item extends TranslatableModel implements HasMedia, ItemContract
{
    use InteractsWithMedia, SoftDeletes;

    protected $table = 'cms_items';

    /**
     * Astrotomic\Translatable config.
     */
    public array $translatedAttributes = [
        'title',
        'sub_title',
        'content',
        'icon',
    ];

    protected $translationModel = ItemTranslation::class;

    protected $translationForeignKey = 'cms_item_id';

    protected $fillable = [
        'section_id',
        'type',
        'settings',
        'order',
        'is_active',
        'company_id',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'order'        => 'integer',
        'settings'     => 'array',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function links(): MorphMany
    {
        return $this->morphMany(Link::class, 'linkable')->orderBy('order');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_media')->singleFile();
        $this->addMediaCollection('gallery');
    }
}
