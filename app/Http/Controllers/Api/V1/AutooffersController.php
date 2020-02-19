<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Contracts\AutooffersControllerInterface;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Modules\Autooffers\Repositories\AutooffersRepository;
use Modules\Autooffers\Repositories\AutooffersTTRepository;
use Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository;
use App\Models\KeywordList;

class AutooffersController extends APIController implements AutooffersControllerInterface
{
    private $repository;
    private $TTrepository;
    private $rules;
    private $keywordList;

    public function __construct(WishesRepository $wish, AutooffersRepository $repository, AutooffersTTRepository $TTrepository, EloquentAutooffersRepository $rules, KeywordList $keywordList)
    {
        $this->wish = $wish;
        $this->repository = $repository;
        $this->TTrepository = $TTrepository;
        $this->rules = $rules;
        $this->keywordList = $keywordList;
    }

    public function list(int $wishId)
    {
        try {
            $offers['data'] = $this->repository->getOffersDataFromId($wishId);

            foreach ($offers['data'] as &$offer) {

                $offer['data']['hotelOffer']['hotel']['keywordHighlights'] = array();

                for ($i = 0; $i < 3; $i++) {
                    $keyword = $offer['data']['hotelOffer']['hotel']['keywordList'][$i];
                    $keywordCode = $this->keywordList::where('code', $keyword)->first();
                    $keywordName = $keywordCode ? $keywordCode->name : '';

                    $offer['data']['hotelOffer']['hotel']['keywordHighlights'][$i] = $keywordName;
                }
            }

            return $this->responseJson($offers);
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function listTt(int $wishId)
    {
        try {
            $offers['data'] = $this->repository->getOffersDataFromId($wishId);

            foreach ($offers as $offer) {

                for ($i = 0; $i < 3; $i++) {
                    $keywordCode = $offer['data']['hotelOffer']['hotel']['keywordList'][$i];
                    $keyword = $this->keywordList::where('code', $keywordCode)->first();
                    $keywordName = $keywords ? $keywords->name : '';

                    $offer['data']['hotelOffer']['hotel']['keywordHighlights'][$i] = $keywordName;
                }
            }

            return $this->responseJson($offers);
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }

    public function getKeywords($offers)
    {
        try {
            for ($i = 0; $i < 3; $i++) {
                $offer['data']['hotelOffer']['hotel']['keywordList'][$i];
            }

            $keywords = $this->keywordList::where('code', $value)->first();
            dd($keywords);

            return $this->responseJson($offers);
        } catch (Exception $e) {
            return $this->respondWithError($e);
        }
    }
}
