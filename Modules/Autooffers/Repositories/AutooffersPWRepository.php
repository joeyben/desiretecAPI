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
use Modules\Autooffers\Entities\Autooffer;
use Illuminate\Support\Facades\Log;

/**
 * Class AutooffersPWRepository.
 */
class AutooffersPWRepository extends BaseRepository
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
        $wsdl = 'http://pwhub.peakwork.de/pws/2010/03/?wsdl';


        $soapclient = new \SoapClient($wsdl, array('soap_version' => SOAP_1_2, 'login' => "pw_demo",
            'password' => "d3m0_pw!", 'trace' => 1, 'compression' =>
                SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

        $formDataContainer = new \stdClass;
        $formDataContainer->RequestType = 'package';
        $formDataContainer->MsgType = 'All';
        $formDataContainer->AuthKey = 'e0a7298a776df161ab2f6f6407f15520';
        $formDataContainer->Lang = 'de';
        $formDataContainer->Currency = 'EUR';
        $data = [];
        $data['Travellers']['Adult'][0]['Age'] = 28;
        $data['Travellers']['Adult'][1]['Age'] = 22;
        $data['Travellers']['Adult'][2]['Age'] = 22;
       // $data['TravelPeriod']['DepartureDate'] = "2020-12-01";
        //$data['TravelPeriod']['ReturnDate'] = "2020-12-20";
        $data['TravelPeriod']['Duration'] = '7';
        $data['Flight']['DepartureAirports'] = "HAM";
        $data['Flight']['ArrivalAirports'] = "OSL";
        $data['AuthKey'] = 'e0a7298a776df161ab2f6f6407f15520';
        $data['Lang'] = 'en';
        $data['Currency'] = 'EUR';
        $data['ResultsTotal'] = 3;
        //dd($soapclient->__getFunctions());
        $formData = $soapclient->GetPackageProduct($data);
        //echo "<pre>";
        //dd($formData);
        //echo "</pre>";
        //dd("yeah");
        $this->data = $formData;
        return $formData->Hotel;
        /*$xml_data = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns="http://www.peakwork.net/pws/2010/03">
   <soap:Header/>
     <soap:Body>
<PackageGroupRequest xmlns="http://www.peakwork.net/pws/2010/03" AuthKey="e0a7298a776df161ab2f6f6407f15520">
<TravelPeriod>
<DepartureDate>2020-10-01</DepartureDate>
           <Duration>128</Duration>
         </TravelPeriod>
         <Travellers>
<Adult Age="28"/> </Travellers> <Hotel>
           <Rooms />
         </Hotel>
       </PackageGroupRequest>
     </soap:Body>
   </soap:Envelope>';
        $URL = "http://pwhub.peakwork.de/pws/2010/03/?wsdl";

        $ch = curl_init($URL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        echo "------";

        print_r($output);*/
    }

    public function testRequest()
    {
        $wsdl = 'http://pwhub.peakwork.de/pws/2010/03/?wsdl';


        $soapclient = new \SoapClient($wsdl, array('soap_version' => SOAP_1_2, 'login' => "pw_demo",
            'password' => "d3m0_pw!", 'trace' => 1, 'compression' =>
                SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

        $formDataContainer = new \stdClass;
        $formDataContainer->RequestType = 'package';
        $formDataContainer->MsgType = 'All';
        $formDataContainer->AuthKey = 'e0a7298a776df161ab2f6f6407f15520';
        $formDataContainer->Lang = 'de';
        $formDataContainer->Currency = 'EUR';
        $formDataContainer->ShowRatings = true;
        $data = [];
        $data['Travellers']['Adult'][0]['Age'] = 28;
        $data['Travellers']['Adult'][1]['Age'] = 22;
        $data['Travellers']['Adult'][2]['Age'] = 22;
        // $data['TravelPeriod']['DepartureDate'] = "2020-12-01";
        //$data['TravelPeriod']['ReturnDate'] = "2020-12-20";
        $data['TravelPeriod']['Duration'] = '7';
        $data['Flight']['DepartureAirports'] = "HAM";
        $data['Flight']['ArrivalAirports'] = "OSL";
        $data['AuthKey'] = 'e0a7298a776df161ab2f6f6407f15520';
        $data['Lang'] = 'en';
        $data['Currency'] = 'EUR';
        $data['ResultsTotal'] = 3;
        //dd($soapclient->__getFunctions());
        $formData = $soapclient->GetPackageProduct($data);
        //echo "<pre>";
        //dd($formData);
        //echo "</pre>";
        //dd("yeah");
        $this->data = $formData;
        return $formData;
    }

    public function getAllData()
    {
        $wsdl = 'http://pwhub.peakwork.de/pws/2010/03/?wsdl';

        $soapclient = new \SoapClient($wsdl, array('soap_version' => SOAP_1_2, 'login' => "pw_demo",
            'password' => "d3m0_pw!", 'trace' => 1, 'compression' =>
                SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

        $formDataContainer = new \stdClass;
        $formDataContainer->RequestType = 'package';
        $formDataContainer->MsgType = 'All';
        $formDataContainer->AuthKey = 'e0a7298a776df161ab2f6f6407f15520';
        $formDataContainer->Lang = 'de';
        $formDataContainer->Currency = 'EUR';

        $formData = $soapclient->GetFormData($formDataContainer);

        dd($formData);
    }

    public function getToken()
    {
        $curl = curl_init();
        $auth_data = [
            'grant_type' => 'password',
            'username'   => $this->username,
            'password'   => $this->password,
            'client_id'  => 'gateway',
        ];
        curl_setopt($curl, CURLOPT_URL, $this->oauthUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, rawurldecode(http_build_query($auth_data)));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        if (!$result) {
            die('Connection Failure');
        }
        curl_close($curl);
        //dd($result);
        $this->token = json_decode($result, true)['access_token'];
    }

    public function getTTData()
    {
        $curl = curl_init();
        $travellers = '';

        for ($i = 0; $i < $this->adults; ++$i) {
            $travellers .= '{
                    "Age": 35
                }';
            if ($i + 1 < $this->adults) {
                $travellers .= ',';
            }
        }

        for ($i = 0; $i < $this->kids; ++$i) {
            if (0 === $i) {
                $travellers .= ',';
            }
            $travellers .= '{
                    "Age": 6
                }';
            if ($i + 1 < $this->kids) {
                $travellers .= ',';
            }
        }
        $xmlreq = '{
         "PackageOffersRQ": {
          "RQ_Metadata": {
           "Language": "de-CH"
          },
        "CurrencyCode": "' . $this->currency . '",
          "Travellers": {
            "Traveller": [
            ' . $travellers . '
            ]
          },
          "OfferFilters": {
           "DateAndTimeFilter": {
            "OutboundFlightDateAndTimeFilter": {
             "FlightEvent": "Departure",
             "DateRange": {
              "MinDate": "' . $this->from . '"
             }
            },
            "InboundFlightDateAndTimeFilter": {
             "FlightEvent": "Departure",
             "DateRange": {
              "MaxDate": "' . $this->to . '"
             }
            }
        },
           "TravelDurationFilter": {
            "DurationKind": "Stay",
            "MinDuration": ' . $this->minDuration . ',
            "MaxDuration": ' . $this->maxDuration . '
           },
           "PriceFilter": {
            "MaxPrice": ' . $this->getBudget() . '
           },
           "AirportFilter": {
            "DepartureAirportFilter": {
             "AirportCodes": [' . $this->airport . ']
        } },
           "AccomFilter": {
            "AccomSelectors": {
             "RegionIDs": [' . $this->getRegion() . ']
            }
           },
           "AccomPropertiesFilter": {
            "HotelAttributes": [],
            "BoardTypes": [' . $this->catering . '],
            "HotelCategoryFilter": {
                "HotelCategoryRange": {
                    "MinCategory": ' . (int) ($this->category) . '
                }
            },
            "HotelReview": {
                "MinRatingsCount": 10,
                "MinMeanRatingOverall": 4,
                "MinMeanRecommendationRate": 80
            }
           }
          },
          "Options": {
            "NumberOfResults": 500,
            "ResultOffset": 0,
            "Sorting": ["PriceAsc"]
          }
        } }';

        $authorization = 'Authorization: Bearer ' . $this->token;

        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]);
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlreq);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        if (!$result) {
            die('Connection Failure');
        }
        curl_close($curl);

        $this->data = json_decode($result, true)['PackageOffersRS'];
        if (\array_key_exists('Offers', $this->data)) {
            if (\array_key_exists('Offer', $this->data['Offers'])) {
                $this->offers = $this->data['Offers']['Offer'];
            } else {
                $this->offers = [];
            }
        } else {
            $this->offers = [];
        }
        if (empty($this->offers) && !$this->specialSearch) {
            $this->specialSearch = true;
            $this->setBudget(0);
            $this->getTTData();
        }
        $this->setGiataIds();
        $this->setReviews();
        $this->setHotelGeo();
        $this->setHotelAttributes();

        return $this->offers;
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

            $hotelId = $offer->References->GiataCode;
            /*if (!$this->checkValidity($hotelId, $wish_id)) {
                continue;
            }*/
            $tOperator = $offer->Offers->Offer->TourOperator->Code;
            $hotel = json_decode(json_encode($this->getFullHotelData($hotelId, $tOperator)), true);
            /*if (!\array_key_exists('data', $hotel) || !\array_key_exists('Bildfile', $hotel['data'])) {
                continue;
            }*/
            $this->storeAutooffer($offer, $hotel, $wish_id, $userId);
            ++$count;
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
        $giata_id = $hotelId;
        $username = '203339';
        $password = '605e5129';
        $remote_url = 'https://xml.giatamedia.com/?show=text,geo,pic800,hn,vn,ln,lk,katid,kn,hk,sn,sn,zi,ln,lc&sc=hotel&vc=' . $tOperator . '&gid=' . $giata_id;
        $opts = ['http'=> ['method'=> 'GET',
            'header'               => 'Authorization: Basic ' . base64_encode("$username:$password")]];

        $context = stream_context_create($opts);
        $file = file_get_contents($remote_url, false, $context);
        $xml = simplexml_load_string($file, 'SimpleXMLElement', LIBXML_NOCDATA);

        return json_decode(json_encode($xml), true);
    }

    /**
     * @return bool
     */
    public function saveWishData(Wish $wish, $whitelabelId)
    {

        /*$this->setMinBudget(0);
        $this->setBudget($wish->budget);
        $this->setAdults($wish->adults);
        $this->setKids($wish->kids);
        $this->setAirport($wish->airport, $whitelabelId);
        $this->setCategory($wish->category);
        $this->setCatering($wish->catering);
        $this->setFrom($wish->earliest_start);
        $this->setto($wish->latest_return);
        $this->setPeriod($wish->duration);
        $this->setRegion($wish->destination, 1);*/

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
    public function storeAutooffer($offer, $hotel, $wish_id, $userId)
    {
        try {
            $DepartureDate = new \DateTime($offer->Offers->Offer->Departure->DepartureDateTime);
            $ArrivalDate = new \DateTime($offer->Offers->Offer->Return->DepartureDateTime);
            $autooffer = self::MODEL;
            $autooffer = new $autooffer();
            $autooffer->code = $offer->Offers->Offer->ProductCode;
            $autooffer->type = 'pauschal';
            $autooffer->totalPrice = $offer->Offers->Offer->Price->Amount;
            $autooffer->personPrice = $offer->Offers->Offer->Price->PerPerson ? $offer->Offers->Offer->Price->Amount : ceil($offer->Offers->Offer->Price->Amount/count($this->data->Travellers->Adult));
            $autooffer->from = $DepartureDate->format('Y-m-d');
            $autooffer->to = $ArrivalDate->format('Y-m-d');
            $autooffer->tourOperator_code = $offer->Offers->Offer->TourOperator->Code;
            $autooffer->tourOperator_name = $offer->Offers->Offer->TourOperator->_;
            $autooffer->hotel_code = $offer->References->GiataCode;
            $autooffer->hotel_name = $offer->Name;
            $autooffer->hotel_location_name = $offer->Location->Region->_.', '.$offer->Location->City->_.', '.$offer->Location->Country->_;
            $autooffer->hotel_location_lng = $offer->Location->GeoCode->Longitude;
            $autooffer->hotel_location_lat = $offer->Location->GeoCode->Latitude;
            $autooffer->hotel_location_region_code = '';
            $autooffer->hotel_location_region_name = '';
            $autooffer->airport_code = $offer->Offers->Offer->Departure->ArrivalAirport->Code;
            $autooffer->airport_name = $offer->Offers->Offer->Departure->ArrivalAirport->_;
            $autooffer->data = json_encode($this->deserializeData($offer));
            $autooffer->hotel_data = json_encode($hotel);
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
            'hotel_reviews'    => "",
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
        switch ($this->period) {
            case 7:
                $this->setMinDuration(7);
                $this->setMaxDuration(8);
                break;
            case 14:
                $this->setMinDuration(13);
                $this->setMaxDuration(15);
                break;
            case 21:
                $this->setMinDuration(19);
                $this->setMaxDuration(22);
                break;
            case 28:
                $this->setMinDuration(26);
                $this->setMaxDuration(30);
                break;
            default:
                $this->setMinDuration($this->period);
                $this->setMaxDuration($this->period);
                break;
        }
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
        $noboard = '"NoBoard"';
        $breakfast = '"Breakfast","BreakfastEconomy","BreakfastSuperior"';
        $halfboard = '"HalfBoard","HalfBoardEconomy","HalfBoardSuperior"';
        $fullboard = '"FullBoard","FullBoardEconomy","FullBoardSuperior"';
        $allin = '"AllInclusive","AllInclusiveEconomy","AllInclusiveSuperior"';

        switch ($catering) {
            case 1:
                $this->catering = $noboard . ',' . $breakfast . ',' . $halfboard . ',' . $fullboard . ',' . $allin;
                break;
            case 2:
                $this->catering = $breakfast . ',' . $halfboard . ',' . $fullboard . ',' . $allin;
                break;
            case 3:
                $this->catering = $halfboard . ',' . $fullboard . ',' . $allin;
                break;
            case 4:
                $this->catering = $fullboard . ',' . $allin;
                break;
            case 5:
                $this->catering = $allin;
                break;
            default:
                $this->catering = $noboard . ',' . $breakfast . ',' . $halfboard . ',' . $fullboard . ',' . $allin;
                break;
        }
    }

    /**
     * @param $airport
     * @param $whitelabelId
     */
    public function setAirport($airport, $whitelabelId)
    {
        $airarr = explode(',', $airport);
        $airports = '';
        foreach ($airarr as $key => $air) {
            if ($key > 0) {
                $airports .= ',';
            }
            $airports .= '"' . getTTAirports($air, $whitelabelId) . '"';
        }
        $this->airport = $airports;
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
        $count = 0;
        $regions_str = '';
        foreach ($regions as $region) {
            if ($count > 0) {
                $regions_str .= ',';
            }
            $regions_str .= $region;
            ++$count;
        }
        $this->region = $regions_str;
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

    public  function testXML()
    {
        $xmlreq =  '<ttxml:AvailabilityAndPriceCheckRQ xmlns:ttxml="http://traveltainment.de/middleware/xml/AvailabilityAndPriceCheckRQ” LanguageCode="de-CH”>
	<OfferID>2193VTFNA2OXNPKJZ82O3VG43399NJKNJRTHL8AZB3N2K8ZVNTWSNO7AXZBNGXCKESZ9XT7PSZJY9W</OfferID>
	<TravellerList>
		<Traveller>
			<PersonName>
				<FirstName>Max</FirstName>
				<LastName>Mustermann</LastName>
			</PersonName>
			<Gender>MALE</Gender>
			<BirthDate>1970-01-01</BirthDate>
			<Type>ADULT</Type>
		</Traveller>
		<Traveller>
			<PersonName>
				<FirstName>Maxa</FirstName>
				<LastName>Mustermann</LastName>
			</PersonName>
			<Gender>FEMALE</Gender>
			<BirthDate>1970-01-01</BirthDate>
			<Type>ADULT</Type>
		</Traveller>
	</TravellerList>
</ttxml:AvailabilityAndPriceCheckRQ>';
        $this->getToken();
        $header  = "POST HTTP/1.0 \r\n";
        $header .= "Content-type: text/xml \r\n";
        $header .= "Content-length: ".strlen($xmlreq)." \r\n";
        $header .= "Authorization: Bearer ".$this->token." \r\n";
        $header .= "Content-transfer-encoding: text \r\n";
        $header .= "Connection: close \r\n\r\n";
        $header .= $xmlreq;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL,"https://de-ibe.ws.traveltainment.eu/ttgateway-web-v1_1/ttxml-bridge/TTXmlBridge/Dispatcher/Booking/Package/AvailabilityAndPriceCheck");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 4);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $header);

        $data = curl_exec($ch);
        var_dump($data);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        } else {
            curl_close($ch);
        }
    }
    public function testTT()
    {
        $requestXML = '{
         "AvailabilityAndPriceCheckRQ": {
          "RQ_Metadata": {
           "Language": "de-CH"
          }, 
        "CurrencyCode": "CHF",
          "Travellers": {
                    "Traveller": [
                           {
                                  "Age": 33
                           },
                           {
                                  "Age": 33
                           },
                           {
                                  "Age": 6
                           }
                    ]
             },
          "OfferID": "2193VTFNA2OXNPKJZ82O3VG43399NJKNJRTHL8AZB3N2K8ZVNTWSNO7AXZBNGXCKESZ9XT7PSZJY9W",
          "Options": {
          }
        }}';

        $server = 'https://de-ibe.ws.traveltainment.eu/ttgateway-web-v1_1/ttxml-bridge/TTXmlBridge/Dispatcher/Booking/Package/AvailabilityAndPriceCheck';
        $this->getToken();
        $headers = [
            'Content-type: text/xml',
            'Content-length: ' . mb_strlen($requestXML), 'Connection: close',
        ];
        $ch = curl_init();
        $authorization = 'Authorization: Bearer ' . $this->token;

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]);
        curl_setopt($ch, CURLOPT_URL, $server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXML);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = curl_exec($ch);
        dd($data);
        if (curl_errno($ch)) {
            echo curl_error($ch);
            echo 'Algo fallo';
        } else {
            curl_close($ch);
        }

        /*$curl = curl_init();

        $authorization = 'Authorization: Bearer ' . $this->token;

        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]);
        curl_setopt($curl, CURLOPT_URL, "https://de-ibe.ws.traveltainment.eu/ttgateway-web-v1_1/ttxml-bridge/TTXmlBridge/Dispatcher/Booking/Package/AvailabilityAndPriceCheck");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlreq);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        dd($result);
        if (!$result) {
            die('Connection Failure');
        }
        curl_close($curl);
        dd($result);*/
    }


    public function testTTbkp()
    {
        $xmlreq = '{
 "AvailabilityAndPriceCheckRQ": {
  "RQ_Metadata": {
   "Language": "de-CH"
  }, 
"CurrencyCode": "CHF",
  "Travellers": {
            "Traveller": [
                   {
                          "Age": 33
                   },
                   {
                          "Age": 33
                   },
                   {
                          "Age": 6
                   }
            ]
     },
  "OfferID": "2OUC6GYWCCKS9TNL1GLX6WJ3K3C8W1KX91JZEKZNXRSMJ9AVMAGNRNH4X7UVE8KX9YWLDTJM42MMDL",
  "Options": {
  }
}}';
        $curl = curl_init();

        $authorization = 'Authorization: Bearer ' . $this->token;

        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]);
        curl_setopt($curl, CURLOPT_URL, "https://de-ibe.ws.traveltainment.eu/ttgateway-web-v1_1/ttxml-bridge/TTXmlBridge/Dispatcher/Booking/Package/AvailabilityAndPriceCheck");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlreq);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        dd($result);
        if (!$result) {
            die('Connection Failure');
        }
        curl_close($curl);
        dd($result);
    }
}
