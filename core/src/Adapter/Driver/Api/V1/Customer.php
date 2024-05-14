<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Customer\Dto as ProductDto;
use TechChallenge\Config\DIContainer;
use TechChallenge\Application\UseCase\Customer\Index as CustomerIndex;
use TechChallenge\Application\UseCase\Customer\Store as CustomerStore;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Customer extends Controller
{
    public function index(Request $request)
    {
        try {
            $customerIndex = DIContainer::create()->get(CustomerIndex::class);

            $customers = $customerIndex->execute();

            $results = array_map(function ($customer) {
                return $customer->toArray();
            }, $customers);

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
            $data = new ProductDto(null, $request->name, $request->cpf, $request->email);

            $customerStore = DIContainer::create()->get(CustomerStore::class);

            $id = $customerStore->execute($data);

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

    public function update(Request $request, string $id)
    {
    }

    public function edit(Request $request, string $id)
    {
    }

    public function delete(Request $request, string $id)
    {
    }
}
