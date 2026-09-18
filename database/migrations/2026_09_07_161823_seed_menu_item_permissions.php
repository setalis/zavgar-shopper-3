<?php

declare(strict_types=1);

use App\Enums\MenuItemPermission;
use Database\Seeders\MenuItemPermissionsSeeder;
use Illuminate\Database\Migrations\Migration;
use Shopper\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        (new MenuItemPermissionsSeeder)->run();
    }

    public function down(): void
    {
        Permission::query()
            ->whereIn('name', MenuItemPermission::values())
            ->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
