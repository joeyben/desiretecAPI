<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TTAirports extends Model
{
    protected $fillable = [
        'name',
        'code',
        'whitelabel'
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
        $this->table = 'TTAirports';
    }
}
