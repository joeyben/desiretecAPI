<?php

namespace Modules\Whitelabels\Entities;

use App\Models\Distributions\Distribution;
use App\Models\Layers\Layer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Schema;
use Modules\Attachments\Traits\AttachableTrait;
use Modules\Footers\Entities\Footer;
use Modules\Languages\Entities\Language;
use Modules\Wishes\Entities\Wish;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class Whitelabel extends Model
{
    use SoftDeletes;
    use SearchableTrait;
    use LogsActivity;
    use AttachableTrait;

    protected $fillable = [
        'name',
        'display_name',
        'status',
        'domain',
        'ga_view_id',
        'email',
        'created_by',
        'distribution_id',
        'ga_view_id',
        'state',
        'layer',
        'color',
        'licence',
        'headline',
        'headline_color',
        'subheadline',
        'headline_success',
        'subheadline_success'
    ];

    protected static $logAttributes = [
        'name',
        'email',
        'display_name',
        'status',
        'created_by',
        'distribution_id',
        'ga_view_id',
        'color',
        'headline',
        'licence',
        'subheadline',
        'headline_success',
        'subheadline_success'
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
            'whitelabels.id'                         => 10,
            'whitelabels.name'                       => 10,
            'whitelabels.display_name'               => 10,
            'whitelabels.domain'                     => 10,
            'whitelabels.email'                      => 10,
            'users.first_name'                       => 10,
            'users.last_name'                        => 10,
            'users.email'                            => 10,
            'distributions.name'                     => 10,
            'distributions.display_name'             => 10,
        ],
        'joins' => [
            'users'         => ['whitelabels.created_by', 'users.id'],
            'distributions' => ['whitelabels.distribution_id', 'distributions.id'],
        ]
    ];

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        self::deleted(function ($whitelabel) {
            if ($whitelabel->isForceDeleting()) {
                Schema::dropIfExists('language_lines_' . mb_strtolower($whitelabel->name));
            }
        });
    }

    /**
     * Wishes belongsTo with User.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'), 'whitelabel_user', 'whitelabel_id', 'user_id');
    }

    /**
     * get the wishes for a Whitelabel.
     */
    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    /**
     * get languages(locales) for a Whitelabel.
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    /**
     * get languages(locales) for a Whitelabel.
     */
    public function footers()
    {
        return $this->hasMany(Footer::class);
    }

    public function hosts()
    {
        return $this->hasMany(WhitelabelHost::class);
    }

    /**
     * get the distribution for a Whitelabel.
     */
    public function distribution()
    {
        return $this->hasOne(Distribution::class, 'id', 'distribution_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function layers()
    {
        return $this->belongsToMany(Layer::class)->withPivot([
            'id',
            'headline',
            'subheadline',
            'headline_success',
            'subheadline_success',
            'layer_url'
        ])->using(LayerWhitelabel::class);
    }
}
