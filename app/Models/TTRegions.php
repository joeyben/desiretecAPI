<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTRegions extends Model
{
    protected $fillable = [
        'ort',
        'region',
        'land',
        'topRegion',
        'topRegionName'
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
        $this->table = 'TTRegions';
    }
}
