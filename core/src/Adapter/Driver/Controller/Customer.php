<?php

namespace TechChallenge\Adapter\Driver\Controller;

use Exception;
use Illuminate\Http\Request;
use TechChallenge\Config\DIContainer;
use TechChallenge\Application\UseCase\Customer\Index as CustomerIndex;

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
        } catch (Exception $e) {
            return $this->return(
                [
                    "error" => [
                        "message" => $e->getMessage()
                    ]
                ],
                $e->getCode()
            );
        }
    }

    public function store(Request $request)
    {
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
