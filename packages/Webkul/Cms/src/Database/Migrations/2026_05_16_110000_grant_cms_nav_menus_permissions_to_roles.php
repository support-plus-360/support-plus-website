<?php

use Illuminate\Database\Migrations\Migration;
use Webkul\User\Models\Role;

return new class extends Migration
{
    /**
     * @var list<string>
     */
    protected array $navPermissions = [
        'cms.nav-menus',
        'cms.nav-menus.create',
        'cms.nav-menus.edit',
        'cms.nav-menus.delete',
        'cms.nav-menus.restore',
        'cms.nav-menus.forceDelete',
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

            $role->permissions = array_values(array_unique(array_merge($permissions, $this->navPermissions)));
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

            $role->permissions = array_values(array_diff($permissions, $this->navPermissions));
            $role->save();
        });
    }
};
