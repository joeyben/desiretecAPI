<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bestfewo extends Model
{
    protected $fillable = [
        'obj_id',
        'link',
        'max_guests',
        'max_adults',
        'max_children',
        'max_children_age',
        'size',
        'bedrooms',
        'type',
        'city',
        'zipcode',
        'region',
        'country',
        'latitude',
        'longitude',
        'data'
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
        $this->table = 'Bestfewo';
    }
}
