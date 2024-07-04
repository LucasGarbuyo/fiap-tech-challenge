<?php

namespace TechChallenge\Infra\DB\Eloquent\Product;

use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use Illuminate\Database\Eloquent\Builder;

final class DAO implements IProductDAO
{
    public function index(array $filters = [], array|bool $append = []): array
    {
        $query = $this->query($filters, $append);

        if (!empty($filters["pag"]) && !empty($filters["prp"])) {
            $paginator = $query->paginate(perPage: $filters["pag"], page: $filters["page"]);

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

        return $query->get();
    }

    public function store(array $category): void
    {
        Model::create($category);
    }

    public function show(array $filters = [], array|bool $append = []): ?array
    {
        $query = $this->query($filters, $append);

        return $query->first();
    }

    public function update(array $category): void
    {
    }

    public function delete(array $category): void
    {
    }

    public function exist(array $filters = []): bool
    {
        // $query = $this->query($filters);

        // return $query->has
    }

    protected function query(array $filters = [], array|bool $append = []): Builder
    {
        $query = Model::query();

        return $query;
    }
}
