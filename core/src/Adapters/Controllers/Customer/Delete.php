<?php

namespace TechChallenge\Adaptes\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICategoryDAO;

final class Delete
{
    public function __construct(private readonly ICategoryDAO $CategoryDAO)
    {
    }

    public function execute(string $id)
    {
    }
}
