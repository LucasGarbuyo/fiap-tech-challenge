<?php

namespace TechChallenge\Api;

use TechChallenge\Domain\Shared\AbstractFactory\DAO as AbstractFactoryDAO;
use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\AbstractFactory\EloquentDAO as AbstractFactoryEloquentDAO;
use TechChallenge\Application\AbstractFactory\EloquentRepository as AbstractFactoryEloquentRepository;

abstract class Controller
{
    protected readonly AbstractFactoryDAO $AbstractFactoryDAO;

    protected readonly AbstractFactoryRepository $AbstractFactoryRepository;

    public function __construct()
    {
        $this->AbstractFactoryDAO = new AbstractFactoryEloquentDAO();

        $this->AbstractFactoryRepository = new AbstractFactoryEloquentRepository($this->AbstractFactoryDAO);
    }

    protected function return(mixed $data = [], int $status = 200)
    {
        return response()->json($data, $status, ["Content-Type: application/json", "Accept: application/json"]);
    }
}
