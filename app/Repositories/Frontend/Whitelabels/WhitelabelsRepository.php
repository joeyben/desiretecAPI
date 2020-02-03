<?php

namespace App\Repositories\Frontend\Whitelabels;


use App\Exceptions\GeneralException;
use App\Models\Access\User\User;
use App\Models\Access\User\UserToken;
use App\Models\Whitelabels\Whitelabel;
use App\Repositories\BaseRepository;
use Auth;
use DB;

/**
 * Class WhitelabelsRepository.
 */
class WhitelabelsRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Whitelabel::class;


    
    protected $whitelabel_id = null;


    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getWhitelabelByName(string $name)
    {

        $query = $this->query()
            ->select([
                config('module.whitelabels.table') . '.id',
                config('module.whitelabels.table') . '.name',
                config('module.whitelabels.table') . '.display_name',
                config('module.whitelabels.table') . '.domain',
                config('module.whitelabels.table') . '.color',
                config('module.whitelabels.table') . '.email',
                config('module.whitelabels.table') . '.layer',
                config('module.attachments.table') . '.id as image_id',
                config('module.attachments.table') . '.name as image_name',
                config('module.attachments.table') . '.basename as image_basename',
                config('module.attachments.table') . '.type as image_type',
            ])
            ->leftjoin(config('module.attachments.table'), config('module.attachments.table') . '.attachable_id', '=', config('module.whitelabels.table') . '.id')
            ->where(config('module.whitelabels.table').'.name', 'LIKE', '%' . $name . '%')
            ->groupBy('image_id')
            ->get()
            ->toArray();


        return $query;
    }
}
