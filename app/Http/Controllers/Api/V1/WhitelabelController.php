<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Where;
use App\Repositories\Frontend\Whitelabels\WhitelabelsRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository as ModuleWhitelabelsRepository;

/**
 * Class WhitelabelController.
 */
class WhitelabelController extends Controller
{
    private $whitelabels;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $moduleWhitelabelsRepository;

    public function __construct(WhitelabelsRepository $whitelabels, ModuleWhitelabelsRepository $moduleWhitelabelsRepository)
    {
        $this->whitelabels = $whitelabels;
        $this->moduleWhitelabelsRepository = $moduleWhitelabelsRepository;
    }


    public function getWhitelabelBySlug(string $slug)
    {
        $whitelabel = $this->moduleWhitelabelsRepository->withCriteria([
            new EagerLoad(['layers']),
            new Where('name', $slug),
        ])->first();

        $background = $this->moduleWhitelabelsRepository->getBackgroundImage($whitelabel);

        $logo = $this->moduleWhitelabelsRepository->getLogo($whitelabel);

        $favicon = $this->moduleWhitelabelsRepository->getFavicon($whitelabel);

        $visual = $this->moduleWhitelabelsRepository->getVisual($whitelabel);

        $result['data'] = [
            'id' => $whitelabel->id,
            'name' => $whitelabel->name,
            'display_name' => $whitelabel->display_name,
            'domain' => $whitelabel->domain,
            'ga_view_id' => $whitelabel->ga_view_id,
            'distribution_id' => $whitelabel->distribution_id,
            'subheadline_success' => $whitelabel->subheadline_success,
            'headline_success' => $whitelabel->headline_success,
            'subheadline' => $whitelabel->subheadline,
            'headline' => $whitelabel->headline,
            'color' => $whitelabel->color,
            'is_autooffer' => $whitelabel->is_autooffer,
            'licence' => $whitelabel->licence,
            'layers' => $whitelabel->layers,
        ];

        $result['data']['attachments']['background'] = (null !== $background && null !== $background->first()) ? $background->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/background/1581433096bg.jpg';
        $result['data']['attachments']['logo'] = (null !== $logo && null !== $logo->first()) ? $logo->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/logo/1581433101snapchat_PNG65.png';
        $result['data']['attachments']['favicon'] = (null !== $favicon && null !== $favicon->first()) ? $favicon->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/favicon/15734971451569923191Smile-only_3CPM_tilewhite.png';
        $result['data']['attachments']['visual'] = (null !== $visual && null !== $visual->first()) ? $visual->first()['url'] : '';

        return $this->responseJson($result);
    }
}
