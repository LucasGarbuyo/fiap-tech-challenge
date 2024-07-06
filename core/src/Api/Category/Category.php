<?php

namespace TechChallenge\Api\Category;

use TechChallenge\Domain\Shared\AbstractFactory\DAO as AbstractFactoryDAO;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\AbstractFactory\EloquentDAO as AbstractFactoryEloquentDAO;
use TechChallenge\Application\AbstractFactory\EloquentRepository as AbstractFactoryEloquentRepository;
use TechChallenge\Api\Controller;
use Illuminate\Http\Request;
use Throwable;
use TechChallenge\Application\UseCase\Category\DtoInput as CategoryDtoInput;
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

            $categories = $categoryIndex->execute();

            $results = array_map(function ($category) {
                return $category->toArray();
            }, $categories);

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
