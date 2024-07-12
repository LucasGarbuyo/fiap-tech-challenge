<?php

namespace TechChallenge\Domain\Order\DAO;

interface IOrder
{
    public function index(array $filters = [], array|bool $append = []): array;

    public function show(array $filters = [], array|bool $append = []): array|null;

    public function store(array $order): void;

    public function update(array $order): void;

    public function delete(array $order): void;

    public function exist(array $filters = []): bool;
}
