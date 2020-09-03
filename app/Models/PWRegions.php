<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PWRegions extends Model
{
    protected $fillable = [
        'code',
        'name',
        'country_name',
        'country_code',
        'name_en',
        'country_name_en',
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
        $this->table = 'PWRegions';
    }
}
