<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Categories\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use KodeKeep\Categories\Models\Category;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;

/**
 * Class EloquentPostsRepository.
 */
class EloquentCategoriesRepository extends RepositoryAbstract implements CategoriesRepository
{
    public function model()
    {
        return Category::class;
    }

    /**
     * Find data by multiple values in one field.
     *
     * @param       $column
     * @param       $field
     * @param array $columns
     *
     * @return mixed
     */
    public function getChildrenFromSlug($column, $field, $columns = ['*'])
    {
        $parent = $this->model->where($column, $field)->first($columns);
        if ($parent) {
            $parent = $parent->toArray();
        }
        $children = $this->model->where('parent_id', $parent['id'])->select('value', 'name')->get();
        if ($children) {
            $children = $children->toArray();
        }
        $category = [];

        foreach ($children as $key => $value) {
            $category[$value['value']] = $value['name'];
        }

        return $category;
    }

    /**
     * Find data by multiple values in one field.
     *
     * @param $value
     * @param $field
     *
     * @return mixed
     */
    public function getCategoryByParentValue($field, $value)
    {
        $parent = $this->model->where('value', $field)->first(['id']);
        if ($parent) {
            $parent = $parent->toArray();
        }
        $child = $this->model->where('parent_id', $parent['id'])->where('value', $value)->first(['name']);
        if ($child) {
            $child = $child->toArray();
        }

        return $child['name'];
    }

    /**
     * Find data by multiple values in one field.
     *
     * @param $value
     * @param $field
     *
     * @return mixed
     */
    public function getCategoryIdByParentValue($field, $value)
    {
        $parent = $this->model->where('value', $field)->first(['id']);
        if ($parent) {
            $parent = $parent->toArray();
        }
        $child = $this->model->where('parent_id', $parent['id'])->where('value', $value)->first(['id']);
        if ($child) {
            $child = $child->toArray();
        }

        return $child['id'];
    }
}
