<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\NewsPermission;
use Illuminate\Database\Seeder;
use Shopper\Models\Permission;
use Shopper\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class NewsPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        Permission::generate('news');

        $permissions = NewsPermission::values();

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
