<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Log\Logger;
use TechChallenge\Application\UseCase\Customer\Dto as CustomerDTO;
use TechChallenge\Config\DIContainer;
use TechChallenge\Application\UseCase\Customer\Index as CustomerIndex;
use TechChallenge\Application\UseCase\Customer\Store as CustomerStore;
use TechChallenge\Application\UseCase\Customer\Edit as CustomerEdit;
use TechChallenge\Application\UseCase\Customer\EditByCpf as CustomerEditByCpf;
use TechChallenge\Application\UseCase\Customer\Update as CustomerUpdate;
use TechChallenge\Application\UseCase\Customer\Delete as CustomerDelete;
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
            $data = new CustomerDTO(null, $request->name, $request->cpf, $request->email);

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

    public function edit(Request $request, string $id)
    {
        try {
            $data = new CustomerDTO($id);

            $customerEdit = DIContainer::create()->get(CustomerEdit::class);

            $customer = $customerEdit->execute($data);

            return $this->return($customer->toArray(), 200);
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
            $data = new CustomerDTO($id, $request->name, $request->cpf, $request->email);

            $customerUpdate = DIContainer::create()->get(CustomerUpdate::class);

            $customerUpdate->execute($data);

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
            $data = new CustomerDTO($id);

            $productDelete = DIContainer::create()->get(CustomerDelete::class);

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

    public function editByCfp(Request $request, string $cpf)
    {
        try {
            Logger("oi");

            $data = new CustomerDTO(cpf: $cpf);

            $CustomerEditByCpf = DIContainer::create()->get(CustomerEditByCpf::class);

            $customer = $CustomerEditByCpf->execute($data);

            return $this->return($customer->toArray(), 200);
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
