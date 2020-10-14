<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BestfewoRange extends Model
{
    protected $fillable = [
        'obj_id',
        'max_guests',
        'max_adults',
        'max_children',
        'max_children_age',
        'type',
        'city',
        'zipcode',
        'region',
        'country',
        'latitude',
        'longitude',
        'to',
        'from',
        'price'
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
        $this->table = 'BestfewoRange';
    }
}
