<?php

/**
 * Created by PhpStorm.
 * User: goldoni
 * Date: 24.09.18
 * Time: 21:18.
 */

namespace Modules\Autooffers\Repositories;

use App\Models\BestfewoRange;
use App\Models\Wishes\Wish;
use App\Repositories\BaseRepository;
use Modules\Autooffers\Entities\Autooffer;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class AutooffersBFRepository.
 */
class AutooffersBFRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Autooffer::class;

    private $token = '';

    private $username = 'sys_315150_ch_desiretec';

    private $password = '20Destec20#';

    private $oauthUrl = 'https://auth.ws.traveltainment.eu:443/auth/realms/SystemUser-BasicAccessLevel/protocol/openid-connect/token';

    private $url = 'http://de-ibe.ws.traveltainment.eu/ttgateway-web-v1_1/rest/PackageSearch/packageOffers';

    private $currency = 'CHF';

    private $specialSearch = false;

    protected $region;

    protected $country;

    protected $city;

    protected $location;

    protected $from;

    protected $to;

    protected $budget;

    protected $minBudget;

    protected $maxBudget;

    protected $adults;

    protected $kids;

    protected $period;

    protected $minDuration;

    protected $maxDuration;

    protected $airport;

    protected $destination;

    protected $category;

    protected $catering;

    protected $giataIds;

    protected $reviews;

    protected $hotelAttributes;

    protected $geos;

    protected $data;

    protected $offers;

    protected $tourOperatorList = '';

    public function model()
    {
        return Autooffer::class;
    }


    public function getRequest()
    {
        //dd(utf8_decode($this->getCountry()));
        DB::disableQueryLog();
        $query = BestfewoRange::where('max_adults', '>=', $this->getAdults())
            ->where('max_children', '>=', $this->getKids())
            ->where('from', '<=', Carbon::parse($this->getFrom()))
            ->where('to', '>=', Carbon::parse($this->getTo()));

        if($this->getCity())
            $query->where('city', $this->getCity());
        elseif($this->getCountry())
            $query->where('country', $this->getCountry());
        elseif($this->getRegion())
            $query->where('region', utf8_decode($this->getRegion()));
        //$sql = str_replace_array('?', $query->getBindings(), $query->toSql());

        $objects = $query->limit(10)->get()->toArray();

        dd($objects);

        return $objects;
    }

    public function testRequest()
    {
        //$resutls = Bestfewo::where('type','Ferienwohnung')->limit(3)->get()->toArray();

    }


    /**
     * @param  $data
     * @param string $wish_id
     * @param array  $rules
     */
    public function storeMany($offers, $wish_id, $rules, $userId)
    {
        $count = 0;
        foreach ($offers as $key => $offer) {


            $this->storeAutooffer($offer, $wish_id, $userId);
            ++$count;
            if ($count >= 10) {
                break;
            }
        }
    }


    /**
     * @return bool
     */
    public function saveWishData(Wish $wish, $whitelabelId)
    {

        $this->setBudget($wish->budget);
        $this->setAdults($wish->adults);
        $this->setKids($wish->kids);
        $this->setAirport($wish->airport);
        $this->setCategory($wish->category);
        $this->setCatering($wish->catering);
        $this->setFrom($wish->earliest_start);
        $this->setto($wish->latest_return);
        $this->setPeriod($wish->duration);
        $this->setCity($wish->destination);
        $this->setRegion($wish->destination);
        $this->setCountry($wish->destination);
        return true;
    }

    /**
     * @param  $data
     * @param string $wish_id
     * @param array  $rulesArray
     *
     * @return bool
     */
    public function checkValidity($hotelId, $wish_id)
    {
        $autooffer = Autooffer::where('wish_id', $wish_id)->where('hotel_code', $hotelId)->count();

        return 0 === $autooffer;
    }

    /**
     * @param object $offer
     * @param object $hotel
     * @param string $wish_id
     *
     * @return mix
     */
    public function storeAutooffer($offer, $wish_id, $userId)
    {
        $data = json_decode(stripslashes($offer['data']));
        try {
            $DepartureDate = new \DateTime();
            $ArrivalDate = new \DateTime();
            $autooffer = self::MODEL;
            $autooffer = new $autooffer();
            $autooffer->code = $offer['obj_id'];
            $autooffer->type = $offer['type'];
            $autooffer->totalPrice = $offer['obj_id'];
            $autooffer->personPrice = "";
            $autooffer->from = $DepartureDate->format('Y-m-d');
            $autooffer->to = $ArrivalDate->format('Y-m-d');
            $autooffer->tourOperator_code = '';
            $autooffer->tourOperator_name = '';
            $autooffer->hotel_code = '';
            $autooffer->hotel_name = $data->title->text;
            $autooffer->hotel_location_name = $offer['region'].', '.$offer['city'].', '.$offer['country'];
            $autooffer->hotel_location_lng = $offer['longitude'];
            $autooffer->hotel_location_lat = $offer['latitude'];
            $autooffer->hotel_location_region_code = '';
            $autooffer->hotel_location_region_name = '';
            $autooffer->airport_code = '';
            $autooffer->airport_name = '';
            $autooffer->data = $offer['data'];
            $autooffer->hotel_data = '';
            $autooffer->wish_id = (int) $wish_id;
            $autooffer->user_id = $userId;
            $autooffer->status = $this->specialSearch ? 0 : 1;

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
    public function deserializeData($offer)
    {
        $DepartureDate = new \DateTime($offer->Offers->Offer->Departure->DepartureDateTime);
        $ArrivalDate = new \DateTime($offer->Offers->Offer->Return->DepartureDateTime);
        $dataOffer = $offer->Offers->Offer;
        $data = [
            'from'         => $DepartureDate->format('Y-m-d'),
            'to'           => $ArrivalDate->format('Y-m-d'),
            'duration'     => $dataOffer->LengthOfStay,
            'tourOperator' => [
                'code'  => $dataOffer->TourOperator->Code,
                'name'  => $dataOffer->TourOperator->_,
                'image' => ""
            ],
            'price' => [
                'value'    => $dataOffer->Price->Amount,
                'currency' => $this->data->Currency
            ],
            'offerFeatures'    =>  '',
            'hotel_id'         => $offer->References->GiataCode,
            'hotel_ratings'    => [
                'percentage' => property_exists($offer, 'Ratings') ? $offer->Ratings->Rating[1]->Value : 0,
                'count'      => property_exists($offer, 'Ratings') ? $offer->Ratings->Rating[0]->Value : 0,
            ],
            'hotel_attributes' => "",
            'hotel_geo'        => [
                'longitude' => $offer->Location->GeoCode->Longitude,
                'latitude'  => $offer->Location->GeoCode->Latitude
            ],
            'boardType'        => $dataOffer->Board->_,
            'room'             => $dataOffer->Room->_,
            'flight'           => [
                'in' => [
                    'departure' => [
                        'airport' => $dataOffer->Departure->DepartureAirport->_,
                        'date'    => $dataOffer->Departure->DepartureDateTime,
                        'time'    => $dataOffer->Departure->DepartureDateTime,
                    ],
                    'arrival' => [
                        'airport' => $dataOffer->Departure->ArrivalAirport->_,
                        'date'    => $dataOffer->Departure->ArrivalDateTime,
                        'time'    => $dataOffer->Departure->ArrivalDateTime,
                    ],
                    'duration' => $dataOffer->Departure->Duration,
                    'stops'    => $dataOffer->Departure->StopOver,
                    'class'    => property_exists($dataOffer->Departure, 'Class') ? $dataOffer->Departure->Class : "",
                ],
                'out' => [
                    'departure' => [
                        'airport' => $dataOffer->Return->DepartureAirport->_,
                        'date'    => $dataOffer->Return->DepartureDateTime,
                        'time'    => $dataOffer->Return->DepartureDateTime,
                    ],
                    'arrival' => [
                        'airport' => $dataOffer->Return->ArrivalAirport->_,
                        'date'    => $dataOffer->Return->ArrivalDateTime,
                        'time'    => $dataOffer->Return->ArrivalDateTime,
                    ],
                    'duration' => $dataOffer->Return->Duration,
                    'stops'    => $dataOffer->Return->StopOver,
                    'class'    => property_exists($dataOffer->Return, 'Class') ? $dataOffer->Return->Class : "",
                ],
            ],
        ];

        return $data;
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
        $this->budget = $budget && $budget > 0 ? $budget : 10000;
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
        $this->maxBudget = $budget * $this->getPersonsCount();
    }

    /**
     * @param $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     *
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @param $to
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param $adults
     */
    public function getAdults()
    {
        return $this->adults;
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
    public function getKids()
    {
        return $this->kids;
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

    public function getPeriod(){
        return $this->period;
    }
    /**
     * @return mixed
     */
    public function getMinDuration()
    {
        return $this->minDuration;
    }

    /**
     * @param mixed $minDuration
     */
    public function setMinDuration($minDuration): void
    {
        $this->minDuration = $minDuration;
    }

    /**
     * @return mixed
     */
    public function getMaxDuration()
    {
        return $this->maxDuration;
    }

    /**
     * @param mixed $minDuration
     */
    public function setMaxDuration($maxDuration): void
    {
        $this->maxDuration = $maxDuration;
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
        if ($category < 3) {
            $category = 3;
        }
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
        $noboard = "AO";
        $breakfast = "BB";
        $halfboard = "HB, HBP";
        $fullboard = "FB, FBP";
        $allin = "AI, AIP, AIU, AIR";

        switch ($catering) {
            case 1:
                $this->catering = $noboard;
                break;
            case 2:
                $this->catering = $breakfast ;
                break;
            case 3:
                $this->catering = $halfboard ;
                break;
            case 4:
                $this->catering = $fullboard ;
                break;
            case 5:
                $this->catering = $allin ;
                break;
            default:
                $this->catering = '';
                break;
        }
    }

    /**
     * @return $catering
     */
    public function getCatering()
    {
        return $this->catering;
    }
    /**
     * @return mixed
     */
    public function getAirport()
    {
        return $this->airport;
    }

    /**
     * @param $airport
     * @param $whitelabelId
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
    public function setRegion($regions)
    {
        $region = "";
        if (strpos($regions, '(Region)') !== false){
            $region = explode('-', $regions)[1];
            $region = trim(str_replace('(Region)', '', $region));

        }
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $region
     */
    public function setCountry($countries)
    {
        $country = "";
        if(strpos($countries, '(Land)') !== false){
            $country = trim(str_replace('(Land)', '', $countries));
        }
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($cities): void
    {
        $city = "";
        if (strpos($cities, '(Region)') === false && strpos($cities, '(Land)') === false){
            $city = trim(explode('-', $cities)[1]);
        }
        $this->city = $city;
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
    public function setGiataIds()
    {
        $giata = [];
        if (!\array_key_exists('HotelDictionary', $this->data)) {
            $this->giataIds = [];

            return false;
        }
        if (!\array_key_exists('Hotel', $this->data['HotelDictionary'])) {
            $this->giataIds = [];

            return false;
        }

        foreach ($this->data['HotelDictionary']['Hotel'] as $hotel) {
            $giata[$hotel['HotelCodes']['HotelIffCode']] = $hotel['HotelCodes']['HotelGiataID'];
        }
        $this->giataIds = $giata;
    }

    /**
     * @param mixed $giataIds
     */
    public function setReviews()
    {
        $reviews = [];
        if (!\array_key_exists('HotelDictionary', $this->data)) {
            $this->reviews = [];

            return false;
        }
        if (!\array_key_exists('Hotel', $this->data['HotelDictionary'])) {
            $this->reviews = [];

            return false;
        }

        foreach ($this->data['HotelDictionary']['Hotel'] as $hotel) {
            $reviews[$hotel['HotelCodes']['HotelIffCode']] = [
                'count'          => $hotel['HotelReview']['RatingsCount'],
                'overall'        => $hotel['HotelReview']['MeanRatingOverall'],
                'recommendation' => $hotel['HotelReview']['MeanRecommendationRate'],
            ];
        }
        $this->reviews = $reviews;
    }

    /**
     * @param mixed $giataIds
     */
    public function setHotelGeo()
    {
        $geos = [];
        if (!\array_key_exists('HotelDictionary', $this->data)) {
            $this->geos = [];

            return false;
        }
        if (!\array_key_exists('Hotel', $this->data['HotelDictionary'])) {
            $this->geos = [];

            return false;
        }

        foreach ($this->data['HotelDictionary']['Hotel'] as $hotel) {
            $geos[$hotel['HotelCodes']['HotelIffCode']] = [
                'longitude' => $hotel['HotelGeoPoint']['Longitude'],
                'latitude'  => $hotel['HotelGeoPoint']['Latitude'],
            ];
        }
        $this->geos = $geos;
    }

    /**
     * @param mixed $giataIds
     */
    public function setHotelAttributes()
    {
        $hotelAttributes = [];
        if (!\array_key_exists('HotelDictionary', $this->data)) {
            $this->hotelAttributes = [];

            return false;
        }
        if (!\array_key_exists('Hotel', $this->data['HotelDictionary'])) {
            $this->hotelAttributes = [];

            return false;
        }

        foreach ($this->data['HotelDictionary']['Hotel'] as $hotel) {
            $hotelAttributes[$hotel['HotelCodes']['HotelIffCode']] = $hotel['HotelAttributes'];
        }
        $this->hotelAttributes = $hotelAttributes;
    }




    public function convertDuration($duration){
        $cDuration = 1;
        for ($i=1;$i<=$duration;$i++) {

            $cDuration = $cDuration * 2;
        }
        return $cDuration;
    }

    public function priceCheck($object){
        foreach (json_decode(stripslashes($object['data']), true)["prices"]['range'] as $price){
            if(isset($price["@attributes"])) {
                $rangeFromDate = Carbon::parse($price["@attributes"]["dateFrom"]);
                $fromDate = Carbon::parse($this->getFrom());

                $rangeToDate = Carbon::parse($price["@attributes"]["dateTo"]);
                $toDate = Carbon::parse($this->getTo());
                
                if ($fromDate->gt($rangeFromDate) && $rangeToDate->gt($toDate)) {
                    $price = floatval($price["price"]) * ($this->getAdults() + $this->getKids()) * $this->getPeriod();

                    return $price <= $this->getBudget();
                }
            }
        }
    }
}
