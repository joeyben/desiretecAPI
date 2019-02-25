<?php

namespace App\Models\OfferFiles;

use App\Models\BaseModel;
use App\Models\ModelTrait;
use App\Models\Offers\Traits\Attribute\OfferAttribute;
use App\Models\Offers\Traits\Relationship\OfferRelationship;

class OfferFile extends BaseModel
{
    use ModelTrait,
        OfferAttribute,
        OfferRelationship {
        // BlogAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    protected $fillable = [
        'offer_id',
        'file',
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
        $this->table = config('module.offer_files.table');
    }
}
