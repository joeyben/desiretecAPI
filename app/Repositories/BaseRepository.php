<?php

namespace App\Repositories;

/**
 * Class BaseRepository.
 */
class BaseRepository
{
    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->query()->get();
    }

    /**
     * Get Paginated.
     *
     * @param $per_page
     * @param string $active
     * @param string $order_by
     * @param string $sort
     *
     * @return mixed
     */
    public function getPaginated($per_page, $active = '', $order_by = 'id', $sort = 'asc')
    {
        if ($active) {
            return $this->query()->where('status', $active)
                ->orderBy($order_by, $sort)
                ->paginate($per_page);
        }

        return $this->query()->orderBy($order_by, $sort)
                ->paginate($per_page);
    }

    /**
     * @param string $column
     * @param string $operator
     * @param        $value
     * @param array  $columns
     *
     * @return mixed
     */
    public function findWhere(string $column, string $operator, $value = null, $columns = ['*'])
    {
        return $this->query()->where($column, $operator, $value)->get($columns);
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->query()->count();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->query()->find($id);
    }

    /**
     * @return mixed
     */
    public function query()
    {
        return \call_user_func(static::MODEL . '::query');
    }
}
