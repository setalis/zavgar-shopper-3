<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Storefront\Checkout\SettleStripeWebhook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class StripeWebhookController extends Controller
{
    public function __invoke(Request $request, SettleStripeWebhook $settleStripeWebhook): JsonResponse
    {
        $result = $settleStripeWebhook->handle(
            rawBody: $request->getContent(),
            headers: [
                'stripe-signature' => $request->header('Stripe-Signature', ''),
            ],
        );

        if ($result->isIgnored()) {
            return response()->json(['status' => 'ignored']);
        }

        return response()->json(['status' => 'handled']);
    }
}
