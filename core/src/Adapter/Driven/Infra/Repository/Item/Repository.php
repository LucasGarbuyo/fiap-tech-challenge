<?php
namespace TechChallenge\Adapter\Driven\Infra\Repository\Item;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use TechChallenge\Domain\Shared\ValueObjects\Price;
use TechChallenge\Domain\Order\Factories\Item as ItemFactory;
use TechChallenge\Domain\Order\Entities\Item as ItemEntity;
use TechChallenge\Domain\Order\Repository\IItem as IItemRepository;

class Repository implements IItemRepository
{
    public function show(string $itemId): ItemEntity
    {
        $itemData = $this->query()->where('order_id', $itemId)->first();
    
        $price = new Price($itemData->price);

        return (new ItemFactory())
            ->new($itemData->product_id, $itemData->quantity, $price)
            ->build();
    }

    protected function query(): Builder
    {
        return DB::table("orders_items");
    }
}

