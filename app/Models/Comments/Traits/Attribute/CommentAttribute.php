<?php

namespace App\Models\Comments\Traits\Attribute;

/**
 * Class CommentAttribute.
 */
trait CommentAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">'.
                $this->getEditButtonAttribute('edit-wish', 'admin.comments.edit').
                $this->getDeleteButtonAttribute('delete-wish', 'admin.comments.destroy').
                '</div>';
    }

    /**
     * @return string
     */
    public function getActionButtonsUserAttribute()
    {
        return '<div class="btn-group action-btn">'.
            $this->getEditButtonAttribute('edit-wish', 'frontend.comments.edit').
            $this->getDeleteButtonAttribute('delete-wish', 'frontend.comments.destroy').
            '</div>';
    }

    /**
     * @return string
     */
    public function getActionCommentOffersAttribute()
    {
        return '<a href="'.route("frontend.offers.showoffers" , $this).'">'.
            $this->total_offers.
            '</a>';
    }

}
