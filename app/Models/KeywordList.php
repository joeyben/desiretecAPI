<?php

namespace App\Models;

use App\Models\ModelTrait;
use App\Models\Wishes\Traits\Attribute\WishAttribute;
use App\Models\Wishes\Traits\Relationship\WishRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
