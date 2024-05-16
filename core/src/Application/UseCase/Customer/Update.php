<?php

namespace TechChallenge\Application\UseCase\Customer;

use DateTime;
use TechChallenge\Domain\Customer\Factories\Customer as CustomerFactory;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;

class Update
{
    private ICustomerRepository $CustomerRepository;

    public function __construct(ICustomerRepository $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }

    public function execute(Dto $data)
    {
        $customer = (new CustomerFactory())
            ->new($data->id, $data->created_at, $data->updated_at)
            ->withNameCpfEmail($data->name, $data->cpf, $data->email)
            ->build();

        $customer->setUpdatedAt(new DateTime());

        return $this->CustomerRepository->update($customer);
    }
}
