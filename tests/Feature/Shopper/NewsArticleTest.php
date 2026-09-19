<?php

declare(strict_types=1);

use App\Enums\NewsPermission;
use App\Livewire\Shopper\Pages\News\Edit;
use App\Livewire\Shopper\Pages\News\Index;
use App\Models\CatalogTranslation;
use App\Models\NewsArticle;
use App\Models\User;
use App\Sidebar\HomepageBannersSidebar;
use Database\Seeders\NewsPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Shopper\Database\Seeders\AuthTableSeeder;
use Shopper\Models\Permission;
use Shopper\Sidebar\Contracts\Builder\Menu;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\PermissionRegistrar;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->seed(AuthTableSeeder::class);
    $this->seed(NewsPermissionsSeeder::class);

    $this->admin = User::factory()->create();
    $this->admin->assignRole(config('shopper.admin.roles.admin'));
});

test('guests cannot browse news articles', function (): void {
    $this->get(route('shopper.news.index'))->assertRedirect();
});

test('news sidebar does not throw when the permission is missing', function (): void {
    Permission::query()
        ->where('name', 'like', 'news.%')
        ->delete();

    app()[PermissionRegistrar::class]->forgetCachedPermissions();

    $this->actingAs($this->admin);

    $menu = app(Menu::class);

    expect(fn () => (new HomepageBannersSidebar)->extendWith($menu))
        ->not->toThrow(PermissionDoesNotExist::class);
});

test('users without permission cannot browse news articles', function (): void {
    $user = User::factory()->create();

    expect($user->can(NewsPermission::Browse))->toBeFalse();

    $this->actingAs($user)
        ->get(route('shopper.news.index'))
        ->assertRedirect();
});

test('admins can browse news articles', function (): void {
    NewsArticle::factory()->create([
        'title' => 'Spring restock',
    ]);

    Livewire::actingAs($this->admin)
        ->test(Index::class)
        ->assertSuccessful()
        ->assertSee('Spring restock');
});

test('admins can create a news article', function (): void {
    Livewire::actingAs($this->admin)
        ->test(Edit::class)
        ->set('data.title', 'Warehouse opening')
        ->set('data.slug', 'warehouse-opening')
        ->set('data.summary', 'We opened a new warehouse.')
        ->set('data.description', '<p>More stock, faster shipping.</p>')
        ->set('data.is_enabled', true)
        ->set('data.published_at', now()->toDateTimeString())
        ->call('store')
        ->assertHasNoErrors();

    $article = NewsArticle::query()->first();

    expect($article)->not->toBeNull()
        ->and($article->title)->toBe('Warehouse opening')
        ->and($article->slug)->toBe('warehouse-opening')
        ->and($article->is_enabled)->toBeTrue()
        ->and($article->isPublished())->toBeTrue();
});

test('title is required when creating a news article', function (): void {
    Livewire::actingAs($this->admin)
        ->test(Edit::class)
        ->set('data.title', '')
        ->set('data.slug', 'missing-title')
        ->call('store')
        ->assertHasErrors(['data.title']);
});

test('admins can save english copy on a news article', function (): void {
    Livewire::actingAs($this->admin)
        ->test(Edit::class)
        ->set('data.title', 'Літній розпродаж')
        ->set('data.slug', 'litnii-rozprodazh')
        ->set('data.summary', 'Короткий опис')
        ->set('data.description', '<p>Опис українською</p>')
        ->set('data.english.title', 'Summer sale')
        ->set('data.english.summary', 'Short summary')
        ->set('data.english.description', '<p>English body</p>')
        ->set('data.is_enabled', true)
        ->set('data.published_at', now()->toDateTimeString())
        ->call('store')
        ->assertHasNoErrors();

    $article = NewsArticle::query()->first();

    expect($article)->not->toBeNull()
        ->and($article->catalogTranslationPayload('en'))->toMatchArray([
            'title' => 'Summer sale',
            'summary' => 'Short summary',
            'description' => '<p>English body</p>',
        ]);
});

test('admins can update a news article', function (): void {
    $article = NewsArticle::factory()->create([
        'title' => 'Old title',
        'slug' => 'old-title',
        'summary' => 'Old summary',
    ]);

    Livewire::actingAs($this->admin)
        ->test(Edit::class, ['article' => $article])
        ->set('data.title', 'Updated title')
        ->set('data.summary', 'Updated summary')
        ->call('store')
        ->assertHasNoErrors();

    $article->refresh();

    expect($article->title)->toBe('Updated title')
        ->and($article->summary)->toBe('Updated summary');
});

test('admins can delete a news article from the index', function (): void {
    $article = NewsArticle::factory()->create([
        'title' => 'Remove me',
    ]);

    Livewire::actingAs($this->admin)
        ->test(Index::class)
        ->callTableAction('delete', $article)
        ->assertHasNoErrors();

    expect(NewsArticle::query()->find($article->id))->toBeNull();
});

test('updating a news article replaces the english translation', function (): void {
    $article = NewsArticle::factory()->create([
        'title' => 'Стаття',
        'slug' => 'stattia',
    ]);

    CatalogTranslation::syncFor($article, 'en', [
        'name' => 'Old english',
    ]);

    Livewire::actingAs($this->admin)
        ->test(Edit::class, ['article' => $article])
        ->set('data.english.title', 'New english')
        ->call('store')
        ->assertHasNoErrors();

    expect($article->fresh()->catalogTranslationPayload('en')['title'])->toBe('New english');
});
