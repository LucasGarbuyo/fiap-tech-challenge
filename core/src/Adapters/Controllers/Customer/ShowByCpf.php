<?php

namespace TechChallenge\Adapters\Controllers\Customer;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Application\UseCase\Customer\ShowByCpf as UseCaseCustomerShowByCpf;
use TechChallenge\Adapters\Presenters\Customer\ToArray as PresenterCustomerToArray;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;

final class ShowByCpf
{
    public function __construct(private readonly AbstractFactoryRepository $AbstractFactoryRepository)
    {
    }

    public function execute(string $cpf)
    {
        $customer = (new UseCaseCustomerShowByCpf($this->AbstractFactoryRepository))->execute(new Cpf($cpf));

        return (new PresenterCustomerToArray())->execute($customer);
    }
}
