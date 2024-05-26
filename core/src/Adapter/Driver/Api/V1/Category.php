<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Category\DtoInput as CategoryDtoInput;
use TechChallenge\Config\DIContainer;
use TechChallenge\Domain\Category\UseCase\Index as ICategoryUseCaseIndex;
use TechChallenge\Domain\Category\UseCase\Show as ICategoryUseCaseShow;
use TechChallenge\Domain\Category\UseCase\Store as ICategoryUseCaseStore;
use TechChallenge\Domain\Category\UseCase\Update as ICategoryUseCaseUpdate;
use TechChallenge\Domain\Category\UseCase\Delete as ICategoryUseCaseDelete;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Category extends Controller
{
    public function index(Request $request)
    {
        try {
            $categoryIndex = DIContainer::create()->get(ICategoryUseCaseIndex::class);

            $categorys = $categoryIndex->execute();

            $results = array_map(function ($category) {
                return $category->toArray();
            }, $categorys);

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

            $categoryStore = DIContainer::create()->get(ICategoryUseCaseStore::class);

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

    public function show(Request $request, string $id)
    {
        try {
            $data = new CategoryDtoInput($id);

            $categoryShow = DIContainer::create()->get(ICategoryUseCaseShow::class);

            $category = $categoryShow->execute($data);

            return $this->return($category->toArray(), 200);
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

            $categoryUpdate = DIContainer::create()->get(ICategoryUseCaseUpdate::class);

            $categoryUpdate->execute($data);

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

            $categoryDelete = DIContainer::create()->get(ICategoryUseCaseDelete::class);

            $categoryDelete->execute($data);

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
