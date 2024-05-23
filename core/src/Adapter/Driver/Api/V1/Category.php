<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Category\DtoInput as CategoryDtoInput;
use TechChallenge\Config\DIContainer;
use TechChallenge\Domain\Category\UseCase\Index as ICategoryUseCaseIndex;
use TechChallenge\Domain\Category\UseCase\Edit as ICategoryUseCaseEdit;
use TechChallenge\Domain\Category\UseCase\Store as ICategoryUseCaseStore;
use TechChallenge\Domain\Category\UseCase\Update as ICategoryUseCaseUpdate;
use TechChallenge\Domain\Category\UseCase\Delete as ICategoryUseCaseDelete;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Category extends Controller
{
    public function index(Request $request)
    {
        try {
            $CategoryIndex = DIContainer::create()->get(ICategoryUseCaseIndex::class);

            $Categorys = $CategoryIndex->execute();

            $results = array_map(function ($Category) {
                return $Category->toArray();
            }, $Categorys);

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
            $data = new CategoryDtoInput(null, $request->name, $request->type);

            $CategoryStore = DIContainer::create()->get(ICategoryUseCaseStore::class);

            $id = $CategoryStore->execute($data);

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
            $data = new CategoryDtoInput($id);

            $CategoryEdit = DIContainer::create()->get(ICategoryUseCaseEdit::class);

            $Category = $CategoryEdit->execute($data);

            return $this->return($Category->toArray(), 200);
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
            $data = new CategoryDtoInput($id, $request->name, $request->type);

            $CategoryUpdate = DIContainer::create()->get(ICategoryUseCaseUpdate::class);

            $CategoryUpdate->execute($data);

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
            $data = new CategoryDtoInput($id);

            $productDelete = DIContainer::create()->get(ICategoryUseCaseDelete::class);

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
