<?php

declare(strict_types=1);

namespace App\Http\Controllers\Shop;

use App\Actions\ZoneSessionManager;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Shopper\Cart\Exceptions\PaymentSessionCollectedException;
use Shopper\Core\Exceptions\PaymentProviderUnavailableException;

final class ZoneController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'country_code' => ['required', 'string', 'size:2'],
        ]);

        try {
            ZoneSessionManager::setSessionForCountryCode($data['country_code']);
        } catch (LockTimeoutException) {
            return back()->withErrors(['zone' => __('backend.order.checkout_in_progress')]);
        } catch (PaymentProviderUnavailableException|PaymentSessionCollectedException $exception) {
            return back()->withErrors(['zone' => $exception->getMessage()]);
        }

        return back();
    }
}
