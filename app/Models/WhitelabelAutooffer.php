<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhitelabelAutooffer extends Model
{
    protected $fillable = [
        'whitelabel_id',
        'username',
        'password',
        'token',
        'type',
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
        $this->table = 'whitelabel_autooffer';
    }
}
