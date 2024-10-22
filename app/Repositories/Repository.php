<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Concerns\RepositoryContract;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class Repository implements RepositoryContract
{
    /**
     * Constructor for the BaseRepository class.
     *
     * @param Builder $query The query builder instance.
     * @param DatabaseManager $database The database manager instance.
     */
    public function __construct(
        private readonly Builder $query,
        private readonly DatabaseManager $database,
    ) {}

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, \Illuminate\Database\Eloquent\Model>
     */
    public function all(): Collection
    {
        return $this->query->get();
    }

    /**
     * @param array<string,mixed> $attributes
     *
     * @return void
     */
    public function create(array $attributes): void
    {
        $this->database->transaction(
            callback: fn() => $this->query->create(
                attributes: $attributes,
            ),
            attempts: 3,
        );
    }

    /**
     * @param string $id
     *
     * @return void
     */
    public function delete(string $id): void
    {
        $this->database->transaction(
            callback: fn() => $this->query->where(
                column: 'id',
                operator: '=',
                value: $id,
            )->delete(),
            attempts: 3,
        );
    }

    /**
     * @param string $id
     *
     * @return Model|null
     */
    public function find(string $id): object|null
    {
        return $this->query->findOrFail(
            id: $id,
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, \Illuminate\Database\Eloquent\Model>|\Illuminate\Pagination\LengthAwarePaginator<\Illuminate\Database\Eloquent\Model>
     */
    public function paginate(): Collection|LengthAwarePaginator
    {
        return $this->query->paginate(perPage: request('perPage', 15));
    }

    /**
     * @param string $id
     * @param array<string,mixed> $attributes
     *
     * @return void
     */
    public function update(string $id, array $attributes): void
    {
        $this->database->transaction(
            callback: fn() => $this->query->where(
                column: 'id',
                operator: '=',
                value: $id,
            )->update(
                values: $attributes,
            ),
            attempts: 3,
        );
    }
}