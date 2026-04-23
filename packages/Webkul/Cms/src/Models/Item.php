<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webkul\Cms\Contracts\Item as ItemContract;
use Webkul\Core\Eloquent\TranslatableModel;

class Item extends TranslatableModel implements ItemContract
{
    use SoftDeletes;

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
        'order',
        'is_active',
        'company_id',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'order'        => 'integer',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}

