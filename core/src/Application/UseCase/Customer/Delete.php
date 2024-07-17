<?php

namespace TechChallenge\Application\UseCase\Customer;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;

final class Delete
{
    private readonly ICustomerDAO $CustomerDAO;

    private readonly ICustomerRepository $CustomerRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->CustomerDAO = $AbstractFactoryRepository->getDAO()->createCustomerDAO();

        $this->CustomerRepository = $AbstractFactoryRepository->createCustomerRepository();
    }

    public function execute(string $id): void
    {
        if (!$this->CustomerDAO->exist(["id" => $id]))
            throw new CustomerNotFoundException();

        $customer = $this->CustomerRepository->show(["id" => $id], true);

        $customer->delete();

        $this->CustomerRepository->delete($customer);
    }
}
