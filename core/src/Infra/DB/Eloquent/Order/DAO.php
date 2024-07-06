<?php

namespace TechChallenge\Infra\DB\Eloquent\Order;

use TechChallenge\Domain\Order\DAO\IOrder as IOrderDAO;
use Illuminate\Database\Eloquent\Builder;

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
    }

    public function show(array $filters = [], array|bool $append = []): ?array
    {
        return $this->query($filters, $append)->first()->toArray();
    }

    public function update(array $order): void
    {
        Model::where("id", $order["id"])->update($order);
    }

    public function delete(array $order): void
    {
        Model::where("id", $order["id"])->update($order);
    }

    public function exist(array $filters = []): bool
    {
        return $this->query($filters)->exists();
    }

    protected function query(array $filters = [], array|bool $append = []): Builder
    {
        $query = Model::query();      

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
}
