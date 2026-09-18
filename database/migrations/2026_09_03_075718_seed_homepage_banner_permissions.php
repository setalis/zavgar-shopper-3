<?php

declare(strict_types=1);

use App\Enums\HomepageBannerPermission;
use Database\Seeders\HomepageBannerPermissionsSeeder;
use Illuminate\Database\Migrations\Migration;
use Shopper\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        (new HomepageBannerPermissionsSeeder)->run();
    }

    public function down(): void
    {
        Permission::query()
            ->whereIn('name', HomepageBannerPermission::values())
            ->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
};
