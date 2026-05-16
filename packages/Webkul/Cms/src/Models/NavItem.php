<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Webkul\Cms\Contracts\NavItem as NavItemContract;
use Webkul\Core\Eloquent\TranslatableModel;

class NavItem extends TranslatableModel implements NavItemContract
{
    use SoftDeletes;

    protected $table = 'cms_nav_items';

    public array $translatedAttributes = [
        'label',
    ];

    protected $translationModel = NavItemTranslation::class;

    protected $translationForeignKey = 'cms_nav_item_id';

    protected $fillable = [
        'menu_id',
        'parent_id',
        'cms_page_id',
        'url',
        'order',
        'is_active',
        'open_in_new_tab',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'open_in_new_tab'  => 'boolean',
        'order'            => 'integer',
    ];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(NavMenu::class, 'menu_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'cms_page_id');
    }
}
