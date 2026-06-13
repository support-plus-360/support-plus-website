<?php

use Illuminate\Database\Migrations\Migration;
use Webkul\User\Models\Role;

return new class extends Migration
{
    /**
     * @var list<string>
     */
    protected array $permissions = [
        'cms.case-study-categories',
        'cms.case-study-categories.create',
        'cms.case-study-categories.edit',
        'cms.case-study-categories.delete',
        'cms.case-study-categories.restore',
        'cms.case-study-categories.forceDelete',
        'cms.case-studies',
        'cms.case-studies.create',
        'cms.case-studies.edit',
        'cms.case-studies.delete',
        'cms.case-studies.restore',
        'cms.case-studies.forceDelete',
    ];

    public function up(): void
    {
        Role::query()->where('permission_type', 'custom')->each(function (Role $role) {
            $permissions = $role->permissions ?? [];

            if (! is_array($permissions)) {
                return;
            }

            $hasCmsAccess = collect($permissions)->contains(
                fn ($permission) => is_string($permission) && str_starts_with($permission, 'cms.')
            );

            if (! $hasCmsAccess) {
                return;
            }

            $role->permissions = array_values(array_unique(array_merge($permissions, $this->permissions)));
            $role->save();
        });
    }

    public function down(): void
    {
        Role::query()->where('permission_type', 'custom')->each(function (Role $role) {
            $permissions = $role->permissions ?? [];

            if (! is_array($permissions)) {
                return;
            }

            $role->permissions = array_values(array_diff($permissions, $this->permissions));
            $role->save();
        });
    }
};
