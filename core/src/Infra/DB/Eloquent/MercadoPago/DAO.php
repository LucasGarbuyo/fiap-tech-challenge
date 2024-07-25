<?php

namespace TechChallenge\Infra\DB\Eloquent\Product;

use TechChallenge\Domain\MercadoPago\DAO\IMercadoPago as IMercadoPagoDAO;


final class DAO implements IMercadoPagoDAO
{   

    public function savePayment(array $product): void
    {
        Model::where("id", $product["id"])->update($product);
    }

}
