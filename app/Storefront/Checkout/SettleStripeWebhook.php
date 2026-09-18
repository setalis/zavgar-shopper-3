<?php

declare(strict_types=1);

namespace App\Storefront\Checkout;

use Shopper\Payment\Actions\IngestPaymentEvent;
use Shopper\Payment\DataTransferObjects\WebhookResult;
use Shopper\Payment\Facades\Payment;

final readonly class SettleStripeWebhook
{
    public function __construct(
        private IngestPaymentEvent $ingestPaymentEvent,
    ) {}

    /**
     * @param  array<string, mixed>  $headers
     */
    public function handle(string $rawBody, array $headers): WebhookResult
    {
        $result = Payment::driver('stripe')->handleWebhook(
            payload: ['_raw_body' => $rawBody],
            headers: $headers,
        );

        if (! $result->isIgnored()) {
            $this->ingestPaymentEvent->execute('stripe', $result);
        }

        return $result;
    }
}
