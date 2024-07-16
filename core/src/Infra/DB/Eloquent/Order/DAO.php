<?php

namespace TechChallenge\Infra\DB\Eloquent\Order;

use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use Illuminate\Database\Eloquent\Builder;
use TechChallenge\Infra\DB\Eloquent\Order\Item\Model as ItemModel;
use TechChallenge\Infra\DB\Eloquent\Order\Status\Model as StatusModel;

class DAO implements IOrderDAO
{
    public function index(array $filters = [], array|bool $append = []): array
    {
        $query = $this->query($filters, $append);

        if (!empty($filters["pag"]) && !empty($filters["prp"])) {

            $paginator = $query->paginate(perPage: $filters["prp"], page: $filters["pag"]);

            return [
                'data' => $paginator->items(),
                'pagination' => [
                    'total'         => $paginator->total(),
                    'per_page'      => $paginator->perPage(),
                    'current_page'  => $paginator->currentPage(),
                    'last_page'     => $paginator->lastPage(),
                    'from'          => $paginator->firstItem(),
                    'to'            => $paginator->lastItem(),
                ],
            ];
        }

        $results = $query->get()->toArray();

        return $results;
    }

    public function store(array $order): void
    {
        Model::create($order);

        $this->saveItems($order["items"], $order["id"]);

        $this->saveStatus($order["status_history"], $order["id"]);
    }

    public function show(array $filters = [], array|bool $append = []): ?array
    {
        return $this->query($filters, $append)->first()->toArray();
    }

    public function update(array $order): void
    {
        Model::where("id", $order["id"])->update($order);

        $this->saveItems($order["items"], $order["id"]);

        $this->saveStatus($order["status_history"], $order["id"]);
    }

    public function delete(array $order): void
    {
        Model::where("id", $order["id"])->update($order);

        $this->saveItems($order["items"], $order["id"]);

        $this->saveStatus($order["status_history"], $order["id"]);
    }

    public function exist(array $filters = []): bool
    {
        return $this->query($filters)->exists();
    }

    protected function query(array $filters = [], array|bool $append = []): Builder
    {
        $query = Model::query();

        if ($append === true || in_array("customer", $append))
            $query->with("customer");

        if ($append === true || in_array("items", $append))
            $query->with("items");

        if ($append === true || in_array("statusHistory", $append))
            $query->with("statusHistory");

        if (!empty($filters["id"])) {
            if (!is_array($filters["id"]))
                $filters["id"] = [$filters["id"]];

            $query->whereIn('id', $filters["id"]);
        }

        return $query;
    }

    protected function saveItems(array $items, string $orderId): void
    {
        $order = Model::find($orderId);

        foreach ($items as $item) {
            $order->items()
                ->updateOrCreate(
                    [
                        "id" => $item["id"]
                    ],
                    $item
                );
        }

        ItemModel::query()
            ->where("order_id", $orderId)
            ->whereNotIn("id", array_column($items, "id"))
            ->delete();
    }

    protected function saveStatus(array $statusHistories, string $orderId): void
    {
        $order = Model::find($orderId);

        foreach ($statusHistories as $status) {
            $order->statusHistory()
                ->updateOrCreate(
                    [
                        "id" => $status["id"]
                    ],
                    $status
                );
        }

        StatusModel::query()
            ->where("order_id", $orderId)
            ->whereNotIn("id", array_column($statusHistories, "id"))
            ->delete();
    }
}
