<?php

namespace Modules\Groups\Entities;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [];

    /**
     * Many-to-Many relations with Group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
