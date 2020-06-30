<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\Like;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Frontend\Whitelabels\WhitelabelsRepository;
use Illuminate\Http\Request;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;
use Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository;
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
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository
     */
    private $layerWhitelabels;
    /**
     * @var \Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository
     */
    private $languageline;

    public function __construct(WhitelabelsRepository $whitelabels, ModuleWhitelabelsRepository $moduleWhitelabelsRepository, LayerWhitelabelRepository $layerWhitelabels, LanguageLinesRepository $languageline)
    {
        $this->whitelabels = $whitelabels;
        $this->moduleWhitelabelsRepository = $moduleWhitelabelsRepository;
        $this->layerWhitelabels = $layerWhitelabels;
        $this->languageline = $languageline;
    }

    public function getWhitelabelBySlug(string $slug)
    {
        $whitelabel = $this->moduleWhitelabelsRepository->withCriteria([
            new EagerLoad(['footers']),
            new Like('domain', '//' . $slug . '.'),
        ])->first();

        $background = $this->moduleWhitelabelsRepository->getBackgroundImage($whitelabel);

        $logo = $this->moduleWhitelabelsRepository->getLogo($whitelabel);

        $favicon = $this->moduleWhitelabelsRepository->getFavicon($whitelabel);

        $visual = $this->moduleWhitelabelsRepository->getVisual($whitelabel);

        $tourOperators = $this->moduleWhitelabelsRepository->getTourOperators($whitelabel->id);

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
            'traffics'            => $whitelabel->traffics,
            'tt'                  => $whitelabel->tt,
            'layers'              => $this->getLayers($whitelabel->id),
            'footers'             => $whitelabel->footers,
            'tourOperators'       => $tourOperators,
            'is_pure_autooffers'  => $this->whitelabels->getRuleType($whitelabel->id) === 1 ? true : false
        ];

        $result['data']['attachments']['background'] = (null !== $background && null !== $background->first()) ? $background->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/background/default_background.jpg';
        $result['data']['attachments']['logo'] = (null !== $logo && null !== $logo->first()) ? $logo->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/logo/default_logo.png';
        $result['data']['attachments']['favicon'] = (null !== $favicon && null !== $favicon->first()) ? $favicon->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/favicon/default_favicon.png';
        $result['data']['attachments']['visual'] = (null !== $visual && null !== $visual->first()) ? $visual->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/visual/default_layer_package.png';

        return $this->responseJson($result);
    }

    /**
     * show page by $page_slug.
     */
    public function getWhitelabelByHost(string $host)
    {
        $id = $this->moduleWhitelabelsRepository->getWhitelabelNameByHost($host);

        $whitelabel = $this->moduleWhitelabelsRepository->withCriteria([
            new EagerLoad(['footers']),
            new Where('id', $id),
        ])->first();

        $background = $this->moduleWhitelabelsRepository->getBackgroundImage($whitelabel);

        $logo = $this->moduleWhitelabelsRepository->getLogo($whitelabel);

        $favicon = $this->moduleWhitelabelsRepository->getFavicon($whitelabel);

        $visual = $this->moduleWhitelabelsRepository->getVisual($whitelabel);

        $tourOperators = $this->moduleWhitelabelsRepository->getTourOperators($whitelabel->id);

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
            'traffics'            => $whitelabel->traffics,
            'tt'                  => $whitelabel->tt,
            'licence'             => $whitelabel->licence,
            'layers'              => $this->getLayers($whitelabel->id),
            'footers'             => $whitelabel->footers,
            'tourOperators'       => $tourOperators,
            'is_pure_autooffers'  => $this->whitelabels->getRuleType($whitelabel->id) === 1 ? true : false

        ];

        $result['data']['attachments']['background'] = (null !== $background && null !== $background->first()) ? $background->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/background/default_background.jpg';
        $result['data']['attachments']['logo'] = (null !== $logo && null !== $logo->first()) ? $logo->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/logo/default_logo.png';
        $result['data']['attachments']['favicon'] = (null !== $favicon && null !== $favicon->first()) ? $favicon->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/favicon/default_favicon.png';
        $result['data']['attachments']['visual'] = (null !== $visual && null !== $visual->first()) ? $visual->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/visual/default_layer_package.png';

        return $this->responseJson($result);
    }

    public function getTnb(Request $request)
    {
        try {
            $tnb = $this->languageline->withCriteria([
                    new Where('locale', 'de'),
                    new Where('key', 'footer.tnb'),
                    new Where('group', 'layer_tnb'),
                    new Where('whitelabel_id', $request->id),
                ])->get()->first();

            if (null === $tnb) {
                throw new \ErrorException(trans('errors.tnb.notset'));
            }

            $result['data'] = $tnb->text;

            return $this->responseJson($result);
        } catch (\Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    private function getLayers(int $id)
    {
        $layers = $this->layerWhitelabels->withCriteria([
            new OrderBy('layer_id'),
            new Where('whitelabel_id', $id),
            new EagerLoad(['layer', 'attachments', 'variants'  => function ($query) {
                $query->where('variants.active', 1)->with('attachments');
            }])
        ])->all();
        return  $layers->map(function ($layer) {
            return [
                'id' => $layer->id,
                'whitelabel_id' => $layer->whitelabel_id,
                'layer_id' => $layer->layer_id,
                'domain' => $layer->domain,
                'logo' => $this->getImage($layer, 'logo'),
                'visual' => $this->getImage($layer, 'visual'),
                'image' => $this->getImage($layer),
                'image' => $this->getImage($layer),
                'headline' => $this->getVariant($layer, 'headline'),
                'subheadline' => $this->getVariant($layer, 'subheadline'),
                'headline_color' => $this->getVariant($layer, 'color'),
                'headline_success' => $this->getVariant($layer, 'headline_success'),
                'subheadline_success' => $this->getVariant($layer, 'subheadline_success'),
                'layer_url' => $layer->layer_url,
                'privacy' => $layer->privacy,
                'layer' => $layer->layer
            ];
        });
    }

    private function getVariant($layer, string $column)
    {
        $variant = $layer->variants->first();

        if ($variant && $column !== 'color') {
            return $variant->getTranslation($column, session()->get('wl-locale', 'de'), true);
        } else if ($variant && $column === 'color') {
            return $variant->{$column};
        } else {
            return $layer->{$column};
        }

    }

    private function getImage($layer, $type = 'logo')
    {
        $variant = $layer->variants->first();

        if ($variant) {
            $attachments = $variant->attachments->map(function ($attachment) {
                return [
                    'url' => $attachment->url,
                    'type' => $attachment->type
                ];
            });

            foreach ($attachments as    $attachment) {
                if ($attachment['type'] === 'variants/' . $type) {
                    return $attachment['url'];
                }
            }

            return $layer->image;
        } else {
            $layer->image;
        }
    }
}
