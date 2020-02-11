<?php

namespace App\Models\Whitelabels;

use App\Models\BaseModel;
use App\Models\ModelTrait;
use App\Models\Whitelabels\Traits\Attribute\WhitelabelAttribute;
use App\Models\Whitelabels\Traits\Relationship\WhitelabelRelationship;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Rules\Entities\Rule;

/**
 * Class Whitelabel.
 */
class Whitelabel extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        WhitelabelAttribute,
        WhitelabelRelationship {
            // WhitelabelAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'email', 'status', 'distribution_id', 'bg_image', 'ga_view_id'];

    protected $attributes = [
        'created_by' => 1,
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('module.whitelabels.table');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rules()
    {
        return $this->hasMany(Rule::class);
    }

    /**
     * @return bool
     */
    public function isAutooffer()
    {
        if ($this->rules->where('status', 1)->where('type', 'auto')->count() > 0) {
            return true;
        }

        return false;
    }
}
