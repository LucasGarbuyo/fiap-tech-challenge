<?php

namespace TechChallenge\Application\UseCase\MercadoPago;

use TechChallenge\Domain\Shared\AbstractFactory\Repository as AbstractFactoryRepository;
use TechChallenge\Domain\MercadoPago\DAO\IMercadoPago as IMercadoPagoDAO;
use TechChallenge\Domain\MercadoPago\Repository\IMercadoPago as IMercadoPagoRepository;
use TechChallenge\Domain\Customer\Exceptions\CustomerAlreadyRegistered;
use TechChallenge\Domain\Customer\Exceptions\CustomerNotFoundException;
use TechChallenge\Domain\Customer\SimpleFactory\Customer as SimpleFactoryCustomer;
use TechChallenge\Application\DTO\MercadoPago\DtoInput;
use TechChallenge\Domain\Customer\ValueObjects\Cpf;
use DateTime;

final class Update
{
    private readonly IMercadoPagoDAO $MercadoPagoDAO;
    private readonly IMercadoPagoRepository $MercadoPagoRepository;

    public function __construct(AbstractFactoryRepository $AbstractFactoryRepository)
    {
        $this->MercadoPagoDAO = $AbstractFactoryRepository->getDAO()->createPaymentWithMercadoPagoDAO();
    }

    public function execute(DtoInput $data): void
    {
       /* if (!$this->CustomerDAO->exist(["id" => $data->id]))
            throw new CustomerNotFoundException();

        $cpf = new Cpf($data->cpf);

        if ($this->CustomerDAO->exist(
            [
                "not-id" => $data->id,
                "cpf" => (string) $cpf
            ]
        ))
            throw new CustomerAlreadyRegistered();

        $customer = (new SimpleFactoryCustomer())
            ->new($data->id, $data->createdAt, $data->updatedAt)
            ->withNameCpfEmail($data->name, $data->cpf, $data->email)
            ->build();

        $customer->setUpdatedAt(new DateTime());*/

        $this->MercadoPagoRepository->update($customer);
    }
}
