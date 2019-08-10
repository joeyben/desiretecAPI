<?php

namespace Modules\Novasol\Http\Controllers;

use App\Models\Whitelabels\Whitelabel;
use App\Repositories\Backend\Whitelabels\WhitelabelsRepository;
use App\Repositories\Frontend\Access\User\UserRepository;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository;
use Modules\Autooffers\Entities\Autooffer;
use Modules\Autooffers\Http\Services\AutooffersNovasolService;
use Modules\Autooffers\Repositories\AutooffersNovasolRepository;
use Modules\Categories\Repositories\Contracts\CategoriesRepository;
use Modules\Novasol\Http\Requests\StoreWishRequest;
use Modules\Wishes\Entities\Wish;
use Nwidart\Modules\Module;
use Underscore\Parse;
use Illuminate\Support\Facades\DB;


class NovasolController extends Controller
{
    protected $adults = [];
    protected $kids = [];
    protected $pets = [];
    protected $duration = [];

    private $whitelabelId;

    const BODY_CLASS = 'landing';
    /**
     * @var WhitelabelsRepository
     */
    protected $whitelabel;
    protected $attachements;
    protected $categories;

    /* @param WhitelabelsRepository $whitelabel
     * @param \Modules\Categories\Repositories\Contracts\CategoriesRepository $categories
     * @param \Modules\Attachments\Repositories\Eloquent\EloquentAttachmentsRepository $attachements
     */
    public function __construct(WhitelabelsRepository $whitelabel, CategoriesRepository $categories, EloquentAttachmentsRepository $attachements)
    {
        $this->whitelabel = $whitelabel;
        $this->attachements = $attachements;
        $this->adults = $categories->getChildrenFromSlug('slug', 'adults');
        $this->kids = $categories->getChildrenFromSlug('slug', 'kids');
        $this->pets = $this->translatePets($categories->getChildrenFromSlug('slug', 'pets'));
        $this->duration = $this->getFullDuration($categories->getChildrenFromSlug('slug', 'duration'));
        $this->whitelabelId = \Config::get('novasol.id');
        $this->categories = $categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $whitelabel = $this->whitelabel->getByName('Novasol');

        $xml = <<<XML
<?xml version='1.0' encoding='UTF-8'?>
<available>
    <next>EAL073</next>
    <property>
        <propertyid>EBI129</propertyid>
        <country>724</country>
        <area>EBL</area>
        <location><![CDATA[Cox]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>1032</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>8</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>true</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>28000</distwater>
        <watertype>Meer/Sandstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/ebi/ebi129_main_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EBI129?SD=11-08-2019&ED=18-08-2019&NA=8&NC=0&A=
            ]]>
        </url>
        <wsg84long>-0.9053179999999656</wsg84long>
        <wsg84lat>38.14153</wsg84lat>
    </property>
    <property>
        <propertyid>EAC265</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[Córdoba]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>708</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>4</adults>
        <children>1</children>
        <quality>4</quality>
        <pets>true</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>1300</distwater>
        <watertype>Hallenbad</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac265_outdoor_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC265?SD=11-08-2019&ED=18-08-2019&NA=4&NC=1&A=
            ]]>
        </url>
        <wsg84long>-4.751674200000025</wsg84long>
        <wsg84lat>37.8910738</wsg84lat>
    </property>
    <property>
        <propertyid>EAC266</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[Córdoba]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>708</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>4</adults>
        <children>1</children>
        <quality>4</quality>
        <pets>true</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>1300</distwater>
        <watertype>Hallenbad</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac266_outdoor_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC266?SD=11-08-2019&ED=18-08-2019&NA=4&NC=1&A=
            ]]>
        </url>
        <wsg84long>-4.751505304521061</wsg84long>
        <wsg84lat>37.89109433946166</wsg84lat>
    </property>
    <property>
        <propertyid>EAC395</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[Granada]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>771</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>5</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>false</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>70000</distwater>
        <watertype>Meer/Sandstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/default.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC395?SD=11-08-2019&ED=18-08-2019&NA=5&NC=0&A=
            ]]>
        </url>
        <wsg84long>-3.6002668999999514</wsg84long>
        <wsg84lat>37.169497</wsg84lat>
    </property>
    <property>
        <propertyid>EBI038</propertyid>
        <country>724</country>
        <area>EBL</area>
        <location><![CDATA[Torrevieja]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>693</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>4</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>true</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>150</distwater>
        <watertype>Sandstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/ebi/ebi038_living_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EBI038?SD=11-08-2019&ED=18-08-2019&NA=4&NC=0&A=
            ]]>
        </url>
        <wsg84long>-0.6658302393626627</wsg84long>
        <wsg84lat>37.980108161329895</wsg84lat>
    </property>
    <property>
        <propertyid>EBL484</propertyid>
        <country>724</country>
        <area>EBL</area>
        <location><![CDATA[La Nucia]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>773</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>4</adults>
        <children>0</children>
        <quality>2</quality>
        <pets>false</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>4000</distwater>
        <watertype>Meer/Sandstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/ebl/ebl484_main_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EBL484?SD=11-08-2019&ED=18-08-2019&NA=4&NC=0&A=
            ]]>
        </url>
        <wsg84long>-0.13682100000005448</wsg84long>
        <wsg84lat>38.576473</wsg84lat>
    </property>
    <property>
        <propertyid>EBL496</propertyid>
        <country>724</country>
        <area>EBL</area>
        <location><![CDATA[Dolores]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>775</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>6</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>true</pets>
        <swimmingpool>true</swimmingpool>
        <spa>false</spa>
        <distwater>12200</distwater>
        <watertype>Meer/Sandstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/ebl/ebl496_pool_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EBL496?SD=11-08-2019&ED=18-08-2019&NA=6&NC=0&A=
            ]]>
        </url>
        <wsg84long>-0.7730329999999412</wsg84long>
        <wsg84lat>38.137941</wsg84lat>
    </property>
    <property>
        <propertyid>ECC732</propertyid>
        <country>724</country>
        <area>ECC</area>
        <location><![CDATA[Cartagena]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>1256</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>8</adults>
        <children>2</children>
        <quality>3</quality>
        <pets>false</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>4000</distwater>
        <watertype>Meer/Sandstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/ecc/ecc732_living_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/ECC732?SD=11-08-2019&ED=18-08-2019&NA=8&NC=2&A=
            ]]>
        </url>
        <wsg84long>-0.9878906999999799</wsg84long>
        <wsg84lat>37.599653</wsg84lat>
    </property>
    <property>
        <propertyid>ELB001</propertyid>
        <country>724</country>
        <area>ELB</area>
        <location><![CDATA[Tanabueyes/Burgos]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>495</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>2</adults>
        <children>2</children>
        <quality>3</quality>
        <pets>false</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>11000</distwater>
        <watertype>See</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/elb/elb001_main_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/ELB001?SD=11-08-2019&ED=18-08-2019&NA=2&NC=2&A=
            ]]>
        </url>
        <wsg84long>-3.3975110000000086</wsg84long>
        <wsg84lat>42.16568</wsg84lat>
    </property>
    <property>
        <propertyid>ETE010</propertyid>
        <country>724</country>
        <area>ETE</area>
        <location><![CDATA[Buenavista del Norte]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>684</price>
        <discount>76</discount>
        <currency>EUR</currency>
        <adults>6</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>false</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>2000</distwater>
        <watertype>Kiesstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/ete/ete010_main_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/ETE010?SD=11-08-2019&ED=18-08-2019&NA=6&NC=0&A=
            ]]>
        </url>
        <wsg84long>-16.86050899999998</wsg84long>
        <wsg84lat>28.3678256</wsg84lat>
    </property>
    <property>
        <propertyid>ETE011</propertyid>
        <country>724</country>
        <area>ETE</area>
        <location><![CDATA[Buenavista del Norte]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>569</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>4</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>false</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>2000</distwater>
        <watertype>Kiesstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/ete/ete011_main_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/ETE011?SD=11-08-2019&ED=18-08-2019&NA=4&NC=0&A=
            ]]>
        </url>
        <wsg84long>-16.862195018967895</wsg84long>
        <wsg84lat>28.36664983023535</wsg84lat>
    </property>
    <property>
        <propertyid>ETE352</propertyid>
        <country>724</country>
        <area>ETE</area>
        <location><![CDATA[Puerto de la Cruz-Tenerife]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>999</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>2</adults>
        <children>0</children>
        <quality>4</quality>
        <pets>false</pets>
        <swimmingpool>true</swimmingpool>
        <spa>false</spa>
        <distwater>1500</distwater>
        <watertype>Sandstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/ete/ete352_main_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/ETE352?SD=11-08-2019&ED=18-08-2019&NA=2&NC=0&A=
            ]]>
        </url>
        <wsg84long>-16.55611111</wsg84long>
        <wsg84lat>28.40611111</wsg84lat>
    </property>
    <property>
        <propertyid>EAC043</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[Iznájar]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>635</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>3</adults>
        <children>1</children>
        <quality>3</quality>
        <pets>false</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>1000</distwater>
        <watertype>See</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac043_outdoor_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC043?SD=11-08-2019&ED=18-08-2019&NA=3&NC=1&A=
            ]]>
        </url>
        <wsg84long>-4.30771</wsg84long>
        <wsg84lat>37.25718</wsg84lat>
    </property>
    <property>
        <propertyid>EAC126</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[El Gastor]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>572</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>4</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>false</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>5000</distwater>
        <watertype>See</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac126_outdoor_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC126?SD=11-08-2019&ED=18-08-2019&NA=4&NC=0&A=
            ]]>
        </url>
        <wsg84long>-5.324033999999983</wsg84long>
        <wsg84lat>36.854811</wsg84lat>
    </property>
    <property>
        <propertyid>EAC142</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[El Gastor]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>771</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>2</adults>
        <children>1</children>
        <quality>4</quality>
        <pets>false</pets>
        <swimmingpool>true</swimmingpool>
        <spa>false</spa>
        <distwater>6000</distwater>
        <watertype>See</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac142_pool_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC142?SD=11-08-2019&ED=18-08-2019&NA=2&NC=1&A=
            ]]>
        </url>
        <wsg84long>-5.323660000000018</wsg84long>
        <wsg84lat>36.83382</wsg84lat>
    </property>
    <property>
        <propertyid>EAC199</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[Ronda]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>774</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>4</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>false</pets>
        <swimmingpool>true</swimmingpool>
        <spa>false</spa>
        <distwater>35000</distwater>
        <watertype>Meer/Sandstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac199_main_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC199?SD=11-08-2019&ED=18-08-2019&NA=4&NC=0&A=
            ]]>
        </url>
        <wsg84long>-5.250174000000015</wsg84long>
        <wsg84lat>36.735423</wsg84lat>
    </property>
    <property>
        <propertyid>EAC282</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[Prado del Rey]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>709</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>4</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>true</pets>
        <swimmingpool>true</swimmingpool>
        <spa>false</spa>
        <distwater>1000</distwater>
        <watertype>Hallenbad</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac282_main_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC282?SD=11-08-2019&ED=18-08-2019&NA=4&NC=0&A=
            ]]>
        </url>
        <wsg84long>-5.55663363790768</wsg84long>
        <wsg84lat>36.7894936842707</wsg84lat>
    </property>
    <property>
        <propertyid>EAC301</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[Prado del Rey]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>571</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>2</adults>
        <children>2</children>
        <quality>3</quality>
        <pets>true</pets>
        <swimmingpool>true</swimmingpool>
        <spa>false</spa>
        <distwater>1000</distwater>
        <watertype>Hallenbad</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac301_view_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC301?SD=11-08-2019&ED=18-08-2019&NA=2&NC=2&A=
            ]]>
        </url>
        <wsg84long>-5.5566416261576705</wsg84long>
        <wsg84lat>36.78948975666275</wsg84lat>
    </property>
    <property>
        <propertyid>EAC420</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[Fontanar]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>1249</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>8</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>true</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>19100</distwater>
        <watertype>Kiesstrand</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac420_main_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC420?SD=11-08-2019&ED=18-08-2019&NA=8&NC=0&A=
            ]]>
        </url>
        <wsg84long>-2.975223000000028</wsg84long>
        <wsg84lat>37.669169045396615</wsg84lat>
    </property>
    <property>
        <propertyid>EAC434</propertyid>
        <country>724</country>
        <area>EAC</area>
        <location><![CDATA[Córdoba]]></location>
        <available>1</available>
        <arrival>20190811</arrival>
        <departure>20190818</departure>
        <price>569</price>
        <discount>0</discount>
        <currency>EUR</currency>
        <adults>4</adults>
        <children>0</children>
        <quality>3</quality>
        <pets>false</pets>
        <swimmingpool>false</swimmingpool>
        <spa>false</spa>
        <distwater>500</distwater>
        <watertype>Hallenbad</watertype>
        <thumbnail>
            <![CDATA[
            https://sdc.novasol.com/pic/100/eac/eac434_living_01.jpg
            ]]>
        </thumbnail>
        <url>
            <![CDATA[
            http://secure.novasol.com/p/EAC434?SD=11-08-2019&ED=18-08-2019&NA=4&NC=0&A=
            ]]>
        </url>
        <wsg84long>-4.7638772000000245</wsg84long>
        <wsg84lat>37.8946611</wsg84lat>
    </property>
