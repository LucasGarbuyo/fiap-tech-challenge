<?php

namespace TechChallenge\Adapter\Driver\Api\V1;

use Illuminate\Http\Request;
use TechChallenge\Application\UseCase\Customer\DtoInput as CustomerDtoInput;
use TechChallenge\Config\DIContainer;
use TechChallenge\Domain\Customer\UseCase\Index as ICustomerUseCaseIndex;
use TechChallenge\Domain\Customer\UseCase\Edit as ICustomerUseCaseEdit;
use TechChallenge\Domain\Customer\UseCase\Store as ICustomerUseCaseStore;
use TechChallenge\Domain\Customer\UseCase\Update as ICustomerUseCaseUpdate;
use TechChallenge\Domain\Customer\UseCase\Delete as ICustomerUseCaseDelete;
use TechChallenge\Domain\Customer\UseCase\EditByCpf as ICustomerUseCaseEditByCpf;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;

class Customer extends Controller
{
    public function index(Request $request)
    {
        try {
            $customerIndex = DIContainer::create()->get(ICustomerUseCaseIndex::class);

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
            $data = new CustomerDtoInput(null, $request->name, $request->cpf, $request->email);

            $customerStore = DIContainer::create()->get(ICustomerUseCaseStore::class);

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
            $data = new CustomerDtoInput($id);

            $customerEdit = DIContainer::create()->get(ICustomerUseCaseEdit::class);

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
            $data = new CustomerDtoInput($id, $request->name, $request->cpf, $request->email);

            $customerUpdate = DIContainer::create()->get(ICustomerUseCaseUpdate::class);

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
            $data = new CustomerDtoInput($id);

            $productDelete = DIContainer::create()->get(ICustomerUseCaseDelete::class);

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
            $data = new CustomerDtoInput(cpf: $cpf);

            $CustomerEditByCpf = DIContainer::create()->get(ICustomerUseCaseEditByCpf::class);

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
