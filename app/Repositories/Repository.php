<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected Model $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): ?Model
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(array $data, int $id): bool
    {
        $record = $this->model->newQuery()->find($id);

        return $record->update($data);
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id);
    }

    public function one(int $id): ?Model
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function with($relations, $callback = null): Builder
    {
        return $callback
            ? $this->model->with($relations, $callback)
            : $this->model->with($relations);
    }

    public function orderBy(Builder $query, string $orderColumn, string $orderName = 'ASC'): void
    {
        $query->orderBy($orderColumn, $orderName);
    }

    public function getByQuery(Builder $query): Collection
    {
        return $query->get();
    }

    public function takeOffsetCollectionByQuery(Builder $query, int $offset, int $limit): Collection
    {
        return $query->offset($offset)->take($limit)->get();
    }

    public function allWithPaginate(int $limit = 10)
    {
        return $this->model->newQuery()->paginate($limit);
    }
}
