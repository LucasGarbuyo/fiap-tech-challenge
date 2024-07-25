<?php

namespace TechChallenge\Adapters\Gateways\Repository\Eloquent\MercadoPago;

use TechChallenge\Domain\MercadoPago\Repository\IMercadoPago as IMercadoPagoRepository;
use TechChallenge\Domain\MercadoPago\DAO\IMercadoPago as IMercadoPagoDAO;
use App\Services\DTO\MercadoPagoPaymentDto;
use App\Services\DTO\MercadoPagoPreferenceDto;
use MercadoPago\SDK;
use MercadoPago\Payment;
use MercadoPago\Preference;

class MercadoPagoRepository  implements IMercadoPagoRepository
{
    public function __construct(private readonly IMercadoPagoDAO $MercadoPagoDAO)
    {
        SDK::setAccessToken(config('services.mercadopago.access_token'));
    }

    public function createPayment(MercadoPagoPaymentDto $dto)
    {
        $payment = new Payment();
        $payment->transaction_amount = $dto->transaction_amount;
        $payment->token = $dto->token;
        $payment->description = $dto->description;
        $payment->installments = $dto->installments;
        $payment->payment_method_id = $dto->payment_method_id;
        $payment->payer = [
            'email' => $dto->payer_email
        ];

        if (!$payment->save()) {
            throw new \Exception($payment->error->message);
        }

        return $payment;
    }

    public function createPreference(MercadoPagoPreferenceDto $dto)
    {
        $preference = new Preference();
        $preference->items = [
            [
                'title' => $dto->title,
                'quantity' => $dto->quantity,
                'unit_price' => $dto->unit_price
            ]
        ];

        if (!$preference->save()) {
            throw new \Exception($preference->error->message);
        }

        return $preference;
    }
}
