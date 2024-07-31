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

        if (!empty($filters["page"]) && !empty($filters["per_page"])) {

            $paginator = $query->paginate(perPage: $filters["per_page"], page: $filters["page"]);

            $data = $paginator->items();

            $data = array_map(fn ($item) => $item->toArray(), $data);

            return [
                'data' => $data,
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
        Model::where("id", $order["id"])->update([
            "id" => $order["id"],
            "customer_id" => $order["customer_id"],
            "total" => $order["total"],
            "status" => $order["status"],
            "created_at" => $order["created_at"],
            "updated_at" => $order["updated_at"],
            "deleted_at" => $order["deleted_at"],
        ]);

        $this->saveItems($order["items"], $order["id"]);

        $this->saveStatus($order["status_history"], $order["id"]);
    }

    public function delete(array $order): void
    {
        $this->saveItems($order["items"], $order["id"]);

        $this->saveStatus($order["status_history"], $order["id"]);

        Model::where("id", $order["id"])->update([
            "id" => $order["id"],
            "customer_id" => $order["customer_id"],
            "total" => $order["total"],
            "status" => $order["status"],
            "created_at" => $order["created_at"],
            "updated_at" => $order["updated_at"],
            "deleted_at" => $order["deleted_at"],
        ]);
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

        if (!empty($filters["not_status"])) {
            if (!is_array($filters["not_status"]))
                $filters["not_status"] = [$filters["not_status"]];

            $query->whereNotIn('status', $filters["not_status"]);
        }

        if (!empty($filters["status"])) {
            if (!is_array($filters["status"]))
                $filters["status"] = [$filters["status"]];

            $query->whereIn('status', $filters["status"]);
        }

        if (!empty($filters["create_date_sort"])) {
            if (in_array(strtoupper($filters["create_date_sort"]), ["ASC", "DESC"]))
                $query->orderBy("created_at", $filters["create_date_sort"]);
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
