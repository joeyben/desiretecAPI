<?php

use Illuminate\Database\Seeder;

class KeywordListTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('KeywordList')->delete();
        
        \DB::table('KeywordList')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 'bea',
                'name' => 'Direkt am Strand',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 'ben',
                'name' => 'Strandnah',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 'chf',
                'name' => 'Kinderfreundlich',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 'ecc',
                'name' => 'Kinderbetreuung',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 'eec',
            'name' => 'Unterhaltungsprogramm (Kinder)',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 'emd',
                'name' => 'Mini-Disco',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 'emc',
                'name' => 'Miniclub',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 'fbs',
                'name' => 'Babysitter',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 'fcp',
                'name' => 'Kinderpool',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 'fpg',
                'name' => 'Spielplatz',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 'fpr',
                'name' => 'Spielzimmer',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 'mcm',
                'name' => 'Kindermenüs',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 'rcb',
                'name' => 'Kinderbett',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 'hca',
                'name' => 'Kinderhochstuhl',
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 'ani',
                'name' => 'Animation',
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 'clb',
                'name' => 'Club',
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 'spt',
                'name' => 'Sport',
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 'sws',
                'name' => 'Wassersport',
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 'sbs',
                'name' => 'Ballsport',
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 'shb',
                'name' => 'Hiking / Biking',
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 'sgl',
                'name' => 'Golf',
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 'srd',
                'name' => 'Reiten',
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 'sae',
                'name' => 'Aerobic',
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 'sfr',
                'name' => 'Fitnessraum',
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 'stn',
                'name' => 'Tennis',
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 'sdv',
                'name' => 'Tauchen',
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 'sth',
                'name' => 'Sonstiges',
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 'wel',
                'name' => 'Wellness',
            ),
            28 => 
            array (
                'id' => 29,
                'code' => 'wms',
                'name' => 'Massage',
            ),
            29 => 
            array (
                'id' => 30,
                'code' => 'way',
                'name' => 'Ayurveda',
            ),
            30 => 
            array (
                'id' => 31,
                'code' => 'wth',
                'name' => 'Thalasso',
            ),
            31 => 
            array (
                'id' => 32,
                'code' => 'wcu',
                'name' => 'Kuranwendung',
            ),
            32 => 
            array (
                'id' => 33,
                'code' => 'wsn',
                'name' => 'Dampfbad / Sauna',
            ),
            33 => 
            array (
                'id' => 34,
                'code' => 'wdt',
                'name' => 'Diät',
            ),
            34 => 
            array (
                'id' => 35,
                'code' => 'waa',
                'name' => 'Anti Aging',
            ),
            35 => 
            array (
                'id' => 36,
                'code' => 'wbf',
                'name' => 'Beauty Farm',
            ),
            36 => 
            array (
                'id' => 37,
                'code' => 'wac',
                'name' => 'Aktiv sein',
            ),
            37 => 
            array (
                'id' => 38,
                'code' => 'wap',
                'name' => 'Akupunktur',
            ),
            38 => 
            array (
                'id' => 39,
                'code' => 'pol',
                'name' => 'Pool',
            ),
            39 => 
            array (
                'id' => 40,
                'code' => 'ipl',
                'name' => 'Hallenbad',
            ),
            40 => 
            array (
                'id' => 41,
                'code' => 'fin',
                'name' => 'Internetzugang im Haus',
            ),
            41 => 
            array (
                'id' => 42,
                'code' => 'fwi',
                'name' => 'WLAN',
            ),
            42 => 
            array (
                'id' => 43,
                'code' => 'fwc',
                'name' => 'behindertengerecht',
            ),
            43 => 
            array (
                'id' => 44,
                'code' => 'lcs',
                'name' => 'zentrale Lage',
            ),
            44 => 
            array (
                'id' => 45,
                'code' => 'rbe',
                'name' => 'getrennte Schlafzimmer',
            ),
            45 => 
            array (
                'id' => 46,
                'code' => 'rin',
                'name' => 'Internetzugang im Zimmer',
            ),
            46 => 
            array (
                'id' => 47,
                'code' => 'rsm',
                'name' => 'Raucherzimmer',
            ),
            47 => 
            array (
                'id' => 48,
                'code' => 'rse',
                'name' => 'Meerblick',
            ),
            48 => 
            array (
                'id' => 49,
                'code' => 'krz',
                'name' => 'Kreuzfahrten',
            ),
            49 => 
            array (
                'id' => 50,
                'code' => 'bhn',
                'name' => 'Bahnreisen',
            ),
            50 => 
            array (
                'id' => 51,
                'code' => 'bus',
                'name' => 'Busreisen',
            ),
            51 => 
            array (
                'id' => 52,
                'code' => 'rdr',
                'name' => 'Rundreisen',
            ),
            52 => 
            array (
                'id' => 53,
                'code' => 'cit',
                'name' => 'Städtereisen',
            ),
            53 => 
            array (
                'id' => 54,
                'code' => 'kur',
                'name' => 'Kurreisen',
            ),
            54 => 
            array (
                'id' => 55,
                'code' => 'ski',
                'name' => 'Skireisen',
            ),
            55 => 
            array (
                'id' => 56,
                'code' => 'cmp',
                'name' => 'Camping',
            ),
            56 => 
            array (
                'id' => 57,
                'code' => 'few',
                'name' => 'Ferienwohnungen',
            ),
        ));
        
        
    }
}