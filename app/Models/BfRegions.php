<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BfRegions extends Model
{
    protected $fillable = [
        'city',
        'region',
        'country',
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
        $this->table = 'bf_regions';
    }
}
