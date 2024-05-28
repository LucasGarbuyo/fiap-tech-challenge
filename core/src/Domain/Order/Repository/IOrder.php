<?php

namespace TechChallenge\Domain\Order\Repository;

use TechChallenge\Domain\Order\Entities\Order;
use TechChallenge\Domain\Customer\Repository\ICustomer as ICustomerRepository;
use TechChallenge\Domain\Order\Repository\{IItem as IItemRepository, IStatus as IStatusRepository};

interface IOrder
{
    public function __construct(
        ICustomerRepository $CustomerRepository,
        IItemRepository $ItemRepository,
        IStatusRepository $StatusRepository
    );

    /** @return Order[] */
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): Order|null;

    public function store(Order $order): void;

    public function update(Order $order): void;

    public function delete(Order $order): void;

    public function exist(array $filters = []): bool;
}
