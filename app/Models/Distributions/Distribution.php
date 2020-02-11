<?php

namespace App\Models\Distributions;

use App\Models\BaseModel;
use App\Models\Distributions\Traits\Attribute\DistributionAttribute;
use App\Models\Distributions\Traits\Relationship\DistributionRelationship;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Distribution.
 */
class Distribution extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        DistributionAttribute,
        DistributionRelationship {
            // DistributionAttribute::getEditButtonAttribute insteadof ModelTrait;
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
    protected $fillable = ['name', 'display_name', 'description'];

    protected $attributes = [
        'created_by' => 1,
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('module.distributions.table');
    }
}
