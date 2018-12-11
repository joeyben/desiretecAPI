<?php

namespace Modules\Dashboard\Entities;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    protected $fillable = ['name', 'x', 'y', 'w', 'h', 'i', 'component'];
}
