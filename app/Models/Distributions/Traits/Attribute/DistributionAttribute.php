<?php

namespace App\Models\Distributions\Traits\Attribute;

/**
 * Class DistributionAttribute.
 */
trait DistributionAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">
                    '.$this->getEditButtonAttribute('edit-distribution', 'admin.distributions.edit').'
                    '.$this->getDeleteButtonAttribute('delete-distribution', 'admin.distributions.destroy').'
                </div>';
    }
}
