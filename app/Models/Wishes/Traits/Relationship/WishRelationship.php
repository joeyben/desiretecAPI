<?php

namespace App\Models\Wishes\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\Comments\Comment;
use App\Models\Groups\Group;
use App\Models\Offers\Offer;

/**
 * Class WishRelationship.
 */
trait WishRelationship
{

    /**
     * Wishes belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Wishes belongsTo with Group.
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(config('access.whitelabel'));
    }

    /**
     * Wishes HasMany  Offers.
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * Wishes HasMany  Comments.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $whitelabel
     *
     * @return void
     */
    public function attachWhitelabel($whitelabel)
    {
        if (is_object($whitelabel)) {
            $whitelabel = $whitelabel->getKey();
        }

        if (is_array($whitelabel)) {
            $whitelabel = $whitelabel['id'];
        }

        $this->whitelabels()->attach($whitelabel);
    }

    /**
     * Attach multiple whitelabels to a wish.
     *
     * @param mixed $whitelabels
     *
     * @return void
     */
    public function attachWhitelabels($whitelabels)
    {
        foreach ($whitelabels as $whitelabel) {
            $this->attachWhitelabel($whitelabel);
        }
    }

    public function getTotalOffersAttribute()
    {
        return $this->hasMany(Offer::class)->count();

    }
}