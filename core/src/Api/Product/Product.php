<?php

namespace TechChallenge\Api\Product;

use Illuminate\Http\Request;
use TechChallenge\Api\Controller;
use TechChallenge\Domain\Shared\AbstractFactory\DAO as AbstractFactoryDAO;
use TechChallenge\Application\AbstractFactory\EloquentDAO as AbstractFactoryEloquentDAO;
use TechChallenge\Application\AbstractFactory\EloquentRepository as AbstractFactoryEloquentRepository;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Adapters\Controllers\Product\Index as ControllerProductIndex;
use TechChallenge\Adapters\Controllers\Product\Show as ControllerProductShow;
use TechChallenge\Adapters\Controllers\Product\Store as ControllerProductStore;
use TechChallenge\Infra\DB\Eloquent\Product\DAO as EloquentProductDAO;
use TechChallenge\Application\DTO\Product\DtoInput as ProductDtoInput;

use Throwable;

use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Product extends Controller
{
    private readonly AbstractFactoryDAO $AbstractFactoryDAO;

    private readonly AbstractFactoryRepository $AbstractFactoryRepository;

    public function __construct()
    {
        $this->AbstractFactoryDAO = new AbstractFactoryEloquentDAO();

        $this->AbstractFactoryRepository = new AbstractFactoryEloquentRepository($this->AbstractFactoryDAO);
    }
    public function index()
    {
        try {
            $results = (new ControllerProductIndex(new EloquentProductDAO()))->execute([]);

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
            $result = (new ControllerProductShow(new EloquentProductDAO()))->execute($id);

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
}
