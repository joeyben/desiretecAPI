<?php


namespace App\Models\Layers;


use Illuminate\Database\Eloquent\Model;

class Layer extends Model
{
    protected $fillable = [
        'paths',
        'category',
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
        $this->table = config('module.layers.table');
    }
}
