<?php

namespace App\Models\Access\User\Traits\Relationship;

use App\Models\Access\User\SocialLogin;
use App\Models\System\Session;
use Modules\Dashboard\Entities\Dashboard;
use App\Models\Messages\Message;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * Many-to-Many relations with Role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(config('access.role'), config('access.role_user_table'), 'user_id', 'role_id');
    }

    /**
     * Many-to-Many relations with Whitelabel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function whitelabels()
    {
        return $this->belongsToMany(config('access.whitelabel'), config('access.whitelabel_user_table'), 'user_id', 'whitelabel_id');
    }

    /**
     * Many-to-Many relations with Group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(config('access.group'), config('access.group_user_table'), 'user_id', 'group_id');
    }

    /**
     * Many-to-Many relations with Permission.
     * ONLY GETS PERMISSIONS ARE NOT ASSOCIATED WITH A ROLE.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(config('access.permission'), config('access.permission_user_table'), 'user_id', 'permission_id');
    }

    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialLogin::class);
    }

    /**
     * @return mixed
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dashboards()
    {
        return $this->belongsToMany(Dashboard::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
