<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface RepositoryInterface
{
    public function all(): Collection;

    /**
     * Alias of All method.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function get($columns = ['*']);

    /**
     * @return mixed
     */
    public function find(int $id);

    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function first($columns = ['*']);

    /**
     * @param $value
     *
     * @return mixed
     */
    public function findWhere(string $column, $value);

    /**
     * @param $value
     *
     * @return mixed
     */
    public function findWhereFirst(string $column, $value);

    /**
     * Find data by excluding multiple values in one field.
     *
     * @param       $field
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*']);

    /**
     * Find data by excluding multiple values in one field.
     *
     * @param       $field
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*']);

    public function paginate(int $perPage): LengthAwarePaginator;

    /**
     * @return mixed
     */
    public function create(array $data);

    /**
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * @return mixed
     */
    public function delete(int $id);

    /**
     * @return mixed
     */
    public function forceDelete(int $id);

    /**
     * @return mixed
     */
    public function restore(int $id);

    /**
     * Retrieve data array for populate field select
     * Compatible with Laravel 5.3.
     *
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function pluck($column, $key = null);

    /**
     * Sync relations.
     *
     * @param      $id
     * @param      $relation
     * @param      $attributes
     * @param bool $detaching
     *
     * @return mixed
     */
    public function sync($id, $relation, $attributes, $detaching = true);

    /**
     * SyncWithoutDetaching.
     *
     * @param $id
     * @param $relation
     * @param $attributes
     *
     * @return mixed
     */
    public function syncWithoutDetaching($id, $relation, $attributes);

    /**
     * Retrieve first data of repository, or return new Entity.
     *
     * @return mixed
     */
    public function firstOrNew(array $attributes = []);

    /**
     * Retrieve first data of repository, or return new Entity.
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes = []);

    public function supportedLocales(): array;
}
