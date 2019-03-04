<?php

namespace App\Models\Contact;

use App\Models\BaseModel;
use App\Models\Contact\Traits\Attribute\ContactAttribute;
use App\Models\Contact\Traits\Relationship\ContactRelationship;
use App\Models\ModelTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends BaseModel
{
    use ModelTrait,
        SoftDeletes,
        ContactAttribute,
        ContactRelationship {
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'telephone',
        'subject',
        'message',
        'period',
        'created_by',
        'wish_id',
        'group_id',
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
        $this->table = config('module.contact.table');
    }
}
