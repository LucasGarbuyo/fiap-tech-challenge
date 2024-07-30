<?php

namespace TechChallenge\Infra\DB\Eloquent\Customer;

use TechChallenge\Domain\Customer\DAO\ICustomer as ICustomerDAO;
use Illuminate\Database\Eloquent\Builder;

final class DAO implements ICustomerDAO
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

    public function store(array $customer): void
    {
        Model::create($customer);
    }

    public function show(array $filters = [], array|bool $append = []): ?array
    {
        return $this->query($filters, $append)->first()->toArray();
    }

    public function update(array $customer): void
    {
        Model::where("id", $customer["id"])->update([
            "name"        => $customer["name"],
            "cpf"         => $customer["cpf"],
            "email"       => $customer["email"],
            "created_at"  => $customer["created_at"],
            "updated_at"  => $customer["updated_at"],
            "deleted_at"  => $customer["deleted_at"],
        ]);
    }

    public function delete(array $customer): void
    {
        Model::where("id", $customer["id"])->update([
            "name"        => $customer["name"],
            "cpf"         => $customer["cpf"],
            "email"       => $customer["email"],
            "created_at"  => $customer["created_at"],
            "updated_at"  => $customer["updated_at"],
            "deleted_at"  => $customer["deleted_at"],
        ]);
    }

    public function exist(array $filters = []): bool
    {
        return $this->query($filters)->exists();
    }

    protected function query(array $filters = [], array|bool $append = []): Builder
    {
        $query = Model::query();

        if (!empty($filters["id"])) {
            if (!is_array($filters["id"]))
                $filters["id"] = [$filters["id"]];

            $query->whereIn('id', $filters["id"]);
        }

        if (!empty($filters["not-id"])) {
            if (!is_array($filters["not-id"]))
                $filters["not-id"] = [$filters["not-id"]];

            $query->whereNotIn('id', $filters["not-id"]);
        }

        if (!empty($filters["cpf"])) {
            if (!is_array($filters["cpf"]))
                $filters["cpf"] = [$filters["cpf"]];

            $query->whereIn('cpf', $filters["cpf"]);
        }

        return $query;
    }
}
