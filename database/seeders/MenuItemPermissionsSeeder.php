<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MenuItemPermission;
use Illuminate\Database\Seeder;
use Shopper\Models\Permission;
use Shopper\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class MenuItemPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        Permission::generate('menu_items');

        $permissions = MenuItemPermission::values();

        Role::query()
            ->whereIn('name', [
                config('shopper.admin.roles.admin'),
                config('shopper.admin.roles.manager'),
            ])
            ->get()
            ->each(fn (Role $role) => $role->givePermissionTo($permissions));

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
