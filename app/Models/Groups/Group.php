<?php

namespace App\Models\Groups;

use App\Models\BaseModel;
use App\Models\Groups\Traits\Attribute\GroupAttribute;
use App\Models\Groups\Traits\Relationship\GroupRelationship;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        GroupAttribute,
        GroupRelationship {
        // BlogAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'status',
        'created_by',
        'whitelabel_id',
        'lastwish',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('module.groups.table');
    }
}
