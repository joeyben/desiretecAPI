<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Settings\Setting;
use App\Repositories\Frontend\Pages\PagesRepository;
use App\Repositories\Frontend\Whitelabels\WhitelabelsRepository;
use Illuminate\Http\Request;

/**
 * Class WhitelabelController.
 */
class WhitelabelController extends Controller
{
    private $whitelabels;


    public function __construct(WhitelabelsRepository $whitelabels)
    {
        $this->whitelabels = $whitelabels;
    }


    /**
     * show page by $page_slug.
     */
    public function getWhitelabelBySlug(string $slug)
    {
        $response['data'] = $this->whitelabels->getWhitelabelByName($slug);
        return $this->responseJson($response);
    }
}
