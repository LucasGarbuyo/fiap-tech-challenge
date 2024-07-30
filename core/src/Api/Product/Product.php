<?php

namespace TechChallenge\Api\Product;

use Illuminate\Http\Request;
use TechChallenge\Api\Controller;
use TechChallenge\Adapters\Controllers\Product\Index as ControllerProductIndex;
use TechChallenge\Adapters\Controllers\Product\Show as ControllerProductShow;
use TechChallenge\Adapters\Controllers\Product\Store as ControllerProductStore;
use TechChallenge\Adapters\Controllers\Product\Update as ControllerProductUpdate;
use TechChallenge\Adapters\Controllers\Product\Delete as ControllerProductDelete;
use TechChallenge\Application\DTO\Product\DtoInput as ProductDtoInput;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;
use Throwable;

class Product extends Controller
{
    public function index(Request $request)
    {
        try {
            $results = (new ControllerProductIndex($this->AbstractFactoryRepository))
                ->execute([
                    "page" => $request->get('page'),
                    "per_page" => $request->get('per_page')
                ]);

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

    public function show(string $id)
    {
        try {
            $result = (new ControllerProductShow($this->AbstractFactoryRepository))->execute($id);

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

    public function store(Request $request)
    {
        try {
            $dto = new ProductDtoInput(
                null,
                $request->category_id,
                $request->name,
                $request->description,
                $request->price,
                $request->image
            );

            $id = (new ControllerProductStore($this->AbstractFactoryRepository))->execute($dto);


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

    public function update(Request $request, string $id)
    {
        try {
            $dto = new ProductDtoInput(
                $id,
                $request->category_id,
                $request->name,
                $request->description,
                $request->price,
                $request->image
            );

            (new ControllerProductUpdate($this->AbstractFactoryRepository))->execute($dto);

            return $this->return(null, 200);
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
            (new ControllerProductDelete($this->AbstractFactoryRepository))->execute($id);

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
