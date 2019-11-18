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
use GuzzleHttp\TransferStats;
use Modules\Autooffers\Entities\Autooffer;
use Underscore\Parse;

/**
 * Class EloquentPostsRepository.
 */
class AutooffersRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Autooffer::class;

    private $auth = 'ZGVzaXJldGVjLmNvbm5lY3RvcnByb2Q6eXJFZ0ZDQzA=';

    private $url = 'https://connector.traffics.de/v3/rest';

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

    public function getTrafficsData()
    {
        $client = new Client();
        try {
            $response = $client->get(
                $this->url . '/offers/pauschal',
                [
                    'query' => [
                        'auth'                 => $this->auth,
                        'sortBy'               => 'price',
                        'productSubType'       => 'all',
                        'searchDate'           => $this->from . ',' . $this->to . ',' . $this->period, // 10112018,12122018,14
                        'adults'               => $this->adults,
                        'children'             => $this->kids,
                        'navigation'           => '1,100',
                        'departureAirportList' => $this->airport,
                        'regionList'           => $this->region,
                        //'locationList' => $this->location,
                        //'minPricePerPerson' => (int) ($this->minBudget / $this->getPersonsCount()),
                        'maxPricePerPerson' => (int) ($this->maxBudget / $this->getPersonsCount()),
                        'minCategory'       => $this->category,
                        //'minBoardType' => $this->catering,
                        'rating[source]'   => 'holidaycheck',
                        'sortDir'          => 'up',
                        'tourOperatorList' => $this->tourOperatorList,
                    ],
                    'on_stats' => function (TransferStats $stats) use (&$url) {
                        $url = $stats->getEffectiveUri();
                    }
                ]
            );
        } catch (RequestException $e) {
            return $e->getResponse();
        }
        /*echo "<pre>";
        var_dump($url);
        var_dump($response->getBody()->getContents());
        echo "</pre>";
        die();*/

        return json_decode($response->getBody());
    }

    /**
     * @param string $hotelId
     *
     * @return bool
     */
    public function getFullHotelData($hotelId, $tOperator)
    {
        /*$client = new Client();
        $response = $client->get(
            $this->url . '/hotels/' . $hotelId,
            [
                'query' => [
                    'auth' => $this->auth
                ]
            ]
        );*/
        $username = "203339";
        $password = "605e5129";
        $remote_url = 'https://xml.giatamedia.com/?show=text,geo,pic800,hn,vn,ln,lk,katid,kn,hk,sn,sn,zi,ln,lc&sc=hotel&vc='.$tOperator.'&gid='.$hotelId;

        $opts = array('http'=>array('method'=>"GET",
            'header' => "Authorization: Basic ". base64_encode("$username:$password")));

        $context = stream_context_create($opts);
        $file = file_get_contents($remote_url, false, $context);
        $xml = simplexml_load_string($file, 'SimpleXMLElement', LIBXML_NOCDATA);
        return json_decode(json_encode($xml), true);
    }

    /**
     * @param \App\Models\Wishes\Wish $wish
     *
     * @return bool
     */
    public function saveWishData(Wish $wish)
    {
        $this->setMinBudget(0);
        $this->setMaxBudget($wish->budget);
        $this->setAdults($wish->adults);
        $this->setAirport(getRegionCode($wish->airport, 0));
        $this->setCategory($wish->category);
        $this->setCatering('XX,AO,BB,HB,HBP,FB,FBP,AI,AIP,AIU,AIR');
        $this->setFrom(\Illuminate\Support\Carbon::createFromFormat('Y-m-d', $wish->earliest_start)->format('dmy'));
        $this->setto(\Illuminate\Support\Carbon::createFromFormat('Y-m-d', $wish->latest_return)->format('dmy'));
        $this->setPeriod($wish->duration);
        $this->setRegion(getRegionCode($wish->destination, 1));
        $this->setTourOperatorList(['BIG,XBIG,5VF,X5VF,FTI,XFTI,FLYD,ADAC,AIR,AIRM,XAIR,ATID,ALD,ALL,XALL,AME,ANEX,ATK,BAVA,BU,BYE,CBM,COR,DER,XDER,XECC,ECC,FALK,FER,FUV,FIT,FOR,FOX,XBU,GRUB,HHT,TREX,IHOM,ITS,ITS-XITS,ITSX,ITT,JAHN-XJAH,JAHN,JANA,XJAH,JT,XLMX,LMXI,LMX,MLA,HERM,MED,MWR,MON,XNER,NEC,NER,XNEC,OGE,XOGE,OLI,PHX,SLRD,SLR,SNOW,TOC,TOR,AIR,TVR,XTOC,TISC,TJAX,XPOD,TUID,XTUI,VTO,WIN,XALD,XANE,XPUR']);

        return true;
    }



    /**
     * @param  $data
     * @param string $wish_id
     * @param array $rules
     */
    public function storeMany($data, $wish_id, $rules)
    {
        $rulesArray = [
            'displayOffer' => is_array($rules) ? $rules['display_offer'] : 3,
            'recommendation' => is_array($rules) ? $rules['recommendation'] : 80,
            'rating' => is_array($rules) ? $rules['rating'] : 8
        ];


        $count = 0;
        foreach ($data->offerList as $key => $autooffer) {
            if ($count >= $rulesArray['displayOffer']) {
                break;
            }
            $offer = json_decode(json_encode($autooffer), true);
            if (!$this->checkValidity($offer, $wish_id, $rulesArray)) {
                continue;
            }
            $hotelId = $offer['hotelOffer']['hotel']['giata']['hotelId'];
            $tOperator = $offer['tourOperator']['code'];
            $hotel = json_decode(json_encode($this->getFullHotelData($hotelId, $tOperator)), true);
            $this->storeAutooffer($offer, $hotel, $wish_id);
            $count++;
        }
    }

    /**
     * @param  $data
     * @param string $wish_id
     * @param array $rulesArray
     *
     * @return boolean
     */
    public function checkValidity($data, $wish_id, $rulesArray)
    {
        $autooffer = Autooffer::where('wish_id',$wish_id)->where('hotel_code', $data['hotelOffer']['hotel']['giata']['hotelId'])->count();
        $rating = intval($data['hotelOffer']['hotel']['rating']['overall']);
        $recommendation = intval($data['hotelOffer']['hotel']['rating']['recommendation']);
        $rules_ratings = (intval(str_replace('.', '', $rulesArray['rating']))/ 10);
        //dd($rating > $rules_ratings);
        return $rating > $rules_ratings && $autooffer === 0 && $recommendation > $rulesArray['recommendation'];
    }

    /**
     * @param object $offer
     * @param object $hotel
     * @param string $wish_id
     *
     * @return mix
     */
    public function storeAutooffer($offer, $hotel, $wish_id)
    {
        try {
            $autooffer = self::MODEL;
            $autooffer = new $autooffer();
            $autooffer->code = $offer['code'];
            $autooffer->type = $offer['productType'];
            $autooffer->totalPrice = $offer['totalPrice']['value'];
            $autooffer->personPrice = $offer['personPrice']['value'];
            $autooffer->from = $offer['travelDate']['fromDate'];
            $autooffer->to = $offer['travelDate']['toDate'];
            $autooffer->tourOperator_code = $offer['tourOperator']['code'];
            $autooffer->tourOperator_name = $offer['tourOperator']['name'];
            $autooffer->hotel_code = $offer['hotelOffer']['hotel']['giata']['hotelId'];
            $autooffer->hotel_name = $offer['hotelOffer']['hotel']['name'];
            $autooffer->hotel_location_name =  $offer['hotelOffer']['hotel']['location']['name'];
            $autooffer->hotel_location_lng =  0;
            $autooffer->hotel_location_lat =  0;
            $autooffer->hotel_location_region_code =  $offer['hotelOffer']['hotel']['location']['region']['code'];
            $autooffer->hotel_location_region_name =  $offer['hotelOffer']['hotel']['location']['region']['name'];
            $autooffer->airport_code =  $offer['hotelOffer']['hotel']['airport']['code'];
            $autooffer->airport_name =  $offer['hotelOffer']['hotel']['airport']['name'];
            $autooffer->data = json_encode($offer);
            $autooffer->hotel_data = json_encode($hotel);
            $autooffer->wish_id = (int) $wish_id;
            $autooffer->user_id = \Auth::user()->id;
            return $autooffer->save();
        } catch (\Illuminate\Database\QueryException $e) {
            // something went wrong with the transaction, rollback
            report($e);
            dd($e);
            return false;
        } catch (\Exception $e) {
            // something went wrong elsewhere, handle gracefully
            report($e);
            dd($e);
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
            array_push($offerObj,
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

        return intval($this->adults) + $kidsCount;
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
        $this->adults = intval($adults);
    }

    /**
     * @param $kids
     */
    public function setKids($kids)
    {
        $this->kids = intval($kids);
    }

    /**
     * @param $period
     */
    public function setPeriod($period)
    {
        $this->period = intval($period);
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
}
