<?php

namespace Modules\Variants\Entities;

use App\Models\Access\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attachments\Traits\AttachableTrait;
use Modules\Whitelabels\Entities\LayerWhitelabel;
use Modules\Whitelabels\Entities\Whitelabel;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Translatable\HasTranslations;

class Variant extends Model
{
    use SoftDeletes;
    use SearchableTrait;
    use LogsActivity;
    use HasTranslations;
    use AttachableTrait;

    protected $guarded = [];

    public $translatable = ['headline', 'subheadline', 'headline_success', 'subheadline_success'];

    protected $casts = [
        'active'  => 'boolean'
    ];


    protected static $logOnlyDirty = true;

    protected static $logAttributes = [
        'layer_url',
        'color',
        'privacy',
        'active',
        'layer_whitelabel_id',
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
            'variants.id'                         => 10,
            'variants.layer_url'                       => 10,
            'variants.headline'               => 10,
            'variants.subheadline'                  => 10,
            'variants.headline_success'                   => 10,
            'variants.privacy'                       => 10,
            'whitelabels.name'                  => 10,
            'whitelabels.display_name'          => 10,
        ],
        'joins' => [
            'whitelabels' => ['variants.whitelabel_id', 'whitelabels.id'],
        ]
    ];


    public function layerWhitelabel()
    {
        return $this->belongsTo(LayerWhitelabel::class);
    }

    /**
     * Wishes belongsTo with Whitelabel.
     */
    public function whitelabel()
    {
        return $this->belongsTo(Whitelabel::class);
    }

    /**
     * Wishes belongsTo with User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
