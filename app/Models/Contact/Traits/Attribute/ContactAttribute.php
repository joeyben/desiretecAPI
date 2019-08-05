<?php

namespace App\Models\Contact\Traits\Attribute;

/**
 * Class ContactAttribute.
 */
trait ContactAttribute
{
    /**
     * @return string
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
