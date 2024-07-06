<?php

namespace TechChallenge\Api\Customer;

use TechChallenge\Api\Controller;
use Illuminate\Http\Request;
use Throwable;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;
use TechChallenge\Adapters\Controllers\Customer\Index as ControllerCustomerIndex;
use TechChallenge\Adapters\Controllers\Customer\Show as ControllerCustomerShow;
use TechChallenge\Adapters\Controllers\Customer\Store as ControllerCustomerStore;
use TechChallenge\Adapters\Controllers\Customer\Update as ControllerCustomerUpdate;
use TechChallenge\Adapters\Controllers\Customer\Delete as ControllerCustomerDelete;
use TechChallenge\Application\DTO\Customer\DtoInput as CustomerDtoInput;

class Customer extends Controller
{
    public function index(Request $request)
    {
        try {
            $results = (new ControllerCustomerIndex($this->AbstractFactoryRepository))->execute([]);

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

    public function store(Request $request)
    {
        try {
            $dto = new CustomerDtoInput(null, $request->name, $request->cpf, $request->email);

            $id = (new ControllerCustomerStore($this->AbstractFactoryRepository))->execute($dto);

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

    public function show(Request $request, string $id)
    {
        try {
            $result = (new ControllerCustomerShow($this->AbstractFactoryRepository))->execute($id);

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

    public function update(Request $request, string $id)
    {
        try {
            $dto = new CustomerDtoInput(
                $id,
                $request->name,
                $request->cpf,
                $request->email,
                $request->created_at,
                $request->updated_at
            );

            (new ControllerCustomerUpdate($this->AbstractFactoryRepository))->execute($dto);

            return $this->return(null, 204);
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

    public function delete(Request $request, string $id)
    {
        try {
            (new ControllerCustomerDelete($this->AbstractFactoryRepository))->execute($id);

            return $this->return(null, 204);
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

    //TODO fazer o Adapter controller desse método
    // public function showByCfp(Request $request, string $cpf)
    // {
    //     try {
    //         $data = new CustomerDtoInput(cpf: $cpf);

    //         $CustomerEditByCpf = DIContainer::create()->get(ICustomerUseCaseShowByCpf::class);

    //         $customer = $CustomerEditByCpf->execute($data);

    //         return $this->return($customer->toArray(), 200);
    //     } catch (DefaultException $e) {
    //         return $this->return(
    //             [
    //                 "error" => [
    //                     "message" => $e->getMessage()
    //                 ]
    //             ],
    //             $e->getStatus()
    //         );
    //     } catch (\Throwable $e) {
    //         return $this->return(
    //             [
    //                 "error" => [
    //                     "message" => $e->getMessage()
    //                 ]
    //             ],
    //             400
    //         );
    //     }
    // }
}
