<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webkul\Cms\Contracts\Link as LinkContract;
use Webkul\Core\Eloquent\TranslatableModel;

class Link extends TranslatableModel implements LinkContract
{
    use SoftDeletes;

    protected $table = 'cms_links';

    /**
     * Astrotomic\Translatable config.
     */
    public array $translatedAttributes = [
        'name',
    ];

    protected $translationModel = LinkTranslation::class;

    protected $translationForeignKey = 'cms_link_id';

    protected $fillable = [
        'linkable_id',
        'linkable_type',
        'name',
        'type',
        'link',
        'icon',
        'target',
        'order',
        'is_active',
        'company_id',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'order'        => 'integer',
    ];

    public function linkable(): BelongsTo
    {
        return $this->morphTo();
    }


}