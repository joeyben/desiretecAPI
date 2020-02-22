<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Criteria\EagerLoad;
use App\Repositories\Criteria\OrderBy;
use App\Repositories\Criteria\Where;
use App\Repositories\Frontend\Whitelabels\WhitelabelsRepository;
use Illuminate\Support\Facades\DB;
use Modules\Whitelabels\Repositories\Contracts\LayerWhitelabelRepository;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository as ModuleWhitelabelsRepository;
use Illuminate\Http\Request;
use Modules\LanguageLines\Repositories\Contracts\LanguageLinesRepository;
use Illuminate\Validation\ValidationException;

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

    /**
     * show page by $page_slug.
     */
    public function getWhitelabelBySlug(string $slug)
    {
        $whitelabel = $this->moduleWhitelabelsRepository->withCriteria([
            new EagerLoad(['footers']),
            new Where('name', $slug),
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
            'layers'              => $this->getLayers($whitelabel->id),
            'footers'             => $whitelabel->footers,
            'tourOperators'       => $tourOperators,
        ];

        $result['data']['attachments']['background'] = (null !== $background && null !== $background->first()) ? $background->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/background/default_background.jpg';
        $result['data']['attachments']['logo'] = (null !== $logo && null !== $logo->first()) ? $logo->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/logo/default_logo.png';
        $result['data']['attachments']['favicon'] = (null !== $favicon && null !== $favicon->first()) ? $favicon->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/favicon/default_favicon.png';
        $result['data']['attachments']['visual'] = (null !== $visual && null !== $visual->first()) ? $visual->first()['url'] : 'https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/visual/default_layer_package.png';

        return $this->responseJson($result);
    }

    public function getTnb(Request $request){
        try {
            if (!$this->isOldWhitelabel()) {
                if($this->languageline->withCriteria([
                        new Where('locale', 'de'),
                        new Where('key', 'footer.tnb'),
                        new Where('group', 'layer'),
                        new Where('whitelabel_id', $request->id),
                    ])->get()->first() === null){
                    throw new \ErrorException('Teilnahmebedingungen is not set');
                } else {
                    $result['data'] = $this->languageline->withCriteria([
                        new Where('locale', 'de'),
                        new Where('key', 'footer.tnb'),
                        new Where('group', 'layer'),
                        new Where('whitelabel_id', $request->id),
                    ])->get()->first()->text;

                    return $this->responseJson($result);
                }
            } else {
                $wlName = $this->moduleWhitelabelsRepository->withCriteria([
                    new Where('id', $request->id),
                ])->first()->name;
                if(DB::table("language_lines_{$wlName}")
                        ->select('text')
                        ->where('locale', 'de')
                        ->where('group', 'layer')
                        ->where('key', 'footer.tnb')
                        ->get()->first() === null){
                    throw new \ErrorException('Teilnahmebedingungen is not set');
                } else {
                    $result['data'] = DB::table("language_lines_{$wlName}")
                        ->select('text')
                        ->where('locale', 'de')
                        ->where('group', 'layer')
                        ->where('key', 'footer.tnb')
                        ->get()->first()->text;

                    return $this->responseJson($result);
                }
            }
        } catch (\Exception $e) {
            return $this->responseJsonError($e);
        }
    }

    private function getLayers(int $id)
    {
        return $this->layerWhitelabels->withCriteria([
            new OrderBy('layer_id'),
            new Where('whitelabel_id', $id),
            new EagerLoad(['layer', 'attachments'])
        ])->all();
    }
}
