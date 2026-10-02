<?php

declare(strict_types=1);

namespace App\Storefront\Checkout;

use App\Actions\Fortify\CreateNewUser;
use App\CheckoutSession;
use App\Models\User;
use App\Storefront\Cart\CartGateway;
use Illuminate\Auth\Events\Registered;

final readonly class ResolveCheckoutCustomer
{
    public function __construct(
        private CartGateway $cart,
        private CreateNewUser $createNewUser,
    ) {}

    public function emailBelongsToExistingUser(string $email): bool
    {
        return User::query()->where('email', $email)->exists();
    }

    /**
     * @param  array{email?: string|null, first_name: string, last_name: string, create_account?: bool|null, password?: string|null, password_confirmation?: string|null}  $data
     */
    public function handle(array $data): void
    {
        if (! auth()->check() && ($data['create_account'] ?? false)) {
            $user = $this->createNewUser->create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => (string) $data['email'],
                'password' => (string) $data['password'],
                'password_confirmation' => (string) ($data['password_confirmation'] ?? ''),
            ]);

            event(new Registered($user));

            auth()->login($user);
            session()->regenerate();
        }

        $email = auth()->user()?->email ?? (string) $data['email'];

        session()->put(CheckoutSession::EMAIL, $email);

        if ($cart = $this->cart->current()) {
            $cart->update([
                'email' => $email,
                'customer_id' => auth()->id() ?? $cart->customer_id,
            ]);
        }
    }
}
