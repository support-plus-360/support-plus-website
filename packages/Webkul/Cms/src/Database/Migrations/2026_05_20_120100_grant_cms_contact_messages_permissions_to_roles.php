<?php

use Illuminate\Database\Migrations\Migration;
use Webkul\User\Models\Role;

return new class extends Migration
{
    /**
     * @var list<string>
     */
    protected array $contactPermissions = [
        'cms.contact-messages',
        'cms.contact-messages.delete',
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

            $role->permissions = array_values(array_unique(array_merge($permissions, $this->contactPermissions)));
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

            $role->permissions = array_values(array_diff($permissions, $this->contactPermissions));
            $role->save();
        });
    }
};
