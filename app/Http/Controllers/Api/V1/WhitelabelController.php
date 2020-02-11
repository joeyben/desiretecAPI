<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Where;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository as ModuleWhitelabelsRepository;
use App\Repositories\Frontend\Whitelabels\WhitelabelsRepository;


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
            new EagerLoad(['layers']),
            new Where('name', $slug),
        ])->first();

        $result['data'] = $whitelabel;

        $background = $this->moduleWhitelabelsRepository->getBackgroundImage($whitelabel);

        $logo = $this->moduleWhitelabelsRepository->getLogo($whitelabel);

        $favicon = $this->moduleWhitelabelsRepository->getFavicon($whitelabel);

        $visual = $this->moduleWhitelabelsRepository->getVisual($whitelabel);

        $result['data']['attachments']['background'] = (null !== $background && null !== $background->first()) ? $background->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/background/1581433096bg.jpg';
        $result['data']['attachments']['logo'] = (null !== $logo && null !== $logo->first()) ? $logo->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/logo/1581433101snapchat_PNG65.png';
        $result['data']['attachments']['favicon'] = (null !== $favicon && null !== $favicon->first()) ? $favicon->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/logo/1581433101snapchat_PNG65.png';
        $result['data']['attachments']['visual'] = (null !== $visual && null !== $visual->first()) ? $visual->first()['url'] : '';
        $result['data']['layers'] = $whitelabel->layers;

        return $this->responseJson($result);
    }
}
