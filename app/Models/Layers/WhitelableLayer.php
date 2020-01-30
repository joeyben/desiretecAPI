<?php


namespace App\Models\Layers;


use App\Models\Layers\Layer;
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

    public function layers(){
        return $this->hasOne(Layer::Class, 'id', 'layer_id');
    }
}
