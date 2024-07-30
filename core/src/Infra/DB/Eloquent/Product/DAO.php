<?php

namespace TechChallenge\Infra\DB\Eloquent\Product;

use TechChallenge\Domain\Product\DAO\IProduct as IProductDAO;
use Illuminate\Database\Eloquent\Builder;

final class DAO implements IProductDAO
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
        return $query->get()->toArray();
    }

    public function store(array $product): void
    {
        Model::create($product);
    }

    public function show(array $filters = [], array|bool $append = []): ?array
    {
        return $this->query($filters, $append)->first()->toArray();
    }

    public function update(array $product): void
    {
        Model::where("id", $product["id"])->update([
            "category_id" => $product["category_id"],
            "name"        => $product["name"],
            "description" => $product["description"],
            "price"       => $product["price"],
            "image"       => $product["image"],
            "created_at"  => $product["created_at"],
            "updated_at"  => $product["updated_at"],
            "deleted_at"  => $product["deleted_at"],
        ]);
    }

    public function delete(array $product): void
    {
        Model::where("id", $product["id"])->update([
            "category_id" => $product["category_id"],
            "name"        => $product["name"],
            "description" => $product["description"],
            "price"       => $product["price"],
            "image"       => $product["image"],
            "created_at"  => $product["created_at"],
            "updated_at"  => $product["updated_at"],
            "deleted_at"  => $product["deleted_at"],
        ]);
    }

    public function exist(array $filters = []): bool
    {
        return $this->query($filters)->exists();
    }

    protected function query(array $filters = [], array|bool $append = []): Builder
    {
        $query = Model::query();

        if ($append === true || in_array("category", $append))
            $query->with("category");

        if (!empty($filters["id"])) {
            if (!is_array($filters["id"]))
                $filters["id"] = [$filters["id"]];

            $query->whereIn('id', $filters["id"]);
        }

        return $query;
    }
}
