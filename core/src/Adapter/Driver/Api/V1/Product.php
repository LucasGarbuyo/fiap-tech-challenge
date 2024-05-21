<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Product\Dto as ProductDto;
use TechChallenge\Application\UseCase\Product\Index as ProductIndex;
use TechChallenge\Application\UseCase\Product\Store as ProductStore;
use TechChallenge\Application\UseCase\Product\Edit as ProductEdit;
use TechChallenge\Application\UseCase\Product\Update as ProductUpdate;
use TechChallenge\Application\UseCase\Product\Delete as ProductDelete;
use TechChallenge\Config\DIContainer;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Product extends Controller
{
    public function index(Request $request)
    {
        try {
            $productIndex = DIContainer::create()->get(ProductIndex::class);

            $products = $productIndex->execute();

            $results = array_map(function ($product) {
                return $product->toArray();
            }, $products);

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
            $data = new ProductDto(null, $request->name, $request->description, $request->price);

            $productStore = DIContainer::create()->get(ProductStore::class);

            $id = $productStore->execute($data);

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

    public function edit(Request $request, string $id)
    {
        try {
            $data = new ProductDto($id);

            $productEdit = DIContainer::create()->get(ProductEdit::class);

            $product = $productEdit->execute($data);

            return $this->return($product->toArray(), 200);
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
            $data = new ProductDto($id, $request->name, $request->description, $request->price);

            $productUpdate = DIContainer::create()->get(ProductUpdate::class);

            $productUpdate->execute($data);

            return $this->return('Produto atualizado com sucesso!', 200);
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
            $data = new ProductDto($id);

            $productDelete = DIContainer::create()->get(ProductDelete::class);

            $productDelete->execute($data);

            return $this->return('Produto deletado com sucesso!', 200);
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
