<?php

declare(strict_types=1);

use App\Enums\NewsPermission;
use Database\Seeders\NewsPermissionsSeeder;
use Illuminate\Database\Migrations\Migration;
use Shopper\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        (new NewsPermissionsSeeder)->run();
    }

    public function down(): void
    {
        Permission::query()
            ->whereIn('name', NewsPermission::values())
            ->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
