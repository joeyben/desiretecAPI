<?php

namespace App\Models\Groups\Traits\Attribute;

/**
 * Class GroupAttribute.
 */
trait GroupAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">'.
                $this->getEditButtonAttribute('edit-group', 'admin.groups.edit').
                $this->getDeleteButtonAttribute('delete-group', 'admin.groups.destroy').
                '</div>';
    }

    /**
     * @return string
     */
    public function getActionButtonsUserAttribute()
    {
        return '<div class="btn-group action-btn">'.
            $this->getEditButtonAttribute('edit-group', 'frontend.groups.edit').
            $this->getDeleteButtonAttribute('delete-group', 'frontend.groups.destroy').
            '</div>';
    }


}
