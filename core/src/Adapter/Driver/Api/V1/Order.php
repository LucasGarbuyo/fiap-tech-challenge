<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Order\DtoInput as OrderDtoInput;
use TechChallenge\Config\DIContainer;
use TechChallenge\Domain\Order\UseCase\Index as IOrderUseCaseIndex;
use TechChallenge\Domain\Order\UseCase\Show as IOrderUseCaseShow;
use TechChallenge\Domain\Order\UseCase\Delete as IOrderUseCaseDelete;
use TechChallenge\Domain\Order\UseCase\Store as IOrderUseCaseStore;
use TechChallenge\Domain\Order\UseCase\Update as IOrderUseCaseUpdate;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Order extends Controller
{
    public function index(Request $request)
    {
        try {
            $orderIndex = DIContainer::create()->get(IOrderUseCaseIndex::class);

            $orders = $orderIndex->execute();

            $results = array_map(function ($order) {
                return $order->toArray();
            }, $orders);

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
                customer_id: $request->customerId,
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

    public function show(Request $request, string $id)
    {
        try {
            $data = new OrderDtoInput($id);

            $orderShow = DIContainer::create()->get(IOrderUseCaseShow::class);

            $order = $orderShow->execute($data);

            return $this->return($order->toArray(), 200);
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

    public function update(Request $request, string $id)
    {
        try {
            $data = new OrderDtoInput(
                id: $id,
                customer_id: $request->customerId,
                items: $request->items,
                status: $request->status
            );

            $orderUpdate = DIContainer::create()->get(IOrderUseCaseUpdate::class);

            $orderUpdate->execute($data);

            return $this->return([], 204);
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

    public function delete(Request $request, string $id)
    {
        try {
            $data = new OrderDtoInput($id);

            $productDelete = DIContainer::create()->get(IOrderUseCaseDelete::class);

            $productDelete->execute($data);

            return $this->return([], 204);
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
