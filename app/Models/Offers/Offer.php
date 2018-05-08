<?php

namespace App\Models\Offers;

use App\Models\BaseModel;
use App\Models\Offers\Traits\Attribute\OfferAttribute;
use App\Models\Offers\Traits\Relationship\OfferRelationship;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        OfferAttribute,
        OfferRelationship {
        // BlogAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    protected $fillable = [
        'title',
        'description',
        'status',
        'file',
        'created_by',
        'wish_id',
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
        $this->table = config('module.offers.table');
    }
}