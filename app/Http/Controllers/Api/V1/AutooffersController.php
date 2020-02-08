<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Contracts\AutooffersControllerInterface;
use App\Models\Wishes\Wish;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Modules\Autooffers\Repositories\AutooffersRepository;
use Modules\Autooffers\Repositories\AutooffersTTRepository;
use Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository;

class AutooffersController extends APIController implements AutooffersControllerInterface
{
    private $autooffers;
    private $TTautooffers;
    private $rules;

    public function __construct(WishesRepository $wish, AutooffersRepository $autooffers, AutooffersTTRepository $TTautooffers, EloquentAutooffersRepository $rules)
    {
        $this->wish = $wish;
        $this->autooffers = $autooffers;
        $this->TTautooffers = $TTautooffers;
        $this->rules = $rules;
    }

    public function list(int $wishId)
    {
        try {
            $offers['data'] = $this->autooffers->getOffersDataFromId($wishId);

            return $this->responseJson($offers);

        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function listTt(int $wishId)
    {
        try {
            $offers['data'] = $this->autooffers->getOffersDataFromId($wishId);

            return $this->responseJson($offers);

        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
