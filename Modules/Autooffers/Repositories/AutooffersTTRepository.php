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
class AutooffersTTRepository extends BaseRepository
{
    /**
     * Associated Repository Model.
     */
    const MODEL = Autooffer::class;

    private $token = '';

    private $username = 'mkt_315150_de';

    private $password = '_Herostrasse12';

    private $oauthUrl = 'https://staging-auth.ws.traveltainment.eu:443/auth/realms/SystemUser-BasicAccessLevel/protocol/openid-connect/token';

    private $url = 'http://de-staging-ibe.ws.traveltainment.eu/ttgateway-web-v1_1/rest/PackageSearch/bestPackageOfferForHotel';

    private $currency = 'CHF';

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

    protected $reviews;

    protected $hotelAttributes;

    protected $data;

    protected $offers;

    protected $tourOperatorList = '';

    public function model()
    {
        return Autooffer::class;
    }

    public function getToken()
    {
        $curl = curl_init();
        $auth_data = array(
            'grant_type' => 'password',
            'username'  => $this->username,
            'password'  => $this->password,
            'client_id'  => 'gateway',
        );
        curl_setopt($curl, CURLOPT_URL, $this->oauthUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, rawurldecode(http_build_query($auth_data)));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        $this->token = json_decode($result, true)["access_token"];
    }

