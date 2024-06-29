<?php

namespace TechChallenge\Adaptes\Controllers\Customer;

use TechChallenge\Domain\Customer\DAO\ICategory as ICategoryDAO;
use TechChallenge\Application\DTO\Customer\DtoInput as CustomerDTOInput;

final class Update
{
    public function __construct(private readonly ICategoryDAO $CategoryDAO)
    {
    }

    public function execute(CustomerDTOInput $dto): void
    {
    }
}
