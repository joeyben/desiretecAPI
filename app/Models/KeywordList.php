<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeywordList extends Model
{
    protected $fillable = [
        'code',
        'name',
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
        $this->table = 'KeywordList';
    }
}
