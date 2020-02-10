<?php

namespace App\Models\Access\Permission;

use App\Models\Access\Permission\Traits\Attribute\PermissionAttribute;
use App\Models\Access\Permission\Traits\Relationship\PermissionRelationship;
use App\Models\BaseModel;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * Class Permission.
 */
class Permission extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        SearchableTrait,
        PermissionAttribute,
        PermissionRelationship {
            // PermissionAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'sort'];

    protected $attributes = [
        'created_by' => 1,
    ];

    protected $searchable = [
        /*
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'permissions.id'                         => 10,
            'permissions.name'                       => 10,
            'permissions.display_name'               => 10,
            'users.first_name'                       => 10,
            'users.last_name'                        => 10,
            'users.email'                            => 10,
        ],
        'joins' => [
            'users'       => ['permissions.created_by', 'users.id'],
        ]
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('access.permissions_table');
    }
}
