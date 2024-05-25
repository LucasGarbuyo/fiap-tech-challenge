<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TechChallenge\Config\DIContainer;
use TechChallenge\Application\UseCase\Customer\DtoInput as CustomerDtoInput;
use TechChallenge\Domain\Customer\UseCase\Store as ICustomerUseCaseStore;
use TechChallenge\Domain\Customer\UseCase\ShowByCpf as ICustomerUseCaseShowByCpf;
use TechChallenge\Application\UseCase\Product\DtoInput as ProductDtoInput;
use TechChallenge\Domain\Product\UseCase\Store as IProductUseCaseStore;
use TechChallenge\Domain\Product\UseCase\Show as IProductUseCaseEdit;
use TechChallenge\Application\UseCase\Order\DtoInput as OrderDtoInput;
use TechChallenge\Domain\Order\Exceptions\InvalidItemQuantityException;
use TechChallenge\Domain\Order\Exceptions\InvalidOrderItemQuantityException;
use TechChallenge\Domain\Order\Exceptions\MissingItemKeysException;
use TechChallenge\Domain\Order\UseCase\Store as IOrderUseCaseStore;
use TechChallenge\Application\UseCase\Category\DtoInput as CategoryDtoInput;
use TechChallenge\Domain\Category\UseCase\Store as ICategoryUseCaseStore;

class GeralTest extends TestCase
{
    use RefreshDatabase;
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
        $customerShowByCpf = DIContainer::create()->get(ICustomerUseCaseShowByCpf::class);
        $customer = $customerShowByCpf->execute($customerDto);
        $this->assertSame($customerDto->name, $customer->getName());
        $this->assertSame($customerDto->email, (string)$customer->getEmail());
        $data = new CategoryDtoInput(
            name: $this->faker->text(10),
            type: $this->faker->text(10),
        );
        $categoryStore = DIContainer::create()->get(ICategoryUseCaseStore::class);
        $categoryId = $categoryStore->execute($data);
        $productDto = new ProductDtoInput(
            name: $this->faker->word(),
            description: $this->faker->paragraph(),
            price: $this->faker->randomFloat(2, 1, 100000),
            category_id: $categoryId
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
        $orderStore = DIContainer::create()->get(IOrderUseCaseStore::class);
        $orderStore->execute(new OrderDtoInput(
            // customerId: $customer->getId(),
            items: [
                [
                    'productId' =>  $productId,
                    'quantity' => random_int(1, 99),
                ],
                [
                    'productId' =>  $productId,
                    'quantity' => random_int(1, 99),
                ]
            ],
        ));
        // $this->expectException(InvalidOrderItemQuantityException::class);
        // $orderStore = DIContainer::create()->get(IOrderUseCaseStore::class);
        // $orderStore->execute(
        //     new OrderDtoInput(
        //         customerId: $customer->getId(),
        //         items: [],
        //     )
        // );
        // $this->expectException(MissingItemKeysException::class);
        // $orderStore = DIContainer::create()->get(IOrderUseCaseStore::class);
        // $orderStore->execute(
        //     new OrderDtoInput(
        //         customerId: $customer->getId(),
        //         items: [
        //             [
        //                 'productId' =>  $productId,
        //             ],
        //         ],
        //     )
        // );
        // $this->post('api/orders', [
        //     'customerId' => $customer->getId(),
        //     'items' => [
        //         [
        //             'productId' =>  $productId,
        //             'quantity' => random_int(1, 99),
        //         ],
        //         [
        //             'productId' =>  $productId,
        //             'quantity' => random_int(1, 99),
        //         ]
        //     ]
        // ])->assertStatus(201)->assertSessionHasNoErrors();

        $this->post('api/orders', [
            'customerId' => $customer->getId(),
            'items' => []
        ])->assertStatus(201);

        $this->post('api/orders', [
            'customerId' => $customer->getId(),
            'items' => [
                [
                    'productId' =>  $productId,
                    'quantity' => random_int(1, 99),
                    'price' => random_int(1, 99),
                ],
                [
                    'productId' =>  $productId,
                    'quantity' => random_int(1, 99),
                    'price' => random_int(1, 99),
                ]
            ]
        ])->assertStatus(201);
    }
}