</available>
XML;







        return view('novasol::index')->with([
            'display_name'  => $whitelabel['display_name'],
            'bg_image'      => $this->attachements->getAttachementsByType($this->whitelabelId, 'background')['url'],
            'logo'          => $this->attachements->getAttachementsByType($this->whitelabelId, 'logo')['url'],
            'body_class'    => $this::BODY_CLASS,
        ]);
    }

    /**
     * Return the specified resource.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $input = $request->only('variant');
        $layer = $input['variant'] === "eil-mobile" ? "layer.popup-mobile" : "layer.popup";

        $html = view('novasol::'.$layer)->with([
            'adults_arr'   => $this->adults,
            'kids_arr'     => $this->kids,
            'pets_arr' => $this->pets,
            'duration_arr' => $this->duration,
            'request' => $request->all(),
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRepository   $user
     * @param StoreWishRequest $request
     * @param WishesRepository $wish
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreWishRequest $request, UserRepository $user, WishesRepository $wish)
    {
        $input = $request->all();
        if ($request->failed()) {
            $layer = $input['variant'] === "eil-mobile" ? "layer.popup-mobile" : "layer.popup";
            $html = view('novasol::'.$layer)->with([
                'adults_arr'   => $this->adults,
                'errors'       => $request->errors(),
                'kids_arr'     => $this->kids,
                'pets_arr' => $this->pets,
                'duration_arr' => $this->duration,
                'request' => $request->all()
            ])->render();

            return response()->json(['success' => true, 'html'=>$html]);
        }

        $newUser = $user->createUserFromLayer(
            $request->only('first_name', 'last_name', 'email', 'password', 'is_term_accept', 'terms'),
            $this->whitelabelId
        );

        $wish = $this->createWishFromLayer($request, $wish);
        $html = view('novasol::layer.created')->with([
            'token' => $newUser->token->token,
            'id'    => $wish->id
        ])->render();

        return response()->json(['success' => true, 'html'=>$html]);
    }

    private function setAdults()
    {
        for ($i = 1; $i <= 8; ++$i) {
            $this->adults[$i] = $i;
        }
        for ($i = 0; $i <= 3; ++$i) {
            $this->kids[$i] = $i;
        }
    }

    /**
     * Create new user from Layer.
     *
     * @param WishesRepository $wish
     * @param StoreWishRequest $request
     *
     * @return object
     */
    private function createWishFromLayer(StoreWishRequest $request, $wish)
    {
        $request->merge(['featured_image' => 'novasol.jpg']);
        $new_wish = $wish->create(
            $request->except('variant', 'first_name', 'last_name', 'email', 'password', 'is_term_accept', 'name', 'terms','pets'),
            $this->whitelabelId
        );
        $pets = $this->categories->getCategoryIdByParentValue('pets', $request->get('pets'));
        $wish->storeCategoryWish($pets, $new_wish);
        return $new_wish;
    }

    /**
     * @param array $duration
     *
     * @return array
     */
    private function getFullDuration($duration)
    {
        for ($i = 1; $i < 29; ++$i) {
            $night = 1 === $i ? 'Nacht' : 'Nächte';
            $duration[$i] = $i . ' ' . $night;
        }

        return $duration;
    }

    /**
     * @param array $pets
     *
     * @return array
     */
    private function translatePets($pets)
    {
        foreach ($pets as $key => $value) {
            $pets[$key] = trans('layer.pets.'.$value);
        }

        return $pets;
    }

    public function getProduct($id)
    {
        $url = 'https://safe.novasol.com/api/products/'. $id . '?salesmarket=208&season=2019';

        $opts = [
                "http" => [
                    "method" => "GET",
                    "header" => "Accept-language: en\r\n" .
                    "Key: WEvoSrIfHvZtVhlyKIWYfP5WjGcPVB\r\n" .
                    "Host: novasol.reise-wunsch.com\r\n"
                ]
            ];

        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $file = file_get_contents($url, false, $context);

        var_dump(Parse::fromXML($file));
    }

    public function fillCountriesFromNovasolApi()
    {
        $url = 'https://safe.novasol.com/api/countries?salesmarket=280';

        $opts = [
                "http" => [
                    "method" => "GET",
                    "header" => "Accept-language: en\r\n" .
                    "Key: WEvoSrIfHvZtVhlyKIWYfP5WjGcPVB\r\n" .
                    "Host: novasol.reise-wunsch.com\r\n"
                ]
            ];

        $context = stream_context_create($opts);

        // Open the file using the HTTP headers set above
        $file = file_get_contents($url, false, $context);

        $arr = [];
        $countries = simplexml_load_string($file);
        foreach ($countries as $country) {
            $arr[] = [
                'name' => $country,
                'novasol_code' => $country['iso']
            ];
        }

        DB::table('novasol_country')->insert($arr);
    }

    public function fillAreasFromNovasolApi()
    {
        $countries = DB::table('novasol_country')->get();
        $arr = [];
        $areasArr = [];
        $count = 0;
            foreach ($countries as $country) {
                $url = 'https://safe.novasol.com/api/countries/'. $country->novasol_code . '?salesmarket=280';
                $opts = [
                        "http" => [
                            "method" => "GET",
                            "header" => "Accept-language: en\r\n" .
                            "Key: WEvoSrIfHvZtVhlyKIWYfP5WjGcPVB\r\n" .
                            "Host: novasol.reise-wunsch.com\r\n"
                        ]
                    ];
                $context = stream_context_create($opts);

                // Open the file using the HTTP headers set above
                $file = file_get_contents($url, false, $context);


                $arr[] = $file;
                $count++;


                $areas = simplexml_load_string($file);
                $areasArr[] = $areas;

                /*foreach ($areas as $area) {
                            foreach ($area->area as $subarea) {
                                $arr[] = [
                                    'name' => $subarea->name,
                                    'novasol_country_id' => $country->id,
                                    'novasol_area_code' => $subarea['id'],
                                ];
                                 foreach ($subarea->area as $subsubarea){
                                     $arr[] = [
                                         'name' => $subsubarea->name,
                                         'novasol_country_id' => $country->id,
                                         'novasol_area_code' => $subsubarea['id'],
                                     ];
                                     foreach ($subsubarea->area as $lastarea) {
                                         $arr[] = [
                                             'name' => $lastarea->name,
                                             'novasol_country_id' => $country->id,
                                             'novasol_area_code' => $lastarea['id'],
                                         ];
                                     }

                                 }
                            }

                        }*/

            }

            dd([
               //'areasArr'  => $areasArr,
                'arr2save' => $arr,
                'count' => $count
            ]);

        //DB::table('novasol_area')->insert($arr);
    }
}
