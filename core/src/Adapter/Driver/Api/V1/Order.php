<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Order\DtoInput as OrderDtoInput;
use TechChallenge\Config\DIContainer;
use TechChallenge\Domain\Order\UseCase\Index as IOrderUseCaseIndex;
use TechChallenge\Domain\Order\UseCase\Store as IOrderUseCaseStore;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Order extends Controller
{

    public function index(Request $request)
    {
       
        try {
            $orderIndex = DIContainer::create()->get(IOrderUseCaseIndex::class);
            
            dd($orderIndex);die;
            $customers = $customerIndex->execute();

            $results = array_map(function ($customer) {
                return $customer->toArray();
            }, $customers);

            return $this->return($results, 200);
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

    public function store(Request $request)
    {
        try {
            $data = new OrderDtoInput(
                customerId: $request->customerId,
                items: $request->items
            );

            $orderStore = DIContainer::create()->get(IOrderUseCaseStore::class);

            $id = $orderStore->execute($data);

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
