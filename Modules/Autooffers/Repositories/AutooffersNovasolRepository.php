<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Autooffers\Repositories;

use App\Models\Wishes\Wish;
use App\Repositories\BaseRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Modules\Autooffers\Entities\Autooffer;

/**
 * Class EloquentPostsRepository.
 */
class AutooffersNovasolRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Autooffer::class;

    private $key = 'WEvoSrIfHvZtVhlyKIWYfP5WjGcPVB';

    private $novasolapi = 'https://safe.novasol.com/api/';

    protected $region;

    protected $location;

    protected $from;

    protected $to;

    protected $budget;

    protected $minBudget;

    protected $maxBudget;

    protected $adults;

    protected $kids;

    protected $period;

    protected $airport;

    protected $destination;

    protected $category;

    protected $catering;

    protected $giataIds;

    protected $tourOperatorList = '';

    public function model()
    {
        return Autooffer::class;
    }

    public function getNovasolData(array $params = [])
    {
        try {
            $this->novasolapi .= 'available?';
            $lastItem = end($params);

            logger()->info(print_r($params, true));

            foreach ($params as $key => $value) {
                $this->novasolapi .= $key . '=' . $value;

                if ($value !== $lastItem) {
                    $this->novasolapi .= '&';
                }
            }

            $opts = [
                    'http' => [
                        'method' => 'GET',
                        'header' => "Accept-language: en\r\n" .
                        "Key: WEvoSrIfHvZtVhlyKIWYfP5WjGcPVB\r\n" .
                        "Host: novasol.reise-wunsch.com\r\n"
                    ]
                ];

            $context = stream_context_create($opts);

            $this->novasolapi = str_replace(['&amp;'], ['&'], $this->novasolapi);

            logger()->info('novasol-api-url: ' . $this->novasolapi);

            // Open the file using the HTTP headers set above
            return file_get_contents($this->novasolapi, false, $context);
        } catch (RequestException $e) {
            return $e->getResponse();
        }
    }

    /**
     * @param string $hotelId
     *
     * @return bool
     */
    public function getFullHotelData($hotelId)
    {
        $client = new Client();
        $response = $client->get(
            $this->url . '/hotels/' . $hotelId,
            [
                'query' => [
                    'auth' => $this->auth
                ]
            ]
        );

        return json_decode($response->getBody());
    }

    /**
     * @return bool
     */
    public function saveWishData(Wish $wish)
    {
        $this->setMinBudget(0);
        $this->setMaxBudget(0);
        $this->setAdults($wish->adults);
        $this->setAirport('TXL');
        $this->setCategory($wish->category);
        $this->setCatering('XX,AO,BB,HB,HBP,FB,FBP,AI,AIP,AIU,AIR');
        $this->setFrom(\Illuminate\Support\Carbon::createFromFormat('Y-m-d', $wish->earliest_start)->format('dmy'));
        $this->setto(\Illuminate\Support\Carbon::createFromFormat('Y-m-d', $wish->latest_return)->format('dmy'));
        $this->setPeriod($wish->duration);
        $this->setRegion('133');
        $this->setTourOperatorList(['BIG,XBIG,5VF,X5VF,FTI,XFTI,FLYD,ADAC,AIR,AIRM,XAIR,ATID,ALD,ALL,XALL,AME,ANEX,ATK,BAVA,BU,BYE,CBM,COR,DER,XDER,XECC,ECC,FALK,FER,FUV,FIT,FOR,FOX,XBU,GRUB,HHT,TREX,IHOM,ITS,ITS-XITS,ITSX,ITT,JAHN-XJAH,JAHN,JANA,XJAH,JT,XLMX,LMXI,LMX,MLA,HERM,MED,MWR,MON,XNER,NEC,NER,XNEC,OGE,XOGE,OLI,PHX,SLRD,SLR,SNOW,TOC,TOR,AIR,TVR,XTOC,TISC,TJAX,XPOD,TUID,XTUI,VTO,WIN,XALD,XANE,XPUR']);

        return true;
    }

    /**
     * @param  $data
     * @param string $wish_id
     */
    public function storeMany($data, $properties, $wish_id)
    {
        $wish = Wish::find($wish_id);

        foreach ($properties as $key => $autooffer) {
            //$offer = json_decode(json_encode($autooffer), true);
            //$hotel = json_decode(json_encode($wish), true);
            //$hotel = json_decode(json_encode($this->getFullHotelData($offer['hotelOffer']['hotel']['giata']['hotelId'])), true);
            $this->storeAutooffer($autooffer, $wish, $wish_id);
        }

        //dd(['data' => $data, 'properties' => $properties]);
    }

    /**
     * @param object $offer
     * @param object $hotel
     * @param string $wish_id
     *
     * @return mix
     */
    public function storeAutooffer($offer, $wish, $wish_id)
    {
        try {
            $autooffer = self::MODEL;
            $autooffer = new $autooffer();
            $autooffer->code = $offer->propertyid;
            $autooffer->type = null;
            $autooffer->totalPrice = $offer->price;
            $autooffer->personPrice = null;
            $autooffer->from = $offer->arrival;
            $autooffer->to = $offer->departure;
            $autooffer->tourOperator_code = $offer->quality;
            $autooffer->tourOperator_name = null;
            $autooffer->hotel_code = $offer->propertyid;
            $autooffer->hotel_name = $offer->location;
            $autooffer->hotel_location_name = null;
            $autooffer->hotel_location_lng = $offer->wsg84long;
            $autooffer->hotel_location_lat = $offer->wsg84lat;
            $autooffer->hotel_location_region_code = $offer->area;
            $autooffer->hotel_location_region_name = null;
            $autooffer->airport_code = null;
            $autooffer->airport_name = null; //$hotel->airport;
            $autooffer->data = json_encode($offer);
            $autooffer->hotel_data = json_encode($wish);
            $autooffer->wish_id = (int) $wish_id;
            $autooffer->user_id = \Auth::user()->id;
            $autooffer->thumbnail = trim(str_replace('/100/', '/600/', $offer->thumbnail));

            if ($autooffer->save()) {
                logger()->info('autooffer wurde gespeichert!');

                return true;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // something went wrong with the transaction, rollback
            report($e);

            return false;
        } catch (\Exception $e) {
            // something went wrong elsewhere, handle gracefully
            report($e);

            return false;
        }
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getOffersDataFromId($id)
    {
        $offers = $this->query()
            ->select(['*'])
            ->where('wish_id', (int) $id)
            ->get()->toArray();

        $offerObj = [];

        foreach ($offers as $key => $offer) {
            array_push(
                $offerObj,
                [
                    'data'       => json_decode($offer['data'], true),
                    'hotel_data' => json_decode($offer['hotel_data'], true)
                ]
            );
        }

        return $offerObj;
    }

    /**
     * @return int
     */
    private function getPersonsCount()
    {
        $kidsCount = $this->kids ? \count(explode(',', $this->kids)) : 0;

        return (int) ($this->adults) + $kidsCount;
    }

    // Getters & Setters

    /**
     * @param $budget
     */
    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    /**
     * @return $budget
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * @return $minBudget
     */
    public function getMinBudget()
    {
        return $this->minBudget;
    }

    /**
     * @param $budget
     */
    public function setMinBudget($budget)
    {
        $this->minBudget = $budget;
    }

    /**
     * @return $maxBudget
     */
    public function getMaxBudget()
    {
        return $this->maxBudget;
    }

    /**
     * @param $budget
     */
    public function setMaxBudget($budget)
    {
        $this->maxBudget = $budget;
    }

    /**
     * @param $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @param $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @param $adults
     */
    public function setAdults($adults)
    {
        $this->adults = (int) $adults;
    }

    /**
     * @param $kids
     */
    public function setKids($kids)
    {
        $this->kids = (int) $kids;
    }

    /**
     * @param $period
     */
    public function setPeriod($period)
    {
        $this->period = (int) $period;
    }

    /**
     * @param $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @param $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param $catering
     */
    public function setCatering($catering)
    {
        $this->catering = $catering;
    }

    /**
     * @param $airport
     */
    public function setAirport($airport)
    {
        $this->airport = $airport;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getTourOperatorList()
    {
        return $this->tourOperatorList;
    }

    /**
     * @param mixed $tourOperatorList
     */
    public function setTourOperatorList($tourOperatorList)
    {
        $this->tourOperatorList = $tourOperatorList;
    }

    /**
     * @return mixed
     */
    public function getGiataIds()
    {
        return $this->giataIds;
    }

    /**
     * @param mixed $giataIds
     */
    public function setGiataIds($giataIds)
    {
        $this->giataIds = $giataIds;
    }

    public function to_country_code($land)
    {
//        logger()->info("to_country_code() was called with: $land");
//        logger()->info("lang-type: ". gettype($land));

        $code = DB::table('novasol_country')
            ->select('novasol_code')
            ->where('name', '=', $land)
            ->get()->first();

        if (null === $code) {
            $codes = DB::table('novasol_area')
                 ->join('novasol_country', 'novasol_area.novasol_country_id', '=', 'novasol_country.id')
                 ->select(['novasol_code', 'novasol_area.novasol_area_code'])
                 ->where('novasol_area.name', '=', $land)
                 ->get()
                 ->first();

//             $area = DB::table('novasol_area')
//                        ->select('novasol_area_code')
//                        ->where('name', '=', $land)
//                        ->get()
//                        ->first();

            $novasol_code = null;
            $novasol_area_code = null;
            if (null !== $codes) {
                $novasol_code = $codes->novasol_code;
                $novasol_area_code = $codes->novasol_area_code;
            }

            return [$novasol_code, $novasol_area_code];
            //return [$code->novasol_code,$area->novasol_area_code];
        }

        return  [$code->novasol_code, ''];
    }

    public function getProduct($id)
    {
        $url = 'https://safe.novasol.com/api/products/' . $id . '?salesmarket=208&season=2019';

        $opts = [
                'http' => [
                    'method' => 'GET',
                    'header' => "Accept-language: en\r\n" .
                    "Key: WEvoSrIfHvZtVhlyKIWYfP5WjGcPVB\r\n" .
                    "Host: novasol.reise-wunsch.com\r\n"
                ]
            ];

        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        return $file = file_get_contents($url, false, $context);
    }
}
