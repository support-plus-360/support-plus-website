<?php

namespace Webkul\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Company\Models\Company;

class ContactMessage extends Model
{
    /**
     * @var string
     */
    protected $table = 'cms_contact_messages';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'phone',
        'message',
    ];

    /**
     * @return BelongsTo<Company, ContactMessage>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
