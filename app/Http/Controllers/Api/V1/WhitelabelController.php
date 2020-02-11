<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Whitelabels\WhitelabelsRepository;

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
