<?php

namespace TechChallenge\Domain\MercadoPago\DAO;

interface IMercadoPago
{
    public function savePayment($payment);
    public function savePreference($preference);
}
