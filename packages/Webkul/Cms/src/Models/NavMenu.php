<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Webkul\Cms\Contracts\NavMenu as NavMenuContract;
use Webkul\Company\Models\Company;

class NavMenu extends Model implements NavMenuContract
{
    use SoftDeletes;

    protected $table = 'cms_nav_menus';

    protected $fillable = [
        'company_id',
        'key',
        'name',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(NavItem::class, 'menu_id')
            ->orderBy('order');
    }

    public function rootItems(): HasMany
    {
        return $this->items()->whereNull('parent_id');
    }
}
