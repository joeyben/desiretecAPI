<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Categories\Repositories\Eloquent;

use App\Repositories\RepositoryAbstract;
use BrianFaust\Categories\Models\Category;
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
     * @param        $column
     * @param        $field
     * @param array  $columns
     * @return mixed
     */
    public function getChildrenFromSlug($column, $field, $columns = ['*'])
    {
        $parent     = $this->model->where($column, $field)->first($columns)->toArray();
        $children   = $this->model->where('parent_id', $parent['id'])->pluck('slug')->toArray();
        $children = array_combine($children, $children);
        return $children;
    }
}
