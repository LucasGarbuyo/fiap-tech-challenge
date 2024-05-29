<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Product\DtoInput as ProductDtoInput;
use TechChallenge\Domain\Product\UseCase\Index as IProductUseCaseIndex;
use TechChallenge\Domain\Product\UseCase\Show as IProductUseCaseShow;
use TechChallenge\Domain\Product\UseCase\Store as IProductUseCaseStore;
use TechChallenge\Domain\Product\UseCase\Update as IProductUseCaseUpdate;
use TechChallenge\Domain\Product\UseCase\Delete as IProductUseCaseDelete;
use TechChallenge\Config\DIContainer;

class Product extends Controller
{
    public function index(Request $request)
    {
        try {
            $productIndex = DIContainer::create()->get(IProductUseCaseIndex::class);

            $products = $productIndex->execute([], true);

            $results = array_map(function ($product) {
                return $product->toArray();
            }, $products);

            return $this->return($results, 200);
        } catch (\Throwable $e) {
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
            $data = new ProductDtoInput(
                null,
                $request->category_id,
                $request->name,
                $request->description,
                $request->price,
                $request->image
            );

            $productStore = DIContainer::create()->get(IProductUseCaseStore::class);

            $id = $productStore->execute($data);

            return $this->return(["id" => $id], 201);
        } catch (\Throwable $e) {
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
            $data = new ProductDtoInput($id);

            $productEdit = DIContainer::create()->get(IProductUseCaseShow::class);

            $product = $productEdit->execute($data, true);

            return $this->return($product->toArray(), 200);
        } catch (\Throwable $e) {
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
            $data = new ProductDtoInput($id, $request->category_id, $request->name, $request->description, $request->price, $request->image);

            $productUpdate = DIContainer::create()->get(IProductUseCaseUpdate::class);

            $productUpdate->execute($data);

            return $this->return([], 204);
        } catch (\Throwable $e) {

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
            $data = new ProductDtoInput($id);

            $productDelete = DIContainer::create()->get(IProductUseCaseDelete::class);

            $productDelete->execute($data);

            return $this->return('Produto deletado com sucesso!', 204);
        } catch (\Throwable $e) {
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
