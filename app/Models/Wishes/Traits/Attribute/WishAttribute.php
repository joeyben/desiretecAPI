<?php

namespace App\Models\Wishes\Traits\Attribute;

/**
 * Class WishAttribute.
 */
trait WishAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">' .
                $this->getEditButtonAttribute('edit-wish', 'admin.wishes.edit') .
                $this->getDeleteButtonAttribute('delete-wish', 'admin.wishes.destroy') .
                '</div>';
    }

    /**
     * @return string
     */
    public function getActionButtonsUserAttribute()
    {
        return '<div class="btn-group action-btn">' .
            $this->getEditButtonAttribute('edit-wish', 'frontend.wishes.edit') .
            $this->getDeleteButtonAttribute('delete-wish', 'frontend.wishes.destroy') .
            '</div>';
    }

    /**
     * @return string
     */
    public function getActionWishOffersAttribute()
    {
        return '<a href="' . route('frontend.offers.showoffers', $this) . '">' .
            $this->total_offers .
            '</a>';
    }

    /**
     * @return string
     */
    public function getDurationAttribute($value)
    {
        return transformDuration($value);
    }

    /**
     * @return string
     */
    public function getAdultsAttribute($value)
    {
        return transformTravelers($value, 'adults');
    }

    /**
     * @return string
     */
    public function getKidsAttribute($value)
    {
        return transformTravelers($value, 'kids');
    }

}
