<?php

namespace TechChallenge\Infra\DB\Eloquent\Category;

use TechChallenge\Domain\Category\DAO\ICategory as ICategoryDAO;
use Illuminate\Database\Eloquent\Builder;

class DAO implements ICategoryDAO
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

    public function store(array $category): void
    {
        Model::create($category);
    }

    public function show(array $filters = [], array|bool $append = []): ?array
    {
        return $this->query($filters, $append)->first()->toArray();
    }

    public function update(array $category): void
    {
        Model::where("id", $category["id"])->update($category);
    }

    public function delete(array $category): void
    {
        Model::where("id", $category["id"])->update($category);
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

        return $query;
    }
}
