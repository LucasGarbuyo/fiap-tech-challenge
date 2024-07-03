<?php

namespace TechChallenge\Api\Customer;

use Illuminate\Http\Request;
use TechChallenge\Domain\Shared\Exceptions\DefaultException;
use TechChallenge\Adaptes\Controllers\Customer\Index as ControllerCustomerIndex;
use TechChallenge\Adaptes\Controllers\Customer\Show as ControllerCustomerShow;
use TechChallenge\Adaptes\Controllers\Customer\Store as ControllerCustomerStore;
use TechChallenge\Adaptes\Controllers\Customer\Update as ControllerCustomerUpdate;
use TechChallenge\Adaptes\Controllers\Customer\Delete as ControllerCustomerDelete;
use TechChallenge\Infra\DB\Eloquent\Customer\DAO as EloquentCustomerDAO;
use TechChallenge\Application\DTO\Customer\DtoInput as CustomerDtoInput;
use Throwable;
use TechChallenge\Api\Controller;

class Customer extends Controller
{
    public function index(Request $request)
    {
        try {
            $results = (new ControllerCustomerIndex(new EloquentCustomerDAO()))->execute([]);

            $this->return($results, 200);
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

            $id = (new ControllerCustomerStore(new EloquentCustomerDAO()))->execute($dto);

            return $this->return($id, 201);
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
            $result = (new ControllerCustomerShow(new EloquentCustomerDAO()))->execute($id);

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
            $dto = new CustomerDtoInput($id, $request->name, $request->cpf, $request->email);

            (new ControllerCustomerUpdate(new EloquentCustomerDAO()))->execute($dto);

            return $this->return('', 204);
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
            (new ControllerCustomerDelete(new EloquentCustomerDAO()))->execute($id);

            return $this->return('', 204);
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
