<?php

namespace TechChallenge\Api\Order;

use TechChallenge\Api\Controller;
use Illuminate\Http\Request;
use Throwable;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

use TechChallenge\Adapters\Controllers\Order\Index  as ControllerOrderIndex;
use TechChallenge\Adapters\Controllers\Order\Show   as ControllerOrderShow;
use TechChallenge\Adapters\Controllers\Order\Store  as ControllerOrderStore;
use TechChallenge\Adapters\Controllers\Order\Update as ControllerOrderUpdate;
use TechChallenge\Adapters\Controllers\Order\Delete as ControllerOrderDelete;
use TechChallenge\Application\DTO\Order\DtoInput as OrderDtoInput;

class Order extends Controller
{
    public function index()
    {
        try {
            $results = (new ControllerOrderIndex($this->AbstractFactoryRepository))->execute([]);

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
        } catch (Throwable $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                400
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $dto = new OrderDtoInput(null, $request->name, $request->cpf, $request->email);

            $id = (new ControllerOrderStore($this->AbstractFactoryRepository))->execute($dto);

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
        } catch (Throwable $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                400
            );
        }
    }

    public function show(Request $request, string $id)
    {
        try {
            $result = (new ControllerOrderShow($this->AbstractFactoryRepository))->execute($id);

            return $this->return($result, 200);
        } catch (DefaultException $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                $e->getStatus()
            );
        } catch (Throwable $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                400
            );
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $dto = new OrderDtoInput(
                $id,
                $request->name,
                $request->cpf,
                $request->email,
                $request->created_at,
                $request->updated_at
            );

            (new ControllerOrderUpdate($this->AbstractFactoryRepository))->execute($dto);

            return $this->return(null, 204);
        } catch (DefaultException $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                $e->getStatus()
            );
        } catch (Throwable $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                400
            );
        }
    }

    public function delete(Request $request, string $id)
    {
        try {
            (new ControllerOrderDelete($this->AbstractFactoryRepository))->execute($id);

            return $this->return(null, 204);
        } catch (DefaultException $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                $e->getStatus()
            );
        } catch (Throwable $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                400
            );
        }
    }
}
