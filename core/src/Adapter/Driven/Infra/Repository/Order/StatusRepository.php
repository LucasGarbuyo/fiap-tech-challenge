<?php

namespace TechChallenge\Adapter\Driven\Infra\Repository\Order;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use TechChallenge\Domain\Order\Entities\Status as StatusEntity;
use TechChallenge\Domain\Order\Repository\IStatus as IStatusRepository;
use TechChallenge\Domain\Order\Enum\OrderStatus;

class StatusRepository implements IStatusRepository
{
    public function index(array $filters = []): array
    {
        $statusData = $this->filters($this->query(), $filters)->get();

        if (count($statusData) == 0)
            return [];

        $statusHistories = [];

        foreach ($statusData as $status) {
            $statusHistories[] = StatusEntity::create(
                $status->id,
                $status->order_id,
                OrderStatus::from($status->status),
                new DateTime($status->created_at),
                new DateTime($status->updated_at)
            );
        }

        return $statusHistories;
    }

    public function store(StatusEntity $status): void
    {
        $this->query()
            ->insert([
                "id" => $status->getId(),
                "order_id" => $status->getOrderId(),
                "status" => $status->getStatus(),
                "created_at" => $status->getCreatedAt(),
                "updated_at" => $status->getUpdatedAt()
            ]);
    }

    public function filters(Builder $query, array $filters = []): Builder
    {
        if (!empty($filters["id"])) {
            if (!is_array($filters["id"]))
                $filters["id"] = [$filters["id"]];

            $query->whereIn('id', $filters["id"]);
        }

        if (!empty($filters["order_id"])) {
            if (!is_array($filters["order_id"]))
                $filters["order_id"] = [$filters["order_id"]];

            $query->whereIn('order_id', $filters["order_id"]);
        }

        return $query;
    }

    public function query(): Builder
    {
        return DB::table('order_status')->whereNull('deleted_at');
    }
}
