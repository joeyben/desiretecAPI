<?php

namespace Modules\Wishes\Entities;

use App\Models\Agents\Agent;
use App\Models\Groups\Group;
use App\Models\Offers\Offer;
use App\Models\Whitelabels\Whitelabel;
use BrianFaust\Categories\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Wish extends Model
{
    use SoftDeletes;
    use SearchableTrait;
    use LogsActivity;

    protected $guarded = [];

    protected static $logAttributes = [
        'title',
        'featured_image',
        'description',
        'airport',
        'destination',
        'earliest_start',
        'latest_return',
        'budget',
        'adults',
        'kids',
        'pets',
        'rooms',
        'category',
        'catering',
        'duration',
        'status',
        'created_by',
        'group_id',
        'updated_by',
        'whitelabel_id',
        'agent_id',
        'extra_params',
        'version'
    ];

    protected static $logOnlyDirty = true;

    protected $casts = [
        'status'  => 'boolean',
    ];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /*
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'wishes.id'                         => 10,
            'wishes.title'                      => 10,
            'users.first_name'                  => 10,
            'users.last_name'                   => 10,
            'users.email'                       => 10,
            'groups.name'                       => 10,
            'groups.display_name'               => 10,
            'whitelabels.name'                  => 10,
            'whitelabels.display_name'          => 10,
        ],
        'joins' => [
            'users'       => ['wishes.created_by', 'users.id'],
            'groups'      => ['wishes.group_id', 'groups.id'],
            'whitelabels' => ['wishes.whitelabel_id', 'whitelabels.id'],
        ]
    ];

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
     * Wishes belongsTo with Group.
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(Whitelabel::class);
    }

    /**
     * Wishes hasMany Offers.
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    /**
     * @return mixed
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, config('access.categories_wish_table'), 'wish_id', 'category_id');
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $category
     */
    public function attachCategory($category)
    {
        if (\is_object($category)) {
            $category = $category->getKey();
        }

        if (\is_array($category)) {
            $category = $category['id'];
        }

        $this->categories()->attach($category);
    }
}
