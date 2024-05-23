<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TechChallenge\Config\DIContainer;
use TechChallenge\Application\UseCase\Customer\DtoInput as CustomerDtoInput;
use TechChallenge\Domain\Customer\UseCase\Store as ICustomerUseCaseStore;
use TechChallenge\Domain\Customer\UseCase\EditByCpf as ICustomerUseCaseEditByCpf;
use TechChallenge\Application\UseCase\Product\DtoInput as ProductDtoInput;
use TechChallenge\Domain\Product\UseCase\Store as IProductUseCaseStore;
use TechChallenge\Domain\Product\UseCase\Edit as IProductUseCaseEdit;
use TechChallenge\Application\UseCase\Order\DtoInput as OrderDtoInput;
use TechChallenge\Domain\Order\Exceptions\InvalidItemQuantityException;
use TechChallenge\Domain\Order\UseCase\Store as IOrderUseCaseStore;

class GeralTest extends TestCase
{
    // use RefreshDatabase;
    use WithFaker;
    public function test_tudo(): void
    {
        $customerDto = new CustomerDtoInput(
            name: $this->faker->firstName(),
            cpf: $this->faker->cpf(),
            email: $this->faker->email()
        );
        $customerStore = DIContainer::create()->get(ICustomerUseCaseStore::class);
        $customerStore->execute($customerDto);
        $customerShowByCpf = DIContainer::create()->get(ICustomerUseCaseEditByCpf::class);
        $customer = $customerShowByCpf->execute($customerDto);
        $this->assertSame($customerDto->name, $customer->getName());
        $this->assertSame($customerDto->email, (string)$customer->getEmail());
        $productDto = new ProductDtoInput(
            name: $this->faker->word(),
            description: $this->faker->paragraph(),
            price: $this->faker->randomFloat(2, 1, 100000)
        );
        $productStore = DIContainer::create()->get(IProductUseCaseStore::class);
        $productId = $productStore->execute($productDto);
        $productDtoId = new ProductDtoInput(
            id: $productId,
        );
        $productShow = DIContainer::create()->get(IProductUseCaseEdit::class);
        $product = $productShow->execute($productDtoId);
        $this->assertSame($productDto->name, $product->getName());
        $this->assertSame($productDto->description, $product->getDescription());
        $this->assertSame($productDto->price, $product->getPrice()->getValue());
        $orderDto = new OrderDtoInput(
            customerId: $customer->getId(),
            items: [
                [
                    'productId' =>  $productId,
                    'quantity' => 1,
                ],
                [
                    'productId' =>  $productId,
                    'quantity' => 2,
                ]
            ],
        );
        // $this->expectException(InvalidItemQuantityException::class);
        $orderStore = DIContainer::create()->get(IOrderUseCaseStore::class);
        $res = $orderStore->execute($orderDto);
    }
}
