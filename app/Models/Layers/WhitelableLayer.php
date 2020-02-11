<?php

namespace App\Models\Layers;

use Illuminate\Database\Eloquent\Model;

class WhitelableLayer extends Model
{
    protected $fillable = [
        'id',
        'whitelabel_id',
        'layer_id',
        'image',
        'headline',
        'subheadline',
        'headline_success',
        'subheadline_success',
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
        $this->table = config('module.whitelabel_layers.table');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function layers()
    {
        return $this->hasOne(Layer::class, 'id', 'layer_id');
    }
}
