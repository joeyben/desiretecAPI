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

    /**
     * show page by $page_slug.
     */
    public function getWhitelabelBySlug(string $slug)
    {
        $whitelabel = $this->moduleWhitelabelsRepository->withCriteria([
            new EagerLoad(['layers', 'footers']),
            new Where('name', $slug),
        ])->first();

        $background = $this->moduleWhitelabelsRepository->getBackgroundImage($whitelabel);

        $logo = $this->moduleWhitelabelsRepository->getLogo($whitelabel);

        $favicon = $this->moduleWhitelabelsRepository->getFavicon($whitelabel);

        $visual = $this->moduleWhitelabelsRepository->getVisual($whitelabel);

        $result['data'] = [
            'id'                  => $whitelabel->id,
            'name'                => $whitelabel->name,
            'display_name'        => $whitelabel->display_name,
            'domain'              => $whitelabel->domain,
            'ga_view_id'          => $whitelabel->ga_view_id,
            'distribution_id'     => $whitelabel->distribution_id,
            'subheadline_success' => $whitelabel->subheadline_success,
            'headline_success'    => $whitelabel->headline_success,
            'subheadline'         => $whitelabel->subheadline,
            'headline'            => $whitelabel->headline,
            'color'               => $whitelabel->color,
            'is_autooffer'        => $whitelabel->is_autooffer,
            'licence'             => $whitelabel->licence,
            'layers'              => $whitelabel->layers,
            'footers'              => $whitelabel->footers,
        ];

        $result['data']['attachments']['background'] = (null !== $background && null !== $background->first()) ? $background->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/background/default_background.jpg';
        $result['data']['attachments']['logo'] = (null !== $logo && null !== $logo->first()) ? $logo->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/logo/default_logo.png';
        $result['data']['attachments']['favicon'] = (null !== $favicon && null !== $favicon->first()) ? $favicon->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/favicon/default_favicon.png';
        $result['data']['attachments']['visual'] = (null !== $visual && null !== $visual->first()) ? $visual->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/visual/default_layer_package.png';

        return $this->responseJson($result);
    }
}
