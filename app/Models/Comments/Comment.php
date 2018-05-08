<?php

namespace App\Models\Comments;

use App\Models\BaseModel;
use App\Models\Comments\Traits\Attribute\CommentAttribute;
use App\Models\Comments\Traits\Relationship\CommentRelationship;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        CommentAttribute,
        CommentRelationship {
        // BlogAttribute::getEditButtonAttribute insteadof ModelTrait;
    }

    protected $fillable = [
        'comment',
        'data_id',
        'type',
        'status',
        'created_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
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
        $this->table = config('module.comments.table');
    }
}