    public function getTTData()
    {
        $curl = curl_init();
        $travellers = "";

        for($i = 0; $i < $this->adults;$i++){
            $travellers .= '"Traveller": [{
                    "Age": 35
                }]';
            if($i+1 < $this->adults){
                $travellers.= ',';
            }
        }

        for($i = 0; $i < $this->kids;$i++){
            $travellers .= '"Traveller": [{
                    "Age": 12
                }]';
            if($i+1 < $this->kids){
                $travellers.= ',';
            }
        }

        $xmlreq='{
         "BestPackageOfferForHotelRQ": {
          "RQ_Metadata": {
           "Language": "de-DE"
          },
        "CurrencyCode": "'.$this->currency.'",
          "Travellers": {
           '.$travellers.'
          },
          "OfferFilters": {
           "DateAndTimeFilter": {
            "OutboundFlightDateAndTimeFilter": {
             "FlightEvent": "Departure",
             "DateRange": {
              "MinDate": "'.$this->from.'",
              "MinDate": "'.$this->to.'"
             }
            }
        },
           "TravelDurationFilter": {
            "MinDuration": '.intval($this->period).'
           },
           "AirportFilter": {
            "DepartureAirportFilter": {
             "AirportCodes": ["'.$this->airport.'"]
        } },
           "AccomFilter": {
            "AccomSelectors": {
             "RegionIDs": ['.$this->getRegion().']
            }
           },
           "AccomPropertiesFilter": {
            "HotelAttributes": [],
            "HotelCategoryFilter": {
            }
           }
          },
          "Options": {
            "NumberOfResults": 50,
            "ResultOffset": 0,
            "Sorting": ["MeanRecommendationRateDesc"]
          }
        } }';

        $authorization = "Authorization: Bearer ".$this->token;

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlreq);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);

        $this->data = json_decode($result, true)["BestPackageOfferForHotelRS"];
        $this->offers = $this->data["Offers"]["Offer"];
        $this->setGiataIds();
        $this->setReviews();
        $this->setHotelAttributes();
        return $result;
    }

    /**
     * @param  $data
     * @param string $wish_id
     * @param array $rules
     */
    public function storeMany($wish_id, $rules)
    {

        $count = 0;
        foreach ($this->offers as $key => $offer) {

            $hotelId = $offer["OfferServices"]['Package']['Accommodation']['HotelRef']["HotelID"];
            if (!$this->checkValidity($hotelId, $wish_id) || !key_exists("TravelType", $offer)) {
                continue;
            }
            $tOperator = $offer["TourOperator"]['TourOperatorCode'];
            $hotel = json_decode(json_encode($this->getFullHotelData($hotelId, $tOperator)), true);
            if (!key_exists('data', $hotel) || !key_exists('Bildfile', $hotel['data'])) {
                continue;
            }
            $this->storeAutooffer($offer, $hotel, $wish_id);
            $count++;
            if ($count >= 3) {
                break;
            }
        }
    }

    /**
     * @param string $hotelId
     *
     * @return bool
     */
    public function getFullHotelData($hotelId, $tOperator)
    {

        $giata_id = $this->giataIds[$hotelId];
        $username = "203339";
        $password = "605e5129";
        $remote_url = 'https://xml.giatamedia.com/?show=text,geo,pic800,hn,vn,ln,lk,katid,kn,hk,sn,sn,zi,ln,lc&sc=hotel&vc='.$tOperator.'&gid='.$giata_id;

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
        $this->setKids($wish->kids);
        $this->setAirport(trim(explode('-',$wish->airport)[1]));
        $this->setCategory($wish->category);
        $this->setCatering('XX,AO,BB,HB,HBP,FB,FBP,AI,AIP,AIU,AIR');
        $this->setFrom($wish->earliest_start);
        $this->setto($wish->latest_return);
        $this->setPeriod($wish->duration);
        $this->setRegion(getTTRegionCode($wish->destination, 1));

        return true;
    }


    /**
     * @param  $data
     * @param string $wish_id
     * @param array $rulesArray
     *
     * @return boolean
     */
    public function checkValidity($hotelId, $wish_id)
    {
        $autooffer = Autooffer::where('wish_id',$wish_id)->where('hotel_code', $hotelId)->count();
        return $autooffer === 0 ;
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
            $autooffer->code = $offer["OfferID"];
            $autooffer->type = key_exists("TravelType", $offer) ? $offer["TravelType"] : "NM";
            $autooffer->totalPrice = $offer["PriceInfo"]["Price"]["value"];
            $autooffer->personPrice = $offer["PriceInfo"]["Price"]["value"];
            $autooffer->from = $offer["TravelDateInfo"]["DepartureDate"];
            $autooffer->to = $offer['TravelDateInfo']['ReturnDate'];
            $autooffer->tourOperator_code = $offer['TourOperator']['TourOperatorCode'];
            $autooffer->tourOperator_name = $offer['TourOperator']['TourOperatorName'];
            $autooffer->hotel_code = $offer["OfferServices"]['Package']['Accommodation']['HotelRef']["HotelID"];
            $autooffer->hotel_name = $offer["OfferServices"]['Package']['Accommodation']['HotelRef']["HotelID"];
            $autooffer->hotel_location_name =  "";
            $autooffer->hotel_location_lng =  0;
            $autooffer->hotel_location_lat =  0;
            $autooffer->hotel_location_region_code =  "";
            $autooffer->hotel_location_region_name =  "";
            $autooffer->airport_code =  $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["FlightArrival"]["ArrivalAirportRef"]["AirportCode"];
            $autooffer->airport_name =  "";
            $autooffer->data = json_encode($this->deserializeData($offer));
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
    public function deserializeData($offer)
    {
        $data  = [
            'from' => $offer["TravelDateInfo"]["DepartureDate"],
            'to' => $offer["TravelDateInfo"]["ReturnDate"],
            'duration' => $offer["TravelDateInfo"]["TripDuration"],
            'tourOperator' => [
                "code" => $offer["TourOperator"]["TourOperatorCode"],
                "name" => $offer["TourOperator"]["TourOperatorName"],
                "image" => $offer["TourOperator"]["TourOperatorImage"]
            ],
            'price' => [
                "value" => $offer["PriceInfo"]["Price"]["value"],
                "currency" => $offer["PriceInfo"]["Price"]["CurrencyCode"]
            ],
            'offerFeatures' => $offer["OfferProperties"]["OfferFeatures"],
            'hotel_reviews' => $this->reviews[$offer["OfferServices"]["Package"]["Accommodation"]["HotelRef"]["HotelID"]],
            'hotel_attributes' => $this->hotelAttributes[$offer["OfferServices"]["Package"]["Accommodation"]["HotelRef"]["HotelID"]],
            'room' => $offer["OfferServices"]["Package"]["Accommodation"]["Room"]["RoomName"],
            'flight' => [
                'in' => [
                    'departure' => [
                        'airport' => $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["FlightDeparture"]["DepartureAirportRef"]["AirportCode"],
                        'date' => $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["FlightDeparture"]["DepartureDate"],
                        'time' => $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["FlightDeparture"]["DepartureTime"],
                    ],
                    'arrival' => [
                        'airport' => $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["FlightArrival"]["ArrivalAirportRef"]["AirportCode"],
                        'date' => $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["FlightArrival"]["ArrivalDate"],
                        'time' => $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["FlightArrival"]["ArrivalTime"],
                    ],
                    'duration' => $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["FlightDuration"],
                    'stops' => $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["NumberOfStops"],
                    'class' => $offer["OfferServices"]["Package"]["Flight"]["OutboundFlight"]["CabinClass"]["value"],
                ],
                'out' => [
                    'departure' => [
                        'airport' => $offer["OfferServices"]["Package"]["Flight"]["InboundFlight"]["FlightDeparture"]["DepartureAirportRef"]["AirportCode"],
                        'date' => $offer["OfferServices"]["Package"]["Flight"]["InboundFlight"]["FlightDeparture"]["DepartureDate"],
                        'time' => $offer["OfferServices"]["Package"]["Flight"]["InboundFlight"]["FlightDeparture"]["DepartureTime"],
                    ],
                    'arrival' => [
                        'airport' => $offer["OfferServices"]["Package"]["Flight"]["InboundFlight"]["FlightArrival"]["ArrivalAirportRef"]["AirportCode"],
                        'date' => $offer["OfferServices"]["Package"]["Flight"]["InboundFlight"]["FlightArrival"]["ArrivalDate"],
                        'time' => $offer["OfferServices"]["Package"]["Flight"]["InboundFlight"]["FlightArrival"]["ArrivalTime"],
                    ],
                    'duration' => $offer["OfferServices"]["Package"]["Flight"]["InboundFlight"]["FlightDuration"],
                    'stops' => $offer["OfferServices"]["Package"]["Flight"]["InboundFlight"]["NumberOfStops"],
                    'class' => $offer["OfferServices"]["Package"]["Flight"]["InboundFlight"]["CabinClass"]["value"],
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
    public function setGiataIds()
    {
        $giata = [];
        foreach ($this->data["HotelDictionary"]["Hotel"] as $hotel){
            $giata[$hotel["HotelCodes"]["HotelIffCode"]] = $hotel["HotelCodes"]["HotelGiataID"];
        }
        $this->giataIds = $giata;
    }

    /**
     * @param mixed $giataIds
     */
    public function setReviews()
    {
        $reviews = [];
        foreach ($this->data["HotelDictionary"]["Hotel"] as $hotel){
            $reviews[$hotel["HotelCodes"]["HotelIffCode"]] = [
                'count' => $hotel["HotelReview"]["RatingsCount"],
                'overall' => $hotel["HotelReview"]["MeanRatingOverall"],
                'recommendation' => $hotel["HotelReview"]["MeanRecommendationRate"],
            ];
        }
        $this->reviews = $reviews;
    }

    /**
     * @param mixed $giataIds
     */
    public function setHotelAttributes()
    {
        $hotelAttributes = [];
        foreach ($this->data["HotelDictionary"]["Hotel"] as $hotel){
            $hotelAttributes[$hotel["HotelCodes"]["HotelIffCode"]] = $hotel["HotelAttributes"];
        }
        $this->hotelAttributes = $hotelAttributes;
    }
}
