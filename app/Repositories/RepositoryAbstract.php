<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:30.
 */

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Criteria\CriteriaInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Modules\System\Services\Facades\System;

/**
 * Class RepositoryAbstract.
 */
abstract class RepositoryAbstract implements RepositoryInterface, CriteriaInterface
{
    protected $model;

    /**
     * RepositoryAbstract constructor.
     */
    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    /**
     * @return mixed
     */
    abstract public function model();

    /**
     * @param array $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all($columns = ['*']): Collection
    {
        return $this->model->get($columns);
    }

    /**
     * Alias of All method.
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function get($columns = ['*'])
    {
        return $this->all($columns);
    }

    /**
     * @param mixed ...$criteria
     *
     * @return $this
     */
    public function withCriteria(...$criteria)
    {
        $criteria = array_flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->model = $criterion->apply($this->model);
        }

        return $this;
    }

    /**
     * @param int   $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find(int $id, $columns = ['*'])
    {
        return $this->model->findOrFail($id, $columns);
    }

    /**
     * @param array $columns
     *
     * @return mixed
     */
    public function first($columns = ['*'])
    {
        return $this->model->firstOrFail($columns);
    }

    /**
     * @param string $column
     * @param        $value
     * @param array  $columns
     *
     * @return mixed
     */
    public function findWhere(string $column, $value = null, $columns = ['*'])
    {
        $model = $this->model->where($column, $value)->get($columns);
        $this->modelNotFoundException($model);

        return $model;
    }

    /**
     * @param string $column
     * @param        $value
     * @param array  $columns
     *
     * @return mixed
     */
    public function findWhereFirst(string $column, $value, $columns = ['*'])
    {
        $model = $this->model->where($column, $value)->first($columns);
        $this->modelNotFoundException($model);

        return $model;
    }

    /**
     * Find data by multiple values in one field.
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        $model = $this->model->whereIn($field, $values)->get($columns);
        $this->modelNotFoundException($model);

        return $model;
    }

    /**
     * Find data by excluding multiple values in one field.
     *
     * @param       $field
     * @param array $values
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        $model = $this->model->whereNotIn($field, $values)->get($columns);
        $this->modelNotFoundException($model);

        return $model;
    }

    /**
     * @param int|null $perPage
     * @param array    $columns
     * @param string   $method
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(int $perPage = null, $columns = ['*'], $method = 'paginate'): LengthAwarePaginator
    {
        $perPage = null === $perPage ? System::perPage() : $perPage;

        return $this->model->{$method}($perPage, $columns);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param int   $id
     * @param array $data
     *
     * @return mixed
     */
    public function update(int $id, array $data)
    {
        $record = $this->find($id);
        $record->update($data);

        return $record;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function delete(int $id)
    {
        $record = $this->find($id);
        $record->delete();

        return $record;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function forceDelete(int $id)
    {
        $record = $this->model->onlyTrashed()->findOrFail($id);
        $record->forceDelete();

        return $record;
    }

    /**
     * @param int $id
     *
     * @return mixed
     */
    public function restore(int $id)
    {
        $record = $this->model->onlyTrashed()->findOrFail($id);
        $record->restore();

        return $record;
    }

    /**
     * @throws \Exception
     *
     * @return mixed
     */
    protected function resolveModel()
    {
        $model = app()->make($this->model());

        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $model;
    }

    /**
     * @param $model
     */
    private function modelNotFoundException($model)
    {
        if (!$model) {
            throw (new ModelNotFoundException())->setModel(\get_class($this->model->getModel()));
        }
    }

    /**
     * Retrieve data array for populate field select
     * Compatible with Laravel 5.3.
     *
     * @param string      $column
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection|array
     */
    public function pluck($column, $key = null)
    {
        return $this->model->pluck($column, $key);
    }

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
    public function sync($id, $relation, $attributes, $detaching = true)
    {
        return $this->find($id)->{$relation}()->sync($attributes, $detaching);
    }

    /**
     * SyncWithoutDetaching.
     *
     * @param $id
     * @param $relation
     * @param $attributes
     *
     * @return mixed
     */
    public function syncWithoutDetaching($id, $relation, $attributes)
    {
        return $this->sync($id, $relation, $attributes, false);
    }

    /**
     * Retrieve first data of repository, or return new Entity.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrNew(array $attributes = [])
    {
        return $this->model->firstOrNew($attributes);
    }

    /**
     * Retrieve first data of repository, or return new Entity.
     *
     * @param array $attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes = [])
    {
        return $this->model->firstOrCreate($attributes);
    }

    /**
     * @return array
     */
    public function supportedLocales(): array
    {
        $languages = LaravelLocalization::getSupportedLocales();
        $lang = [];

        foreach ($languages as $localeCode => $properties) {
            $lang[] = $localeCode;
        }

        return $lang;
    }
}
