<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Order\DtoInput as OrderDtoInput;
use TechChallenge\Config\DIContainer;
use TechChallenge\Domain\Order\UseCase\Store as IOrderUseCaseStore;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Order extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = new OrderDtoInput(
                customerId: $request->customerId,
                items: $request->items
            );

            $categoryStore = DIContainer::create()->get(IOrderUseCaseStore::class);

            $id = $categoryStore->execute($data);

            return $this->return(["id" => $id], 201);
        } catch (DefaultException $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                $e->getStatus()
            );
        }
    }
}
