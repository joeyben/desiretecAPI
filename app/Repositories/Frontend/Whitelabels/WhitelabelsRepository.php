<?php

namespace App\Repositories\Frontend\Whitelabels;

use App\Models\Whitelabels\Whitelabel;
use App\Repositories\BaseRepository;
use Modules\Attachments\Entities\Attachment;

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
            ])
            ->where(config('module.whitelabels.table') . '.name', 'LIKE', '%' . $name . '%')
            ->first()
            ->toArray();
        $attachments = Attachment::select([
            config('module.attachments.table') . '.basename',
            config('module.attachments.table') . '.type',
        ])
            ->where('attachable_id', $query['id'])->get()->toArray();

        foreach ($attachments as $attachment) {
            $query['attachments'][str_replace('whitelabels/', '', $attachment['type'])] = $attachment['url'];
        }

        return $query;
    }
}
