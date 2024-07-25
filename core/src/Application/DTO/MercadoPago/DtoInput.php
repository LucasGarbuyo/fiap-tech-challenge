<?php

namespace TechChallenge\Application\DTO\MercadoPago;

class DtoInput
{
    public function __construct(
        public readonly ?string $transaction_amount = null,
        public readonly ?string $token = null,
        public readonly ?string $description = null,
        public readonly ?string $installments = null,
        public readonly ?string $payment_method_id = null,
        public readonly ?string $payer_email = null,
        public readonly ?string $order_id = null
    ) {
    }
}
