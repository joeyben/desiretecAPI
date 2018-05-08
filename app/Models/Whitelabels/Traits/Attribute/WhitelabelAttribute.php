<?php

namespace App\Models\Whitelabels\Traits\Attribute;

/**
 * Class WhitelabelAttribute.
 */
trait WhitelabelAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">
                    '.$this->getEditButtonAttribute('edit-whitelabel', 'admin.whitelabels.edit').'
                    '.$this->getDeleteButtonAttribute('delete-whitelabel', 'admin.whitelabels.destroy').'
                </div>';
    }
}
