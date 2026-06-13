<?php

use Illuminate\Database\Migrations\Migration;
use Webkul\User\Models\Role;

return new class extends Migration
{
    /**
     * @var list<string>
     */
    protected array $permissions = [
        'cms.service-types',
        'cms.service-types.create',
        'cms.service-types.edit',
        'cms.service-types.delete',
        'cms.service-types.restore',
        'cms.service-types.forceDelete',
        'cms.services',
        'cms.services.create',
        'cms.services.edit',
        'cms.services.delete',
        'cms.services.restore',
        'cms.services.forceDelete',
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
