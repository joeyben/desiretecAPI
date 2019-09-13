<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('Regions')->delete();
        
        \DB::table('Regions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'regionCode' => 'ACH',
            'regionName' => 'Altenrhein (CH)',
                'countryCode' => 'CH',
                'type' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'regionCode' => 'AMS',
            'regionName' => 'Amsterdam (NL)',
                'countryCode' => 'NL',
                'type' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'regionCode' => 'BER',
            'regionName' => 'Berlin (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            3 => 
            array (
                'id' => 4,
                'regionCode' => 'BRE',
            'regionName' => 'Bremen (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            4 => 
            array (
                'id' => 5,
                'regionCode' => 'BRN',
            'regionName' => 'Bern (CH)',
                'countryCode' => 'CH',
                'type' => 0,
            ),
            5 => 
            array (
                'id' => 6,
                'regionCode' => 'BRQ',
            'regionName' => 'Brünn (CZ)',
                'countryCode' => 'CZ',
                'type' => 0,
            ),
            6 => 
            array (
                'id' => 7,
                'regionCode' => 'BRV',
            'regionName' => 'Bremerhaven (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            7 => 
            array (
                'id' => 8,
                'regionCode' => 'BSL',
            'regionName' => 'Basel/Mulhouse (CH)',
                'countryCode' => 'CH',
                'type' => 0,
            ),
            8 => 
            array (
                'id' => 9,
                'regionCode' => 'BZG',
            'regionName' => 'Bydgoszcz (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            9 => 
            array (
                'id' => 10,
                'regionCode' => 'CGN',
            'regionName' => 'Köln/Bonn (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            10 => 
            array (
                'id' => 11,
                'regionCode' => 'CSO',
            'regionName' => 'Magdeburg-Cochstedt (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            11 => 
            array (
                'id' => 12,
                'regionCode' => 'DRS',
            'regionName' => 'Dresden (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            12 => 
            array (
                'id' => 13,
                'regionCode' => 'DTM',
            'regionName' => 'Dortmund (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            13 => 
            array (
                'id' => 14,
                'regionCode' => 'DUS',
            'regionName' => 'Düsseldorf (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            14 => 
            array (
                'id' => 15,
                'regionCode' => 'EIN',
            'regionName' => 'Eindhoven (NL)',
                'countryCode' => 'NL',
                'type' => 0,
            ),
            15 => 
            array (
                'id' => 16,
                'regionCode' => 'ERF',
            'regionName' => 'Erfurt (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            16 => 
            array (
                'id' => 17,
                'regionCode' => 'FDH',
            'regionName' => 'Friedrichshafen (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            17 => 
            array (
                'id' => 18,
                'regionCode' => 'FKB',
            'regionName' => 'Karlsruhe/Baden-Baden (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            18 => 
            array (
                'id' => 19,
                'regionCode' => 'FMM',
            'regionName' => 'Memmingen (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            19 => 
            array (
                'id' => 20,
                'regionCode' => 'FMO',
            'regionName' => 'Münster/Osnabrück (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            20 => 
            array (
                'id' => 21,
                'regionCode' => 'FRA',
            'regionName' => 'Frankfurt (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            21 => 
            array (
                'id' => 22,
                'regionCode' => 'GDN',
            'regionName' => 'Danzig (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            22 => 
            array (
                'id' => 23,
                'regionCode' => 'GRQ',
            'regionName' => 'Groningen (NL)',
                'countryCode' => 'NL',
                'type' => 0,
            ),
            23 => 
            array (
                'id' => 24,
                'regionCode' => 'GRZ',
            'regionName' => 'Graz (AT)',
                'countryCode' => 'AT',
                'type' => 0,
            ),
            24 => 
            array (
                'id' => 25,
                'regionCode' => 'GVA',
            'regionName' => 'Genf (CH)',
                'countryCode' => 'CH',
                'type' => 0,
            ),
            25 => 
            array (
                'id' => 26,
                'regionCode' => 'GWT',
            'regionName' => 'Westerland-Sylt (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            26 => 
            array (
                'id' => 27,
                'regionCode' => 'HAJ',
            'regionName' => 'Hannover (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            27 => 
            array (
                'id' => 28,
                'regionCode' => 'HAM',
            'regionName' => 'Hamburg (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            28 => 
            array (
                'id' => 29,
                'regionCode' => 'HDF',
            'regionName' => 'Heringsdorf (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            29 => 
            array (
                'id' => 30,
                'regionCode' => 'HHN',
            'regionName' => 'Frankfurt-Hahn (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            30 => 
            array (
                'id' => 31,
                'regionCode' => 'HOQ',
            'regionName' => 'Hof (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            31 => 
            array (
                'id' => 32,
                'regionCode' => 'IEG',
            'regionName' => 'Zielona Gora (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            32 => 
            array (
                'id' => 33,
                'regionCode' => 'INN',
            'regionName' => 'Innsbruck (AT)',
                'countryCode' => 'AT',
                'type' => 0,
            ),
            33 => 
            array (
                'id' => 34,
                'regionCode' => 'KEL',
            'regionName' => 'Kiel (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            34 => 
            array (
                'id' => 35,
                'regionCode' => 'KLU',
            'regionName' => 'Klagenfurt (AT)',
                'countryCode' => 'AT',
                'type' => 0,
            ),
            35 => 
            array (
                'id' => 36,
                'regionCode' => 'KLV',
            'regionName' => 'Karlsbad (CZ)',
                'countryCode' => 'CZ',
                'type' => 0,
            ),
            36 => 
            array (
                'id' => 37,
                'regionCode' => 'KRK',
            'regionName' => 'Krakau (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            37 => 
            array (
                'id' => 38,
                'regionCode' => 'KSF',
            'regionName' => 'Kassel (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            38 => 
            array (
                'id' => 39,
                'regionCode' => 'KTW',
            'regionName' => 'Kattowitz (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            39 => 
            array (
                'id' => 40,
                'regionCode' => 'LBC',
            'regionName' => 'Lübeck (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            40 => 
            array (
                'id' => 41,
                'regionCode' => 'LCJ',
            'regionName' => 'Lodz (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            41 => 
            array (
                'id' => 42,
                'regionCode' => 'LEJ',
            'regionName' => 'Leipzig/Halle (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            42 => 
            array (
                'id' => 43,
                'regionCode' => 'LEY',
            'regionName' => 'Lelystad (NL)',
                'countryCode' => 'NL',
                'type' => 0,
            ),
            43 => 
            array (
                'id' => 44,
                'regionCode' => 'LNZ',
            'regionName' => 'Linz (AT)',
                'countryCode' => 'AT',
                'type' => 0,
            ),
            44 => 
            array (
                'id' => 45,
                'regionCode' => 'LUG',
            'regionName' => 'Lugano (CH)',
                'countryCode' => 'CH',
                'type' => 0,
            ),
            45 => 
            array (
                'id' => 46,
                'regionCode' => 'MHG',
            'regionName' => 'Mannheim (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            46 => 
            array (
                'id' => 47,
                'regionCode' => 'MST',
            'regionName' => 'Maastricht-Aachen (NL)',
                'countryCode' => 'NL',
                'type' => 0,
            ),
            47 => 
            array (
                'id' => 48,
                'regionCode' => 'MUC',
            'regionName' => 'München (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            48 => 
            array (
                'id' => 49,
                'regionCode' => 'NRN',
            'regionName' => 'Weeze/Niederrhein (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            49 => 
            array (
                'id' => 50,
                'regionCode' => 'NUE',
            'regionName' => 'Nürnberg (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            50 => 
            array (
                'id' => 51,
                'regionCode' => 'OSR',
            'regionName' => 'Ostrava (CZ)',
                'countryCode' => 'CZ',
                'type' => 0,
            ),
            51 => 
            array (
                'id' => 52,
                'regionCode' => 'PAD',
            'regionName' => 'Paderborn (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            52 => 
            array (
                'id' => 53,
                'regionCode' => 'PED',
            'regionName' => 'Pardubice (CZ)',
                'countryCode' => 'CZ',
                'type' => 0,
            ),
            53 => 
            array (
                'id' => 54,
                'regionCode' => 'POZ',
            'regionName' => 'Posen (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            54 => 
            array (
                'id' => 55,
                'regionCode' => 'PRG',
            'regionName' => 'Prag (CZ)',
                'countryCode' => 'CZ',
                'type' => 0,
            ),
            55 => 
            array (
                'id' => 56,
                'regionCode' => 'RLG',
            'regionName' => 'Rostock-Laage (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            56 => 
            array (
                'id' => 57,
                'regionCode' => 'RTM',
            'regionName' => 'Rotterdam (NL)',
                'countryCode' => 'NL',
                'type' => 0,
            ),
            57 => 
            array (
                'id' => 58,
                'regionCode' => 'RZE',
            'regionName' => 'Rzeszow (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            58 => 
            array (
                'id' => 59,
                'regionCode' => 'SCN',
            'regionName' => 'Saarbrücken (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            59 => 
            array (
                'id' => 60,
                'regionCode' => 'STR',
            'regionName' => 'Stuttgart (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            60 => 
            array (
                'id' => 61,
                'regionCode' => 'SXF',
            'regionName' => 'Berlin-Schönefeld (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            61 => 
            array (
                'id' => 62,
                'regionCode' => 'SZG',
            'regionName' => 'Salzburg (AT)',
                'countryCode' => 'AT',
                'type' => 0,
            ),
            62 => 
            array (
                'id' => 63,
                'regionCode' => 'SZZ',
            'regionName' => 'Stettin (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            63 => 
            array (
                'id' => 64,
                'regionCode' => 'TXL',
            'regionName' => 'Berlin-Tegel (DE)',
                'countryCode' => 'DE',
                'type' => 0,
            ),
            64 => 
            array (
                'id' => 65,
                'regionCode' => 'VIE',
            'regionName' => 'Wien (AT)',
                'countryCode' => 'AT',
                'type' => 0,
            ),
            65 => 
            array (
                'id' => 66,
                'regionCode' => 'WAW',
            'regionName' => 'Warschau (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            66 => 
            array (
                'id' => 67,
                'regionCode' => 'WMI',
                'regionName' => 'Warschau',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            67 => 
            array (
                'id' => 68,
                'regionCode' => 'WRO',
            'regionName' => 'Breslau (PL)',
                'countryCode' => 'PL',
                'type' => 0,
            ),
            68 => 
            array (
                'id' => 69,
                'regionCode' => 'ZRH',
            'regionName' => 'Zürich (CH)',
                'countryCode' => 'CH',
                'type' => 0,
            ),
            69 => 
            array (
                'id' => 2296,
                'regionCode' => 'region.8',
                'regionName' => 'Bahamas',
                'countryCode' => '',
                'type' => 1,
            ),
            70 => 
            array (
                'id' => 2297,
                'regionCode' => 'region.9',
                'regionName' => 'Barbados',
                'countryCode' => '',
                'type' => 1,
            ),
            71 => 
            array (
                'id' => 2298,
                'regionCode' => 'region.12',
                'regionName' => 'Brasilien - Amazonasgebiet',
                'countryCode' => '',
                'type' => 1,
            ),
            72 => 
            array (
                'id' => 2299,
                'regionCode' => 'region.12',
                'regionName' => 'Brasilien - Mittelwesten',
                'countryCode' => '',
                'type' => 1,
            ),
            73 => 
            array (
                'id' => 2300,
                'regionCode' => 'region.12',
                'regionName' => 'Brasilien - Nordosten',
                'countryCode' => '',
                'type' => 1,
            ),
            74 => 
            array (
                'id' => 2301,
                'regionCode' => 'region.12',
                'regionName' => 'Brasilien - Recife & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            75 => 
            array (
                'id' => 2302,
                'regionCode' => 'region.12',
                'regionName' => 'Brasilien - Südosten',
                'countryCode' => '',
                'type' => 1,
            ),
            76 => 
            array (
                'id' => 2303,
                'regionCode' => 'region.18',
            'regionName' => 'Dom. Republik Norden (Puerto Plata)',
                'countryCode' => '',
                'type' => 1,
            ),
            77 => 
            array (
                'id' => 2304,
                'regionCode' => 'region.19',
            'regionName' => 'Dom. Republik Osten (Punta Cana)',
                'countryCode' => '',
                'type' => 1,
            ),
            78 => 
            array (
                'id' => 2305,
                'regionCode' => 'region.20',
            'regionName' => 'Dom. Republik Süden (Santo Domingo)',
                'countryCode' => '',
                'type' => 1,
            ),
            79 => 
            array (
                'id' => 2306,
                'regionCode' => 'region.21',
                'regionName' => 'Burgund',
                'countryCode' => '',
                'type' => 1,
            ),
            80 => 
            array (
                'id' => 2307,
                'regionCode' => 'region.21',
                'regionName' => 'Frankreich - Landesinnere',
                'countryCode' => '',
                'type' => 1,
            ),
            81 => 
            array (
                'id' => 2308,
                'regionCode' => 'region.21',
                'regionName' => 'Frenche Comte',
                'countryCode' => '',
                'type' => 1,
            ),
            82 => 
            array (
                'id' => 2309,
                'regionCode' => 'region.21',
                'regionName' => 'Limousin',
                'countryCode' => '',
                'type' => 1,
            ),
            83 => 
            array (
                'id' => 2310,
                'regionCode' => 'region.21',
                'regionName' => 'Midi Pyrenees',
                'countryCode' => '',
                'type' => 1,
            ),
            84 => 
            array (
                'id' => 2311,
                'regionCode' => 'region.21',
                'regionName' => 'Zentralfrankreich',
                'countryCode' => '',
                'type' => 1,
            ),
            85 => 
            array (
                'id' => 2312,
                'regionCode' => 'region.23',
                'regionName' => 'Gambia',
                'countryCode' => '',
                'type' => 1,
            ),
            86 => 
            array (
                'id' => 2313,
                'regionCode' => 'region.24',
                'regionName' => 'Grenada',
                'countryCode' => '',
                'type' => 1,
            ),
            87 => 
            array (
                'id' => 2314,
                'regionCode' => 'region.30',
            'regionName' => 'Attika (Athen & Umgebung)',
                'countryCode' => '',
                'type' => 1,
            ),
            88 => 
            array (
                'id' => 2315,
                'regionCode' => 'region.31',
                'regionName' => 'Chalkidiki',
                'countryCode' => '',
                'type' => 1,
            ),
            89 => 
            array (
                'id' => 2316,
                'regionCode' => 'region.33',
                'regionName' => 'Epirus',
                'countryCode' => '',
                'type' => 1,
            ),
            90 => 
            array (
                'id' => 2317,
                'regionCode' => 'region.34',
            'regionName' => 'Euböa (Evia) & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            91 => 
            array (
                'id' => 2318,
                'regionCode' => 'region.36',
                'regionName' => 'Golf von Korinth',
                'countryCode' => '',
                'type' => 1,
            ),
            92 => 
            array (
                'id' => 2319,
                'regionCode' => 'region.44',
                'regionName' => 'Korfu',
                'countryCode' => '',
                'type' => 1,
            ),
            93 => 
            array (
                'id' => 2320,
                'regionCode' => 'region.45',
                'regionName' => 'Kos',
                'countryCode' => '',
                'type' => 1,
            ),
            94 => 
            array (
                'id' => 2321,
                'regionCode' => 'region.46',
                'regionName' => 'Koufonisi',
                'countryCode' => '',
                'type' => 1,
            ),
            95 => 
            array (
                'id' => 2322,
                'regionCode' => 'region.46',
                'regionName' => 'Kreta',
                'countryCode' => '',
                'type' => 1,
            ),
            96 => 
            array (
                'id' => 2323,
                'regionCode' => 'region.49',
                'regionName' => 'Lesbos',
                'countryCode' => '',
                'type' => 1,
            ),
            97 => 
            array (
                'id' => 2324,
                'regionCode' => 'region.51',
                'regionName' => 'Mykonos',
                'countryCode' => '',
                'type' => 1,
            ),
            98 => 
            array (
                'id' => 2325,
                'regionCode' => 'region.56',
                'regionName' => 'Peloponnes',
                'countryCode' => '',
                'type' => 1,
            ),
            99 => 
            array (
                'id' => 2326,
                'regionCode' => 'region.56',
                'regionName' => 'Westgriechenland',
                'countryCode' => '',
                'type' => 1,
            ),
            100 => 
            array (
                'id' => 2327,
                'regionCode' => 'region.57',
                'regionName' => 'Pilion',
                'countryCode' => '',
                'type' => 1,
            ),
            101 => 
            array (
                'id' => 2328,
                'regionCode' => 'region.59',
                'regionName' => 'Rhodos',
                'countryCode' => '',
                'type' => 1,
            ),
            102 => 
            array (
                'id' => 2329,
                'regionCode' => 'region.62',
                'regionName' => 'Skiathos',
                'countryCode' => '',
                'type' => 1,
            ),
            103 => 
            array (
                'id' => 2330,
                'regionCode' => 'region.68',
                'regionName' => 'Thassos',
                'countryCode' => '',
                'type' => 1,
            ),
            104 => 
            array (
                'id' => 2331,
                'regionCode' => 'region.71',
                'regionName' => 'Zakynthos',
                'countryCode' => '',
                'type' => 1,
            ),
            105 => 
            array (
                'id' => 2332,
                'regionCode' => 'region.74',
                'regionName' => 'Israel - Haifa & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            106 => 
            array (
                'id' => 2333,
                'regionCode' => 'region.76',
                'regionName' => 'Marken',
                'countryCode' => '',
                'type' => 1,
            ),
            107 => 
            array (
                'id' => 2334,
                'regionCode' => 'region.77',
                'regionName' => 'Adria',
                'countryCode' => '',
                'type' => 1,
            ),
            108 => 
            array (
                'id' => 2335,
                'regionCode' => 'region.77',
                'regionName' => 'Molise',
                'countryCode' => '',
                'type' => 1,
            ),
            109 => 
            array (
                'id' => 2336,
                'regionCode' => 'region.78',
                'regionName' => 'Apulien',
                'countryCode' => '',
                'type' => 1,
            ),
            110 => 
            array (
                'id' => 2337,
                'regionCode' => 'region.79',
                'regionName' => 'Oberitalienische Seen - Gardasee',
                'countryCode' => '',
                'type' => 1,
            ),
            111 => 
            array (
                'id' => 2338,
                'regionCode' => 'region.80',
                'regionName' => 'Ischia',
                'countryCode' => '',
                'type' => 1,
            ),
            112 => 
            array (
                'id' => 2339,
                'regionCode' => 'region.82',
            'regionName' => 'Italienische Riviera ( Cinque Terre - San Remo)',
                'countryCode' => '',
                'type' => 1,
            ),
            113 => 
            array (
                'id' => 2340,
                'regionCode' => 'region.83',
                'regionName' => 'Sardinien',
                'countryCode' => '',
                'type' => 1,
            ),
            114 => 
            array (
                'id' => 2341,
                'regionCode' => 'region.84',
                'regionName' => 'Sizilien',
                'countryCode' => '',
                'type' => 1,
            ),
            115 => 
            array (
                'id' => 2342,
                'regionCode' => 'region.87',
                'regionName' => 'Jordanien - Aqaba',
                'countryCode' => '',
                'type' => 1,
            ),
            116 => 
            array (
                'id' => 2343,
                'regionCode' => 'region.88,region.100353',
                'regionName' => 'Kap Verde - Insel Boa Vista',
                'countryCode' => '',
                'type' => 1,
            ),
            117 => 
            array (
                'id' => 2344,
                'regionCode' => 'region.88,region.100353',
                'regionName' => 'Kap Verde - Insel Sal',
                'countryCode' => '',
                'type' => 1,
            ),
            118 => 
            array (
                'id' => 2345,
                'regionCode' => 'region.88,region.100353',
                'regionName' => 'Kap Verde - Insel Santiago & Fogo & Sao Vicente',
                'countryCode' => '',
                'type' => 1,
            ),
            119 => 
            array (
                'id' => 2346,
                'regionCode' => 'region.106',
                'regionName' => 'Tabasco',
                'countryCode' => '',
                'type' => 1,
            ),
            120 => 
            array (
                'id' => 2347,
                'regionCode' => 'region.108',
                'regionName' => 'Oman - Muskat & Salalah',
                'countryCode' => '',
                'type' => 1,
            ),
            121 => 
            array (
                'id' => 2348,
                'regionCode' => 'region.109',
                'regionName' => 'Algarve',
                'countryCode' => '',
                'type' => 1,
            ),
            122 => 
            array (
                'id' => 2349,
                'regionCode' => 'region.109',
                'regionName' => 'Costa Azul',
                'countryCode' => '',
                'type' => 1,
            ),
            123 => 
            array (
                'id' => 2350,
                'regionCode' => 'region.110',
                'regionName' => 'Azoren',
                'countryCode' => '',
                'type' => 1,
            ),
            124 => 
            array (
                'id' => 2351,
                'regionCode' => 'region.111',
                'regionName' => 'Nordportugal',
                'countryCode' => '',
                'type' => 1,
            ),
            125 => 
            array (
                'id' => 2352,
                'regionCode' => 'region.113',
                'regionName' => 'La Reunion',
                'countryCode' => '',
                'type' => 1,
            ),
            126 => 
            array (
                'id' => 2353,
                'regionCode' => 'region.115',
                'regionName' => 'Senegal',
                'countryCode' => '',
                'type' => 1,
            ),
            127 => 
            array (
                'id' => 2354,
                'regionCode' => 'region.116,region.100405',
                'regionName' => 'Seychellen',
                'countryCode' => '',
                'type' => 1,
            ),
            128 => 
            array (
                'id' => 2355,
                'regionCode' => 'region.119',
                'regionName' => 'Spanisches Festland',
                'countryCode' => '',
                'type' => 1,
            ),
            129 => 
            array (
                'id' => 2356,
                'regionCode' => 'region.125',
                'regionName' => 'El Hierro',
                'countryCode' => '',
                'type' => 1,
            ),
            130 => 
            array (
                'id' => 2357,
                'regionCode' => 'region.126',
                'regionName' => 'Formentera',
                'countryCode' => '',
                'type' => 1,
            ),
            131 => 
            array (
                'id' => 2358,
                'regionCode' => 'region.127',
                'regionName' => 'Fuerteventura',
                'countryCode' => '',
                'type' => 1,
            ),
            132 => 
            array (
                'id' => 2359,
                'regionCode' => 'region.128',
                'regionName' => 'Gran Canaria',
                'countryCode' => '',
                'type' => 1,
            ),
            133 => 
            array (
                'id' => 2360,
                'regionCode' => 'region.129',
                'regionName' => 'Ibiza',
                'countryCode' => '',
                'type' => 1,
            ),
            134 => 
            array (
                'id' => 2361,
                'regionCode' => 'region.130',
                'regionName' => 'La Gomera',
                'countryCode' => '',
                'type' => 1,
            ),
            135 => 
            array (
                'id' => 2362,
                'regionCode' => 'region.131',
                'regionName' => 'La Palma',
                'countryCode' => '',
                'type' => 1,
            ),
            136 => 
            array (
                'id' => 2363,
                'regionCode' => 'region.132,region.655',
                'regionName' => 'Lanzarote',
                'countryCode' => '',
                'type' => 1,
            ),
            137 => 
            array (
                'id' => 2364,
                'regionCode' => 'region.133',
                'regionName' => 'Mallorca',
                'countryCode' => '',
                'type' => 1,
            ),
            138 => 
            array (
                'id' => 2365,
                'regionCode' => 'region.134',
                'regionName' => 'Menorca',
                'countryCode' => '',
                'type' => 1,
            ),
            139 => 
            array (
                'id' => 2366,
                'regionCode' => 'region.135',
                'regionName' => 'Teneriffa',
                'countryCode' => '',
                'type' => 1,
            ),
            140 => 
            array (
                'id' => 2367,
                'regionCode' => 'region.136,region.100312',
                'regionName' => 'Sri Lanka',
                'countryCode' => '',
                'type' => 1,
            ),
            141 => 
            array (
                'id' => 2368,
                'regionCode' => 'region.137',
                'regionName' => 'Santa Lucia',
                'countryCode' => '',
                'type' => 1,
            ),
            142 => 
            array (
                'id' => 2369,
                'regionCode' => 'region.138',
                'regionName' => 'Sansibar',
                'countryCode' => '',
                'type' => 1,
            ),
            143 => 
            array (
                'id' => 2370,
                'regionCode' => 'region.139',
                'regionName' => 'Bangkok & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            144 => 
            array (
                'id' => 2371,
                'regionCode' => 'region.140',
            'regionName' => 'Isaan (Nordost-Thailand)',
                'countryCode' => '',
                'type' => 1,
            ),
            145 => 
            array (
                'id' => 2372,
                'regionCode' => 'region.140',
            'regionName' => 'Nordthailand (Chiang Rai & Chiang Mai)',
                'countryCode' => '',
                'type' => 1,
            ),
            146 => 
            array (
                'id' => 2373,
                'regionCode' => 'region.141',
                'regionName' => 'Krabi & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            147 => 
            array (
                'id' => 2374,
                'regionCode' => 'region.142',
                'regionName' => 'Trinidad & Tobago',
                'countryCode' => '',
                'type' => 1,
            ),
            148 => 
            array (
                'id' => 2376,
                'regionCode' => 'region.144',
                'regionName' => 'Dalyan - Dalaman - Fethiye - Kas',
                'countryCode' => '',
                'type' => 1,
            ),
            149 => 
            array (
                'id' => 2377,
                'regionCode' => 'region.144',
                'regionName' => 'Gümüldür - Kusadasi',
                'countryCode' => '',
                'type' => 1,
            ),
            150 => 
            array (
                'id' => 2378,
                'regionCode' => 'region.144',
                'regionName' => 'Marmaris - Sarigerme - Icmeler',
                'countryCode' => '',
                'type' => 1,
            ),
            151 => 
            array (
                'id' => 2379,
                'regionCode' => 'region.147',
                'regionName' => 'Istanbul & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            152 => 
            array (
                'id' => 2380,
                'regionCode' => 'region.148',
                'regionName' => 'Marmarameer',
                'countryCode' => '',
                'type' => 1,
            ),
            153 => 
            array (
                'id' => 2381,
                'regionCode' => 'region.148',
                'regionName' => 'Ost-Thrakien & Marmarameer',
                'countryCode' => '',
                'type' => 1,
            ),
            154 => 
            array (
                'id' => 2383,
                'regionCode' => 'region.149',
                'regionName' => 'Kemer - Beldibi',
                'countryCode' => '',
                'type' => 1,
            ),
            155 => 
            array (
                'id' => 2385,
                'regionCode' => 'region.149',
                'regionName' => 'Türkische Riviera',
                'countryCode' => '',
                'type' => 1,
            ),
            156 => 
            array (
                'id' => 2386,
                'regionCode' => 'region.150',
                'regionName' => 'Djerba & Oase Zarzis',
                'countryCode' => '',
                'type' => 1,
            ),
            157 => 
            array (
                'id' => 2387,
                'regionCode' => 'region.151',
                'regionName' => 'Monastir & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            158 => 
            array (
                'id' => 2388,
                'regionCode' => 'region.154,region.152',
                'regionName' => 'Tunis & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            159 => 
            array (
                'id' => 2389,
                'regionCode' => 'region.155',
                'regionName' => 'Turks- und Caicos-Inseln',
                'countryCode' => '',
                'type' => 1,
            ),
            160 => 
            array (
                'id' => 2390,
                'regionCode' => 'region.604,region.160,region.100235,region.100279',
                'regionName' => 'V.A. Emirate - Dubai',
                'countryCode' => '',
                'type' => 1,
            ),
            161 => 
            array (
                'id' => 2391,
                'regionCode' => 'region.163',
                'regionName' => 'Zypern Süd',
                'countryCode' => '',
                'type' => 1,
            ),
            162 => 
            array (
                'id' => 2392,
                'regionCode' => 'region.163',
                'regionName' => 'Republik Zypern - Süden',
                'countryCode' => '',
                'type' => 1,
            ),
            163 => 
            array (
                'id' => 2393,
                'regionCode' => 'region.178',
                'regionName' => 'Landesinnere',
                'countryCode' => '',
                'type' => 1,
            ),
            164 => 
            array (
                'id' => 2394,
                'regionCode' => 'region.194',
                'regionName' => 'Monaco',
                'countryCode' => '',
                'type' => 1,
            ),
            165 => 
            array (
                'id' => 2395,
                'regionCode' => 'region.194',
                'regionName' => 'Fürstentum Monaco',
                'countryCode' => '',
                'type' => 1,
            ),
            166 => 
            array (
                'id' => 2396,
                'regionCode' => 'region.214',
                'regionName' => 'Luxemburg',
                'countryCode' => '',
                'type' => 1,
            ),
            167 => 
            array (
                'id' => 2397,
                'regionCode' => 'region.225,region.100287',
                'regionName' => 'Singapur',
                'countryCode' => '',
                'type' => 1,
            ),
            168 => 
            array (
                'id' => 2398,
                'regionCode' => 'region.232',
                'regionName' => 'Tschechische Republik - Adlergebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            169 => 
            array (
                'id' => 2399,
                'regionCode' => 'region.232',
                'regionName' => 'Tschechische Republik - Braunauer Bergland',
                'countryCode' => '',
                'type' => 1,
            ),
            170 => 
            array (
                'id' => 2400,
                'regionCode' => 'region.232',
                'regionName' => 'Tschechische Republik - Kaiserwald',
                'countryCode' => '',
                'type' => 1,
            ),
            171 => 
            array (
                'id' => 2401,
                'regionCode' => 'region.232',
                'regionName' => 'Tschechische Republik - Lausitzer Gebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            172 => 
            array (
                'id' => 2402,
                'regionCode' => 'region.232',
                'regionName' => 'Tschechische Republik - Mähren',
                'countryCode' => '',
                'type' => 1,
            ),
            173 => 
            array (
                'id' => 2403,
                'regionCode' => 'region.232',
                'regionName' => 'Tschechische Republik - Westkarpaten',
                'countryCode' => '',
                'type' => 1,
            ),
            174 => 
            array (
                'id' => 2404,
                'regionCode' => 'region.250',
                'regionName' => 'Uri',
                'countryCode' => '',
                'type' => 1,
            ),
            175 => 
            array (
                'id' => 2405,
                'regionCode' => 'region.250',
                'regionName' => 'Vierwaldstätter See & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            176 => 
            array (
                'id' => 2406,
                'regionCode' => 'region.250',
                'regionName' => 'Zentralschweiz',
                'countryCode' => '',
                'type' => 1,
            ),
            177 => 
            array (
                'id' => 2407,
                'regionCode' => 'region.255',
                'regionName' => 'Anguilla',
                'countryCode' => '',
                'type' => 1,
            ),
            178 => 
            array (
                'id' => 2408,
                'regionCode' => 'region.258',
                'regionName' => 'Thessalien',
                'countryCode' => '',
                'type' => 1,
            ),
            179 => 
            array (
                'id' => 2409,
                'regionCode' => 'region.269',
                'regionName' => 'Kenia - Küste',
                'countryCode' => '',
                'type' => 1,
            ),
            180 => 
            array (
                'id' => 2410,
                'regionCode' => 'region.283',
                'regionName' => 'Rom & Latinum',
                'countryCode' => '',
                'type' => 1,
            ),
            181 => 
            array (
                'id' => 2412,
                'regionCode' => 'region.292',
                'regionName' => 'Türkei Inland',
                'countryCode' => '',
                'type' => 1,
            ),
            182 => 
            array (
                'id' => 2413,
                'regionCode' => 'region.308',
                'regionName' => 'Saint Vincent & die Grenadinen',
                'countryCode' => '',
                'type' => 1,
            ),
            183 => 
            array (
                'id' => 2414,
                'regionCode' => 'region.310',
                'regionName' => 'Nothern Territory Darwin & weitere Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            184 => 
            array (
                'id' => 2415,
                'regionCode' => 'region.312',
                'regionName' => 'Tonga',
                'countryCode' => '',
                'type' => 1,
            ),
            185 => 
            array (
                'id' => 2416,
                'regionCode' => 'region.313',
                'regionName' => 'Cook Inseln',
                'countryCode' => '',
                'type' => 1,
            ),
            186 => 
            array (
                'id' => 2417,
                'regionCode' => 'region.316',
                'regionName' => 'Philippinen',
                'countryCode' => '',
                'type' => 1,
            ),
            187 => 
            array (
                'id' => 2418,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Andaman & Nicobar Islands',
                'countryCode' => '',
                'type' => 1,
            ),
            188 => 
            array (
                'id' => 2419,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Andhra Pradesh',
                'countryCode' => '',
                'type' => 1,
            ),
            189 => 
            array (
                'id' => 2420,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Arunachal Pradesh',
                'countryCode' => '',
                'type' => 1,
            ),
            190 => 
            array (
                'id' => 2421,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Assam',
                'countryCode' => '',
                'type' => 1,
            ),
            191 => 
            array (
                'id' => 2422,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Bihar',
                'countryCode' => '',
                'type' => 1,
            ),
            192 => 
            array (
                'id' => 2423,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Chhattisgarh',
                'countryCode' => '',
                'type' => 1,
            ),
            193 => 
            array (
                'id' => 2424,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Dadra & Nagar Haveli',
                'countryCode' => '',
                'type' => 1,
            ),
            194 => 
            array (
                'id' => 2425,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Daman & Diu',
                'countryCode' => '',
                'type' => 1,
            ),
            195 => 
            array (
                'id' => 2426,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Gujarat',
                'countryCode' => '',
                'type' => 1,
            ),
            196 => 
            array (
                'id' => 2427,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Haryana',
                'countryCode' => '',
                'type' => 1,
            ),
            197 => 
            array (
                'id' => 2428,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Himachal Pradesh',
                'countryCode' => '',
                'type' => 1,
            ),
            198 => 
            array (
                'id' => 2429,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Jharkhand',
                'countryCode' => '',
                'type' => 1,
            ),
            199 => 
            array (
                'id' => 2430,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Karnataka',
                'countryCode' => '',
                'type' => 1,
            ),
            200 => 
            array (
                'id' => 2431,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Kashmir & Jammu',
                'countryCode' => '',
                'type' => 1,
            ),
            201 => 
            array (
                'id' => 2432,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Lakshadweep Islands',
                'countryCode' => '',
                'type' => 1,
            ),
            202 => 
            array (
                'id' => 2433,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Madhya Pradesh',
                'countryCode' => '',
                'type' => 1,
            ),
            203 => 
            array (
                'id' => 2434,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Manipur',
                'countryCode' => '',
                'type' => 1,
            ),
            204 => 
            array (
                'id' => 2435,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Meghalaya',
                'countryCode' => '',
                'type' => 1,
            ),
            205 => 
            array (
                'id' => 2436,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Mizoram',
                'countryCode' => '',
                'type' => 1,
            ),
            206 => 
            array (
                'id' => 2437,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Nagaland',
                'countryCode' => '',
                'type' => 1,
            ),
            207 => 
            array (
                'id' => 2438,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Orissa',
                'countryCode' => '',
                'type' => 1,
            ),
            208 => 
            array (
                'id' => 2439,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Punjab',
                'countryCode' => '',
                'type' => 1,
            ),
            209 => 
            array (
                'id' => 2440,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Rajasthan',
                'countryCode' => '',
                'type' => 1,
            ),
            210 => 
            array (
                'id' => 2441,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Sikkim',
                'countryCode' => '',
                'type' => 1,
            ),
            211 => 
            array (
                'id' => 2442,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Tripura',
                'countryCode' => '',
                'type' => 1,
            ),
            212 => 
            array (
                'id' => 2443,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Uttar Pradesh',
                'countryCode' => '',
                'type' => 1,
            ),
            213 => 
            array (
                'id' => 2444,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - Uttarakhand',
                'countryCode' => '',
                'type' => 1,
            ),
            214 => 
            array (
                'id' => 2445,
                'regionCode' => 'region.317',
                'regionName' => 'Indien - West Bengal',
                'countryCode' => '',
                'type' => 1,
            ),
            215 => 
            array (
                'id' => 2446,
                'regionCode' => 'region.319',
                'regionName' => 'Botswana',
                'countryCode' => '',
                'type' => 1,
            ),
            216 => 
            array (
                'id' => 2447,
                'regionCode' => 'region.320',
                'regionName' => 'Simbabwe',
                'countryCode' => '',
                'type' => 1,
            ),
            217 => 
            array (
                'id' => 2448,
                'regionCode' => 'region.320',
                'regionName' => 'Simbabwe - Nationalparks',
                'countryCode' => '',
                'type' => 1,
            ),
            218 => 
            array (
                'id' => 2449,
                'regionCode' => 'region.321,region.100345',
                'regionName' => 'Sambia',
                'countryCode' => '',
                'type' => 1,
            ),
            219 => 
            array (
                'id' => 2450,
                'regionCode' => 'region.323,region.100319',
                'regionName' => 'Vietnam',
                'countryCode' => '',
                'type' => 1,
            ),
            220 => 
            array (
                'id' => 2451,
                'regionCode' => 'region.337,region.100295',
                'regionName' => 'Libanon',
                'countryCode' => '',
                'type' => 1,
            ),
            221 => 
            array (
                'id' => 2452,
                'regionCode' => 'region.340',
                'regionName' => 'Südspitzen Keys',
                'countryCode' => '',
                'type' => 1,
            ),
            222 => 
            array (
                'id' => 2453,
                'regionCode' => 'region.342',
                'regionName' => 'Bermuda',
                'countryCode' => '',
                'type' => 1,
            ),
            223 => 
            array (
                'id' => 2454,
                'regionCode' => 'region.344',
                'regionName' => 'Guadeloupe',
                'countryCode' => '',
                'type' => 1,
            ),
            224 => 
            array (
                'id' => 2455,
                'regionCode' => 'region.346',
                'regionName' => 'Martinique',
                'countryCode' => '',
                'type' => 1,
            ),
            225 => 
            array (
                'id' => 2456,
                'regionCode' => 'region.347',
                'regionName' => 'Puerto Rico',
                'countryCode' => '',
                'type' => 1,
            ),
            226 => 
            array (
                'id' => 2457,
                'regionCode' => 'region.349,region.100281',
                'regionName' => 'Taiwan',
                'countryCode' => '',
                'type' => 1,
            ),
            227 => 
            array (
                'id' => 2458,
                'regionCode' => 'region.350',
                'regionName' => 'Südkorea',
                'countryCode' => '',
                'type' => 1,
            ),
            228 => 
            array (
                'id' => 2459,
                'regionCode' => 'region.352',
                'regionName' => 'Katar',
                'countryCode' => '',
                'type' => 1,
            ),
            229 => 
            array (
                'id' => 2460,
                'regionCode' => 'region.353',
                'regionName' => 'Bahrain',
                'countryCode' => '',
                'type' => 1,
            ),
            230 => 
            array (
                'id' => 2461,
                'regionCode' => 'region.354',
                'regionName' => 'Kambodscha',
                'countryCode' => '',
                'type' => 1,
            ),
            231 => 
            array (
                'id' => 2462,
                'regionCode' => 'region.357',
                'regionName' => 'Laos',
                'countryCode' => '',
                'type' => 1,
            ),
            232 => 
            array (
                'id' => 2463,
                'regionCode' => 'region.360',
                'regionName' => 'Michigan',
                'countryCode' => '',
                'type' => 1,
            ),
            233 => 
            array (
                'id' => 2464,
                'regionCode' => 'region.361',
                'regionName' => 'Wisconsin',
                'countryCode' => '',
                'type' => 1,
            ),
            234 => 
            array (
                'id' => 2465,
                'regionCode' => 'region.362',
                'regionName' => 'Minnesota',
                'countryCode' => '',
                'type' => 1,
            ),
            235 => 
            array (
                'id' => 2466,
                'regionCode' => 'region.363',
                'regionName' => 'North Dakota',
                'countryCode' => '',
                'type' => 1,
            ),
            236 => 
            array (
                'id' => 2467,
                'regionCode' => 'region.364',
                'regionName' => 'South Dakota',
                'countryCode' => '',
                'type' => 1,
            ),
            237 => 
            array (
                'id' => 2468,
                'regionCode' => 'region.365',
                'regionName' => 'Nebraska',
                'countryCode' => '',
                'type' => 1,
            ),
            238 => 
            array (
                'id' => 2469,
                'regionCode' => 'region.366',
                'regionName' => 'Iowa',
                'countryCode' => '',
                'type' => 1,
            ),
            239 => 
            array (
                'id' => 2470,
                'regionCode' => 'region.367',
                'regionName' => 'Illinois',
                'countryCode' => '',
                'type' => 1,
            ),
            240 => 
            array (
                'id' => 2471,
                'regionCode' => 'region.368',
                'regionName' => 'Indiana',
                'countryCode' => '',
                'type' => 1,
            ),
            241 => 
            array (
                'id' => 2472,
                'regionCode' => 'region.369',
                'regionName' => 'Ohio',
                'countryCode' => '',
                'type' => 1,
            ),
            242 => 
            array (
                'id' => 2473,
                'regionCode' => 'region.370',
                'regionName' => 'Kentucky',
                'countryCode' => '',
                'type' => 1,
            ),
            243 => 
            array (
                'id' => 2474,
                'regionCode' => 'region.371',
                'regionName' => 'Missouri',
                'countryCode' => '',
                'type' => 1,
            ),
            244 => 
            array (
                'id' => 2475,
                'regionCode' => 'region.372',
                'regionName' => 'Kansas',
                'countryCode' => '',
                'type' => 1,
            ),
            245 => 
            array (
                'id' => 2476,
                'regionCode' => 'region.373',
                'regionName' => 'Montana',
                'countryCode' => '',
                'type' => 1,
            ),
            246 => 
            array (
                'id' => 2477,
                'regionCode' => 'region.374',
                'regionName' => 'Washington',
                'countryCode' => '',
                'type' => 1,
            ),
            247 => 
            array (
                'id' => 2478,
                'regionCode' => 'region.375',
                'regionName' => 'Oregon',
                'countryCode' => '',
                'type' => 1,
            ),
            248 => 
            array (
                'id' => 2479,
                'regionCode' => 'region.376',
                'regionName' => 'Idaho',
                'countryCode' => '',
                'type' => 1,
            ),
            249 => 
            array (
                'id' => 2480,
                'regionCode' => 'region.377',
                'regionName' => 'Maine',
                'countryCode' => '',
                'type' => 1,
            ),
            250 => 
            array (
                'id' => 2481,
                'regionCode' => 'region.378',
                'regionName' => 'New Hampshire',
                'countryCode' => '',
                'type' => 1,
            ),
            251 => 
            array (
                'id' => 2482,
                'regionCode' => 'region.379',
                'regionName' => 'Vermont',
                'countryCode' => '',
                'type' => 1,
            ),
            252 => 
            array (
                'id' => 2483,
                'regionCode' => 'region.381',
                'regionName' => 'Massachusetts',
                'countryCode' => '',
                'type' => 1,
            ),
            253 => 
            array (
                'id' => 2484,
                'regionCode' => 'region.382',
                'regionName' => 'Rhode Island',
                'countryCode' => '',
                'type' => 1,
            ),
            254 => 
            array (
                'id' => 2485,
                'regionCode' => 'region.383',
                'regionName' => 'Connecticut',
                'countryCode' => '',
                'type' => 1,
            ),
            255 => 
            array (
                'id' => 2486,
                'regionCode' => 'region.385',
                'regionName' => 'Pennsylvania',
                'countryCode' => '',
                'type' => 1,
            ),
            256 => 
            array (
                'id' => 2487,
                'regionCode' => 'region.386',
                'regionName' => 'Delaware',
                'countryCode' => '',
                'type' => 1,
            ),
            257 => 
            array (
                'id' => 2488,
                'regionCode' => 'region.387',
                'regionName' => 'Maryland',
                'countryCode' => '',
                'type' => 1,
            ),
            258 => 
            array (
                'id' => 2489,
                'regionCode' => 'region.388',
                'regionName' => 'Washington D.C.',
                'countryCode' => '',
                'type' => 1,
            ),
            259 => 
            array (
                'id' => 2490,
                'regionCode' => 'region.389',
                'regionName' => 'West Virginia',
                'countryCode' => '',
                'type' => 1,
            ),
            260 => 
            array (
                'id' => 2491,
                'regionCode' => 'region.390',
                'regionName' => 'Virginia',
                'countryCode' => '',
                'type' => 1,
            ),
            261 => 
            array (
                'id' => 2492,
                'regionCode' => 'region.391',
                'regionName' => 'North Carolina',
                'countryCode' => '',
                'type' => 1,
            ),
            262 => 
            array (
                'id' => 2493,
                'regionCode' => 'region.392',
                'regionName' => 'South Carolina',
                'countryCode' => '',
                'type' => 1,
            ),
            263 => 
            array (
                'id' => 2494,
                'regionCode' => 'region.393',
                'regionName' => 'Tennessee',
                'countryCode' => '',
                'type' => 1,
            ),
            264 => 
            array (
                'id' => 2495,
                'regionCode' => 'region.394',
                'regionName' => 'Arkansas',
                'countryCode' => '',
                'type' => 1,
            ),
            265 => 
            array (
                'id' => 2496,
                'regionCode' => 'region.395',
                'regionName' => 'Texas',
                'countryCode' => '',
                'type' => 1,
            ),
            266 => 
            array (
                'id' => 2497,
                'regionCode' => 'region.396',
                'regionName' => 'Louisiana',
                'countryCode' => '',
                'type' => 1,
            ),
            267 => 
            array (
                'id' => 2498,
                'regionCode' => 'region.397',
                'regionName' => 'Mississippi',
                'countryCode' => '',
                'type' => 1,
            ),
            268 => 
            array (
                'id' => 2499,
                'regionCode' => 'region.398',
                'regionName' => 'Alabama',
                'countryCode' => '',
                'type' => 1,
            ),
            269 => 
            array (
                'id' => 2500,
                'regionCode' => 'region.399',
                'regionName' => 'Georgia',
                'countryCode' => '',
                'type' => 1,
            ),
            270 => 
            array (
                'id' => 2501,
                'regionCode' => 'region.401',
                'regionName' => 'Colorado',
                'countryCode' => '',
                'type' => 1,
            ),
            271 => 
            array (
                'id' => 2502,
                'regionCode' => 'region.402',
                'regionName' => 'Utah',
                'countryCode' => '',
                'type' => 1,
            ),
            272 => 
            array (
                'id' => 2503,
                'regionCode' => 'region.403',
                'regionName' => 'Las Vegas',
                'countryCode' => '',
                'type' => 1,
            ),
            273 => 
            array (
                'id' => 2504,
                'regionCode' => 'region.403',
                'regionName' => 'Nevada',
                'countryCode' => '',
                'type' => 1,
            ),
            274 => 
            array (
                'id' => 2505,
                'regionCode' => 'region.403',
                'regionName' => 'Sierra Nevada',
                'countryCode' => '',
                'type' => 1,
            ),
            275 => 
            array (
                'id' => 2506,
                'regionCode' => 'region.404',
                'regionName' => 'USA - Kalifornien',
                'countryCode' => '',
                'type' => 1,
            ),
            276 => 
            array (
                'id' => 2507,
                'regionCode' => 'region.404',
                'regionName' => 'Kalifornien',
                'countryCode' => '',
                'type' => 1,
            ),
            277 => 
            array (
                'id' => 2508,
                'regionCode' => 'region.404',
                'regionName' => 'Los Angeles',
                'countryCode' => '',
                'type' => 1,
            ),
            278 => 
            array (
                'id' => 2509,
                'regionCode' => 'region.404',
                'regionName' => 'San Diego',
                'countryCode' => '',
                'type' => 1,
            ),
            279 => 
            array (
                'id' => 2510,
                'regionCode' => 'region.404',
                'regionName' => 'San Francisco',
                'countryCode' => '',
                'type' => 1,
            ),
            280 => 
            array (
                'id' => 2511,
                'regionCode' => 'region.405',
                'regionName' => 'Arizona',
                'countryCode' => '',
                'type' => 1,
            ),
            281 => 
            array (
                'id' => 2512,
                'regionCode' => 'region.406',
                'regionName' => 'New Mexico',
                'countryCode' => '',
                'type' => 1,
            ),
            282 => 
            array (
                'id' => 2513,
                'regionCode' => 'region.408',
                'regionName' => 'USA - Hawaii',
                'countryCode' => '',
                'type' => 1,
            ),
            283 => 
            array (
                'id' => 2514,
                'regionCode' => 'region.408',
                'regionName' => 'Big Island',
                'countryCode' => '',
                'type' => 1,
            ),
            284 => 
            array (
                'id' => 2515,
                'regionCode' => 'region.408',
                'regionName' => 'Kauai',
                'countryCode' => '',
                'type' => 1,
            ),
            285 => 
            array (
                'id' => 2516,
                'regionCode' => 'region.408',
                'regionName' => 'Lanai',
                'countryCode' => '',
                'type' => 1,
            ),
            286 => 
            array (
                'id' => 2517,
                'regionCode' => 'region.408',
                'regionName' => 'Maui',
                'countryCode' => '',
                'type' => 1,
            ),
            287 => 
            array (
                'id' => 2518,
                'regionCode' => 'region.408',
                'regionName' => 'Molokai',
                'countryCode' => '',
                'type' => 1,
            ),
            288 => 
            array (
                'id' => 2519,
                'regionCode' => 'region.408',
            'regionName' => 'Oahu (Honolulu)',
                'countryCode' => '',
                'type' => 1,
            ),
            289 => 
            array (
                'id' => 2520,
                'regionCode' => 'region.409',
                'regionName' => 'Wyoming',
                'countryCode' => '',
                'type' => 1,
            ),
            290 => 
            array (
                'id' => 2521,
                'regionCode' => 'region.410',
                'regionName' => 'Oklahoma',
                'countryCode' => '',
                'type' => 1,
            ),
            291 => 
            array (
                'id' => 2522,
                'regionCode' => 'region.430,region.100355',
                'regionName' => 'Nepal - Kathmandu & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            292 => 
            array (
                'id' => 2523,
                'regionCode' => 'region.431,region.100321',
                'regionName' => 'Myanmar',
                'countryCode' => '',
                'type' => 1,
            ),
            293 => 
            array (
                'id' => 2524,
                'regionCode' => 'region.433',
                'regionName' => 'Emilia Romagna',
                'countryCode' => '',
                'type' => 1,
            ),
            294 => 
            array (
                'id' => 2525,
                'regionCode' => 'region.437,region.100261',
                'regionName' => 'Venetien',
                'countryCode' => '',
                'type' => 1,
            ),
            295 => 
            array (
                'id' => 2526,
                'regionCode' => 'region.440',
                'regionName' => 'Basilikata',
                'countryCode' => '',
                'type' => 1,
            ),
            296 => 
            array (
                'id' => 2527,
                'regionCode' => 'region.442',
                'regionName' => 'Belize',
                'countryCode' => '',
                'type' => 1,
            ),
            297 => 
            array (
                'id' => 2528,
                'regionCode' => 'region.443,region.100156',
                'regionName' => 'Guatemala',
                'countryCode' => '',
                'type' => 1,
            ),
            298 => 
            array (
                'id' => 2529,
                'regionCode' => 'region.444',
                'regionName' => 'Nicaragua',
                'countryCode' => '',
                'type' => 1,
            ),
            299 => 
            array (
                'id' => 2530,
                'regionCode' => 'region.445',
                'regionName' => 'Honduras',
                'countryCode' => '',
                'type' => 1,
            ),
            300 => 
            array (
                'id' => 2531,
                'regionCode' => 'region.447',
                'regionName' => 'Kolumbien',
                'countryCode' => '',
                'type' => 1,
            ),
            301 => 
            array (
                'id' => 2532,
                'regionCode' => 'region.448,region.100326',
                'regionName' => 'Ecuador',
                'countryCode' => '',
                'type' => 1,
            ),
            302 => 
            array (
                'id' => 2533,
                'regionCode' => 'region.450',
                'regionName' => 'Peru',
                'countryCode' => '',
                'type' => 1,
            ),
            303 => 
            array (
                'id' => 2534,
                'regionCode' => 'region.451',
                'regionName' => 'Bolivien',
                'countryCode' => '',
                'type' => 1,
            ),
            304 => 
            array (
                'id' => 2535,
                'regionCode' => 'region.473',
                'regionName' => 'Estland',
                'countryCode' => '',
                'type' => 1,
            ),
            305 => 
            array (
                'id' => 2536,
                'regionCode' => 'region.479',
                'regionName' => 'Lettland',
                'countryCode' => '',
                'type' => 1,
            ),
            306 => 
            array (
                'id' => 2537,
                'regionCode' => 'region.480',
                'regionName' => 'Litauen',
                'countryCode' => '',
                'type' => 1,
            ),
            307 => 
            array (
                'id' => 2538,
                'regionCode' => 'region.483',
                'regionName' => 'Andorra',
                'countryCode' => '',
                'type' => 1,
            ),
            308 => 
            array (
                'id' => 2539,
                'regionCode' => 'region.483',
                'regionName' => 'Fürstentum Andorra',
                'countryCode' => '',
                'type' => 1,
            ),
            309 => 
            array (
                'id' => 2540,
                'regionCode' => 'region.484',
                'regionName' => 'Elfenbeinküste',
                'countryCode' => '',
                'type' => 1,
            ),
            310 => 
            array (
                'id' => 2541,
                'regionCode' => 'region.485',
                'regionName' => 'Samoa',
                'countryCode' => '',
                'type' => 1,
            ),
            311 => 
            array (
                'id' => 2542,
                'regionCode' => 'region.486',
                'regionName' => 'Kuwait',
                'countryCode' => '',
                'type' => 1,
            ),
            312 => 
            array (
                'id' => 2543,
                'regionCode' => 'region.487',
                'regionName' => 'Saint Kitts & Nevis',
                'countryCode' => '',
                'type' => 1,
            ),
            313 => 
            array (
                'id' => 2544,
                'regionCode' => 'region.488',
                'regionName' => 'Äthiopien',
                'countryCode' => '',
                'type' => 1,
            ),
            314 => 
            array (
                'id' => 2545,
                'regionCode' => 'region.491',
                'regionName' => 'Vorarlberg',
                'countryCode' => '',
                'type' => 1,
            ),
            315 => 
            array (
                'id' => 2546,
                'regionCode' => 'region.492,region.100090',
                'regionName' => 'Salzburger Land',
                'countryCode' => '',
                'type' => 1,
            ),
            316 => 
            array (
                'id' => 2547,
                'regionCode' => 'region.493',
                'regionName' => 'Oberösterreich',
                'countryCode' => '',
                'type' => 1,
            ),
            317 => 
            array (
                'id' => 2548,
                'regionCode' => 'region.494',
                'regionName' => 'Steiermark',
                'countryCode' => '',
                'type' => 1,
            ),
            318 => 
            array (
                'id' => 2549,
                'regionCode' => 'region.495',
                'regionName' => 'Kärnten',
                'countryCode' => '',
                'type' => 1,
            ),
            319 => 
            array (
                'id' => 2550,
                'regionCode' => 'region.496',
                'regionName' => 'Burgenland',
                'countryCode' => '',
                'type' => 1,
            ),
            320 => 
            array (
                'id' => 2551,
                'regionCode' => 'region.497',
                'regionName' => 'Wallis',
                'countryCode' => '',
                'type' => 1,
            ),
            321 => 
            array (
                'id' => 2552,
                'regionCode' => 'region.498',
                'regionName' => 'Graubünden',
                'countryCode' => '',
                'type' => 1,
            ),
            322 => 
            array (
                'id' => 2553,
                'regionCode' => 'region.499',
                'regionName' => 'Bern & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            323 => 
            array (
                'id' => 2554,
                'regionCode' => 'region.500',
                'regionName' => 'Heidiland',
                'countryCode' => '',
                'type' => 1,
            ),
            324 => 
            array (
                'id' => 2555,
                'regionCode' => 'region.500',
                'regionName' => 'Ostschweiz',
                'countryCode' => '',
                'type' => 1,
            ),
            325 => 
            array (
                'id' => 2556,
                'regionCode' => 'region.500',
                'regionName' => 'Schaffhausen',
                'countryCode' => '',
                'type' => 1,
            ),
            326 => 
            array (
                'id' => 2557,
                'regionCode' => 'region.500',
                'regionName' => 'Thurgau',
                'countryCode' => '',
                'type' => 1,
            ),
            327 => 
            array (
                'id' => 2558,
                'regionCode' => 'region.501',
                'regionName' => 'Tessin',
                'countryCode' => '',
                'type' => 1,
            ),
            328 => 
            array (
                'id' => 2559,
                'regionCode' => 'region.504',
                'regionName' => 'Pays de la Loire',
                'countryCode' => '',
                'type' => 1,
            ),
            329 => 
            array (
                'id' => 2560,
                'regionCode' => 'region.504',
                'regionName' => 'Poitou Charentes',
                'countryCode' => '',
                'type' => 1,
            ),
            330 => 
            array (
                'id' => 2561,
                'regionCode' => 'region.505',
                'regionName' => 'Korsika',
                'countryCode' => '',
                'type' => 1,
            ),
            331 => 
            array (
                'id' => 2562,
                'regionCode' => 'region.507',
                'regionName' => 'Mittelmeerküste weitere Angebote',
                'countryCode' => '',
                'type' => 1,
            ),
            332 => 
            array (
                'id' => 2563,
                'regionCode' => 'region.518',
                'regionName' => 'Alberta',
                'countryCode' => '',
                'type' => 1,
            ),
            333 => 
            array (
                'id' => 2564,
                'regionCode' => 'region.519',
                'regionName' => 'British Columbia',
                'countryCode' => '',
                'type' => 1,
            ),
            334 => 
            array (
                'id' => 2565,
                'regionCode' => 'region.520',
                'regionName' => 'Manitoba',
                'countryCode' => '',
                'type' => 1,
            ),
            335 => 
            array (
                'id' => 2566,
                'regionCode' => 'region.521',
                'regionName' => 'New Brunswick',
                'countryCode' => '',
                'type' => 1,
            ),
            336 => 
            array (
                'id' => 2567,
                'regionCode' => 'region.522,region.528',
                'regionName' => 'Ontario',
                'countryCode' => '',
                'type' => 1,
            ),
            337 => 
            array (
                'id' => 2568,
                'regionCode' => 'region.523',
                'regionName' => 'Prince Edward Island',
                'countryCode' => '',
                'type' => 1,
            ),
            338 => 
            array (
                'id' => 2569,
                'regionCode' => 'region.524',
                'regionName' => 'Quebec',
                'countryCode' => '',
                'type' => 1,
            ),
            339 => 
            array (
                'id' => 2570,
                'regionCode' => 'region.525',
                'regionName' => 'Saskatchewan',
                'countryCode' => '',
                'type' => 1,
            ),
            340 => 
            array (
                'id' => 2571,
                'regionCode' => 'region.526',
                'regionName' => 'Yukon',
                'countryCode' => '',
                'type' => 1,
            ),
            341 => 
            array (
                'id' => 2572,
                'regionCode' => 'region.527',
                'regionName' => 'Nova Scotia',
                'countryCode' => '',
                'type' => 1,
            ),
            342 => 
            array (
                'id' => 2573,
                'regionCode' => 'region.559',
                'regionName' => 'Schwarzmeerküste',
                'countryCode' => '',
                'type' => 1,
            ),
            343 => 
            array (
                'id' => 2574,
                'regionCode' => 'region.559',
                'regionName' => 'Schwarzmeerküste Türkei',
                'countryCode' => '',
                'type' => 1,
            ),
            344 => 
            array (
                'id' => 2575,
                'regionCode' => 'region.560,region.1031',
                'regionName' => 'Hurghada - Safaga - El Gouna',
                'countryCode' => '',
                'type' => 1,
            ),
            345 => 
            array (
                'id' => 2576,
                'regionCode' => 'region.561',
                'regionName' => 'Sharm El Sheikh - Taba - Dahab',
                'countryCode' => '',
                'type' => 1,
            ),
            346 => 
            array (
                'id' => 2577,
                'regionCode' => 'region.564',
                'regionName' => 'Madagaskar',
                'countryCode' => '',
                'type' => 1,
            ),
            347 => 
            array (
                'id' => 2578,
                'regionCode' => 'region.565,region.100387',
                'regionName' => 'Syrien',
                'countryCode' => '',
                'type' => 1,
            ),
            348 => 
            array (
                'id' => 2579,
                'regionCode' => 'region.568',
                'regionName' => 'Neufundland',
                'countryCode' => '',
                'type' => 1,
            ),
            349 => 
            array (
                'id' => 2580,
                'regionCode' => 'region.571',
                'regionName' => 'USA',
                'countryCode' => '',
                'type' => 1,
            ),
            350 => 
            array (
                'id' => 2581,
                'regionCode' => 'region.572',
                'regionName' => 'Österreich',
                'countryCode' => '',
                'type' => 1,
            ),
            351 => 
            array (
                'id' => 2582,
                'regionCode' => 'region.574',
                'regionName' => 'Alpen',
                'countryCode' => '',
                'type' => 1,
            ),
            352 => 
            array (
                'id' => 2583,
                'regionCode' => 'region.574',
                'regionName' => 'Genfersee & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            353 => 
            array (
                'id' => 2584,
                'regionCode' => 'region.574',
                'regionName' => 'Jura Gebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            354 => 
            array (
                'id' => 2585,
                'regionCode' => 'region.577',
                'regionName' => 'Brunei',
                'countryCode' => '',
                'type' => 1,
            ),
            355 => 
            array (
                'id' => 2586,
                'regionCode' => 'region.578,region.100318',
                'regionName' => 'Usbekistan',
                'countryCode' => '',
                'type' => 1,
            ),
            356 => 
            array (
                'id' => 2587,
                'regionCode' => 'region.582,region.100335',
                'regionName' => 'Iran',
                'countryCode' => '',
                'type' => 1,
            ),
            357 => 
            array (
                'id' => 2588,
                'regionCode' => 'region.583',
                'regionName' => 'Jemen',
                'countryCode' => '',
                'type' => 1,
            ),
            358 => 
            array (
                'id' => 2589,
                'regionCode' => 'region.591',
                'regionName' => 'Andalusien',
                'countryCode' => '',
                'type' => 1,
            ),
            359 => 
            array (
                'id' => 2590,
                'regionCode' => 'region.592',
                'regionName' => 'Kanada',
                'countryCode' => '',
                'type' => 1,
            ),
            360 => 
            array (
                'id' => 2591,
                'regionCode' => 'region.597',
                'regionName' => 'Queensland Brisbane & weitere Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            361 => 
            array (
                'id' => 2592,
                'regionCode' => 'region.598',
                'regionName' => 'New South Wales Sydney & weitere Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            362 => 
            array (
                'id' => 2593,
                'regionCode' => 'region.599',
                'regionName' => 'Victoria  Melborne & weitere Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            363 => 
            array (
                'id' => 2594,
                'regionCode' => 'region.600',
                'regionName' => 'Tasmanien Hobart & weitere Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            364 => 
            array (
                'id' => 2595,
                'regionCode' => 'region.601',
                'regionName' => 'South Australia Adelaide & weiter Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            365 => 
            array (
                'id' => 2596,
                'regionCode' => 'region.602',
                'regionName' => 'Western Australia Perth & weitere  Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            366 => 
            array (
                'id' => 2597,
                'regionCode' => 'region.604',
                'regionName' => 'V.A. Emirate - Abu Dhabi',
                'countryCode' => '',
                'type' => 1,
            ),
            367 => 
            array (
                'id' => 2598,
                'regionCode' => 'region.607',
                'regionName' => 'V.A. Emirate - Umm Al Quwain',
                'countryCode' => '',
                'type' => 1,
            ),
            368 => 
            array (
                'id' => 2599,
                'regionCode' => 'region.608',
                'regionName' => 'V.A. Emirate - Ras Al Khaimah',
                'countryCode' => '',
                'type' => 1,
            ),
            369 => 
            array (
                'id' => 2600,
                'regionCode' => 'region.609',
                'regionName' => 'V.A. Emirate - Fujairah',
                'countryCode' => '',
                'type' => 1,
            ),
            370 => 
            array (
                'id' => 2601,
                'regionCode' => 'region.614',
                'regionName' => 'Ligurien',
                'countryCode' => '',
                'type' => 1,
            ),
            371 => 
            array (
                'id' => 2602,
                'regionCode' => 'region.615',
                'regionName' => 'Bayerische Alpen',
                'countryCode' => '',
                'type' => 1,
            ),
            372 => 
            array (
                'id' => 2603,
                'regionCode' => 'region.615',
                'regionName' => 'Berchtesgadener Land',
                'countryCode' => '',
                'type' => 1,
            ),
            373 => 
            array (
                'id' => 2604,
                'regionCode' => 'region.615,region.100068',
                'regionName' => 'Niederbayern',
                'countryCode' => '',
                'type' => 1,
            ),
            374 => 
            array (
                'id' => 2605,
                'regionCode' => 'region.616',
                'regionName' => 'Baden-Württemberg',
                'countryCode' => '',
                'type' => 1,
            ),
            375 => 
            array (
                'id' => 2606,
                'regionCode' => 'region.616',
                'regionName' => 'Baden-Württemberg',
                'countryCode' => '',
                'type' => 1,
            ),
            376 => 
            array (
                'id' => 2607,
                'regionCode' => 'region.617',
                'regionName' => 'Münsterland',
                'countryCode' => '',
                'type' => 1,
            ),
            377 => 
            array (
                'id' => 2608,
                'regionCode' => 'region.617',
                'regionName' => 'Nordrhein-Westfalen',
                'countryCode' => '',
                'type' => 1,
            ),
            378 => 
            array (
                'id' => 2610,
                'regionCode' => 'region.619',
                'regionName' => 'Berlin',
                'countryCode' => '',
                'type' => 1,
            ),
            379 => 
            array (
                'id' => 2611,
                'regionCode' => 'region.619',
                'regionName' => 'Brandenburg',
                'countryCode' => '',
                'type' => 1,
            ),
            380 => 
            array (
                'id' => 2612,
                'regionCode' => 'region.619',
                'regionName' => 'Berlin',
                'countryCode' => '',
                'type' => 1,
            ),
            381 => 
            array (
                'id' => 2614,
                'regionCode' => 'region.622',
                'regionName' => 'Hessen',
                'countryCode' => '',
                'type' => 1,
            ),
            382 => 
            array (
                'id' => 2617,
                'regionCode' => 'region.626',
                'regionName' => 'Ruhrgebiet',
                'countryCode' => '',
                'type' => 1,
            ),
            383 => 
            array (
                'id' => 2619,
                'regionCode' => 'region.626',
                'regionName' => 'Saarland',
                'countryCode' => '',
                'type' => 1,
            ),
            384 => 
            array (
                'id' => 2621,
                'regionCode' => 'region.627,region.100067',
                'regionName' => 'Sachsen',
                'countryCode' => '',
                'type' => 1,
            ),
            385 => 
            array (
                'id' => 2623,
                'regionCode' => 'region.628',
                'regionName' => 'Sachsen-Anhalt',
                'countryCode' => '',
                'type' => 1,
            ),
            386 => 
            array (
                'id' => 2625,
                'regionCode' => 'region.629',
                'regionName' => 'Schleswig-Holstein',
                'countryCode' => '',
                'type' => 1,
            ),
            387 => 
            array (
                'id' => 2628,
                'regionCode' => 'region.630',
                'regionName' => 'Thüringen und Thüringer Wald',
                'countryCode' => '',
                'type' => 1,
            ),
            388 => 
            array (
                'id' => 2629,
                'regionCode' => 'region.634',
                'regionName' => 'Frankreich',
                'countryCode' => '',
                'type' => 1,
            ),
            389 => 
            array (
                'id' => 2630,
                'regionCode' => 'region.635',
                'regionName' => 'Bretagne',
                'countryCode' => '',
                'type' => 1,
            ),
            390 => 
            array (
                'id' => 2631,
                'regionCode' => 'region.636',
                'regionName' => 'Nordfrankreich',
                'countryCode' => '',
                'type' => 1,
            ),
            391 => 
            array (
                'id' => 2632,
                'regionCode' => 'region.637',
                'regionName' => 'Nordzypern',
                'countryCode' => '',
                'type' => 1,
            ),
            392 => 
            array (
                'id' => 2633,
                'regionCode' => 'region.637',
                'regionName' => 'Zypern Nord',
                'countryCode' => '',
                'type' => 1,
            ),
            393 => 
            array (
                'id' => 2634,
                'regionCode' => 'region.644',
                'regionName' => 'Südafrika - Nationalparks',
                'countryCode' => '',
                'type' => 1,
            ),
            394 => 
            array (
                'id' => 2635,
                'regionCode' => 'region.645',
                'regionName' => 'Südafrika  - Durban & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            395 => 
            array (
                'id' => 2636,
                'regionCode' => 'region.646',
                'regionName' => 'Südafrika - Westküste',
                'countryCode' => '',
                'type' => 1,
            ),
            396 => 
            array (
                'id' => 2637,
                'regionCode' => 'region.647',
                'regionName' => 'Südafrika - Landesinnere',
                'countryCode' => '',
                'type' => 1,
            ),
            397 => 
            array (
                'id' => 2638,
                'regionCode' => 'region.648',
                'regionName' => 'Swasiland',
                'countryCode' => '',
                'type' => 1,
            ),
            398 => 
            array (
                'id' => 2639,
                'regionCode' => 'region.649',
                'regionName' => 'Lesotho',
                'countryCode' => '',
                'type' => 1,
            ),
            399 => 
            array (
                'id' => 2640,
                'regionCode' => 'region.651',
                'regionName' => 'Ägypten',
                'countryCode' => '',
                'type' => 1,
            ),
            400 => 
            array (
                'id' => 2641,
                'regionCode' => 'region.653',
                'regionName' => 'Alentejo',
                'countryCode' => '',
                'type' => 1,
            ),
            401 => 
            array (
                'id' => 2642,
                'regionCode' => 'region.654,region.112',
                'regionName' => 'Madeira - Porto Santo',
                'countryCode' => '',
                'type' => 1,
            ),
            402 => 
            array (
                'id' => 2643,
                'regionCode' => 'region.655',
                'regionName' => 'La Graciosa',
                'countryCode' => '',
                'type' => 1,
            ),
            403 => 
            array (
                'id' => 2644,
                'regionCode' => 'region.659',
                'regionName' => 'Brac & Süddalmatische Inseln',
                'countryCode' => '',
                'type' => 1,
            ),
            404 => 
            array (
                'id' => 2645,
                'regionCode' => 'region.659',
                'regionName' => 'Dalmatien',
                'countryCode' => '',
                'type' => 1,
            ),
            405 => 
            array (
                'id' => 2646,
                'regionCode' => 'region.676',
                'regionName' => 'Dom. Republik Halbinsel Samana',
                'countryCode' => '',
                'type' => 1,
            ),
            406 => 
            array (
                'id' => 2647,
                'regionCode' => 'region.682',
                'regionName' => 'China - Innere Mongolei',
                'countryCode' => '',
                'type' => 1,
            ),
            407 => 
            array (
                'id' => 2648,
                'regionCode' => 'region.682',
                'regionName' => 'Mongolei',
                'countryCode' => '',
                'type' => 1,
            ),
            408 => 
            array (
                'id' => 2649,
                'regionCode' => 'region.700',
                'regionName' => 'Niederösterreich',
                'countryCode' => '',
                'type' => 1,
            ),
            409 => 
            array (
                'id' => 2650,
                'regionCode' => 'region.701',
                'regionName' => 'Wien & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            410 => 
            array (
                'id' => 2651,
                'regionCode' => 'region.704',
                'regionName' => 'Golf von Almeria',
                'countryCode' => '',
                'type' => 1,
            ),
            411 => 
            array (
                'id' => 2652,
                'regionCode' => 'region.705',
                'regionName' => 'Luzern & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            412 => 
            array (
                'id' => 2653,
                'regionCode' => 'region.707',
                'regionName' => 'Costa Blanca & Costa Calida',
                'countryCode' => '',
                'type' => 1,
            ),
            413 => 
            array (
                'id' => 2654,
                'regionCode' => 'region.708',
                'regionName' => 'Costa Dorada',
                'countryCode' => '',
                'type' => 1,
            ),
            414 => 
            array (
                'id' => 2655,
                'regionCode' => 'region.710',
                'regionName' => 'Dom. Republik',
                'countryCode' => '',
                'type' => 1,
            ),
            415 => 
            array (
                'id' => 2656,
                'regionCode' => 'region.714',
                'regionName' => 'Nordwest Terretorien',
                'countryCode' => '',
                'type' => 1,
            ),
            416 => 
            array (
                'id' => 2657,
                'regionCode' => 'region.720',
                'regionName' => 'Katalonien',
                'countryCode' => '',
                'type' => 1,
            ),
            417 => 
            array (
                'id' => 2658,
                'regionCode' => 'region.721',
                'regionName' => 'Tschechische Republik - Riesengebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            418 => 
            array (
                'id' => 2659,
                'regionCode' => 'region.723',
                'regionName' => 'San Marino',
                'countryCode' => '',
                'type' => 1,
            ),
            419 => 
            array (
                'id' => 2660,
                'regionCode' => 'region.723',
                'regionName' => 'Republik San Marino',
                'countryCode' => '',
                'type' => 1,
            ),
            420 => 
            array (
                'id' => 2661,
                'regionCode' => 'region.724,region.292',
                'regionName' => 'Türkei',
                'countryCode' => '',
                'type' => 1,
            ),
            421 => 
            array (
                'id' => 2662,
                'regionCode' => 'region.725',
                'regionName' => 'Portugal',
                'countryCode' => '',
                'type' => 1,
            ),
            422 => 
            array (
                'id' => 2663,
                'regionCode' => 'region.727',
                'regionName' => 'Papua Neuguinea',
                'countryCode' => '',
                'type' => 1,
            ),
            423 => 
            array (
                'id' => 2664,
                'regionCode' => 'region.728',
                'regionName' => 'Föderierte Staaten von Mikronesien',
                'countryCode' => '',
                'type' => 1,
            ),
            424 => 
            array (
                'id' => 2665,
                'regionCode' => 'region.733',
                'regionName' => 'Costa del Azahar',
                'countryCode' => '',
                'type' => 1,
            ),
            425 => 
            array (
                'id' => 2666,
                'regionCode' => 'region.735',
                'regionName' => 'Costa de la Luz',
                'countryCode' => '',
                'type' => 1,
            ),
            426 => 
            array (
                'id' => 2667,
                'regionCode' => 'region.736',
                'regionName' => 'Costa del Sol & Costa Tropical',
                'countryCode' => '',
                'type' => 1,
            ),
            427 => 
            array (
                'id' => 2668,
                'regionCode' => 'region.737',
                'regionName' => 'Murcia',
                'countryCode' => '',
                'type' => 1,
            ),
            428 => 
            array (
                'id' => 2669,
                'regionCode' => 'region.741',
                'regionName' => 'Aragonien',
                'countryCode' => '',
                'type' => 1,
            ),
            429 => 
            array (
                'id' => 2670,
                'regionCode' => 'region.743',
                'regionName' => 'Bulgarien',
                'countryCode' => '',
                'type' => 1,
            ),
            430 => 
            array (
                'id' => 2671,
                'regionCode' => 'region.744',
                'regionName' => 'Schweiz',
                'countryCode' => '',
                'type' => 1,
            ),
            431 => 
            array (
                'id' => 2672,
                'regionCode' => 'region.745',
                'regionName' => 'Griechenland Festland',
                'countryCode' => '',
                'type' => 1,
            ),
            432 => 
            array (
                'id' => 2673,
                'regionCode' => 'region.751',
                'regionName' => 'Pyrenäen Frankreich',
                'countryCode' => '',
                'type' => 1,
            ),
            433 => 
            array (
                'id' => 2674,
                'regionCode' => 'region.752',
                'regionName' => 'Provence',
                'countryCode' => '',
                'type' => 1,
            ),
            434 => 
            array (
                'id' => 2675,
                'regionCode' => 'region.753',
                'regionName' => 'Languedoc Roussillon',
                'countryCode' => '',
                'type' => 1,
            ),
            435 => 
            array (
                'id' => 2676,
                'regionCode' => 'region.754',
                'regionName' => 'Normandie',
                'countryCode' => '',
                'type' => 1,
            ),
            436 => 
            array (
                'id' => 2677,
                'regionCode' => 'region.755',
                'regionName' => 'Elsass - Lothringen',
                'countryCode' => '',
                'type' => 1,
            ),
            437 => 
            array (
                'id' => 2678,
                'regionCode' => 'region.770',
                'regionName' => 'Ghana',
                'countryCode' => '',
                'type' => 1,
            ),
            438 => 
            array (
                'id' => 2679,
                'regionCode' => 'region.797',
                'regionName' => 'Polen Masuren',
                'countryCode' => '',
                'type' => 1,
            ),
            439 => 
            array (
                'id' => 2680,
                'regionCode' => 'region.799',
                'regionName' => 'Grönland',
                'countryCode' => '',
                'type' => 1,
            ),
            440 => 
            array (
                'id' => 2681,
                'regionCode' => 'region.800,region.802',
                'regionName' => 'Schottland',
                'countryCode' => '',
                'type' => 1,
            ),
            441 => 
            array (
                'id' => 2682,
                'regionCode' => 'region.801',
                'regionName' => 'Wales',
                'countryCode' => '',
                'type' => 1,
            ),
            442 => 
            array (
                'id' => 2683,
                'regionCode' => 'region.803',
                'regionName' => 'Mosambik',
                'countryCode' => '',
                'type' => 1,
            ),
            443 => 
            array (
                'id' => 2684,
                'regionCode' => 'region.804',
                'regionName' => 'Malawi',
                'countryCode' => '',
                'type' => 1,
            ),
            444 => 
            array (
                'id' => 2685,
                'regionCode' => 'region.812',
                'regionName' => 'Venezuela - Isla Margarita',
                'countryCode' => '',
                'type' => 1,
            ),
            445 => 
            array (
                'id' => 2686,
                'regionCode' => 'region.813',
                'regionName' => 'Dominica',
                'countryCode' => '',
                'type' => 1,
            ),
            446 => 
            array (
                'id' => 2687,
                'regionCode' => 'region.817',
                'regionName' => 'Kasachstan',
                'countryCode' => '',
                'type' => 1,
            ),
            447 => 
            array (
                'id' => 2688,
                'regionCode' => 'region.819',
                'regionName' => 'Hammamet & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            448 => 
            array (
                'id' => 2689,
                'regionCode' => 'region.820',
                'regionName' => 'Liechtenstein',
                'countryCode' => '',
                'type' => 1,
            ),
            449 => 
            array (
                'id' => 2690,
                'regionCode' => 'region.820',
                'regionName' => 'Fürstentum Liechtenstein',
                'countryCode' => '',
                'type' => 1,
            ),
            450 => 
            array (
                'id' => 2691,
                'regionCode' => 'region.833',
                'regionName' => 'Makedonien',
                'countryCode' => '',
                'type' => 1,
            ),
            451 => 
            array (
                'id' => 2692,
                'regionCode' => 'region.835',
                'regionName' => 'Loire Tal',
                'countryCode' => '',
                'type' => 1,
            ),
            452 => 
            array (
                'id' => 2693,
                'regionCode' => 'region.838',
                'regionName' => 'Neukaledonien',
                'countryCode' => '',
                'type' => 1,
            ),
            453 => 
            array (
                'id' => 2694,
                'regionCode' => 'region.844',
                'regionName' => 'Komoren',
                'countryCode' => '',
                'type' => 1,
            ),
            454 => 
            array (
                'id' => 2695,
                'regionCode' => 'region.850',
                'regionName' => 'Girona',
                'countryCode' => '',
                'type' => 1,
            ),
            455 => 
            array (
                'id' => 2696,
                'regionCode' => 'region.851',
                'regionName' => 'Kanaren',
                'countryCode' => '',
                'type' => 1,
            ),
            456 => 
            array (
                'id' => 2697,
                'regionCode' => 'region.852',
                'regionName' => 'Mersin - Adana - Antakya',
                'countryCode' => '',
                'type' => 1,
            ),
            457 => 
            array (
                'id' => 2698,
                'regionCode' => 'region.852',
                'regionName' => 'Mersin - Adana - Antalya',
                'countryCode' => '',
                'type' => 1,
            ),
            458 => 
            array (
                'id' => 2699,
                'regionCode' => 'region.854',
                'regionName' => 'Auvergne',
                'countryCode' => '',
                'type' => 1,
            ),
            459 => 
            array (
                'id' => 2700,
                'regionCode' => 'region.857',
                'regionName' => 'Castellon',
                'countryCode' => '',
                'type' => 1,
            ),
            460 => 
            array (
                'id' => 2701,
                'regionCode' => 'region.858',
                'regionName' => 'Basel & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            461 => 
            array (
                'id' => 2702,
                'regionCode' => 'region.859',
                'regionName' => 'Georgien',
                'countryCode' => '',
                'type' => 1,
            ),
            462 => 
            array (
                'id' => 2703,
                'regionCode' => 'region.860',
                'regionName' => 'Aserbaidschan',
                'countryCode' => '',
                'type' => 1,
            ),
            463 => 
            array (
                'id' => 2704,
                'regionCode' => 'region.861',
                'regionName' => 'Weißrussland',
                'countryCode' => '',
                'type' => 1,
            ),
            464 => 
            array (
                'id' => 2705,
                'regionCode' => 'region.862',
                'regionName' => 'Vanuatu',
                'countryCode' => '',
                'type' => 1,
            ),
            465 => 
            array (
                'id' => 2706,
                'regionCode' => 'region.863',
                'regionName' => 'Bhutan',
                'countryCode' => '',
                'type' => 1,
            ),
            466 => 
            array (
                'id' => 2707,
                'regionCode' => 'region.866',
                'regionName' => 'Moldawien',
                'countryCode' => '',
                'type' => 1,
            ),
            467 => 
            array (
                'id' => 2708,
                'regionCode' => 'region.867',
                'regionName' => 'Kirgistan',
                'countryCode' => '',
                'type' => 1,
            ),
            468 => 
            array (
                'id' => 2709,
                'regionCode' => 'region.868',
                'regionName' => 'Armenien',
                'countryCode' => '',
                'type' => 1,
            ),
            469 => 
            array (
                'id' => 2710,
                'regionCode' => 'region.871',
                'regionName' => 'Afghanistan',
                'countryCode' => '',
                'type' => 1,
            ),
            470 => 
            array (
                'id' => 2711,
                'regionCode' => 'region.873',
                'regionName' => 'Mazedonien',
                'countryCode' => '',
                'type' => 1,
            ),
            471 => 
            array (
                'id' => 2712,
                'regionCode' => 'region.874',
                'regionName' => 'Pakistan',
                'countryCode' => '',
                'type' => 1,
            ),
            472 => 
            array (
                'id' => 2713,
                'regionCode' => 'region.877',
                'regionName' => 'Pyrenäen Spanien',
                'countryCode' => '',
                'type' => 1,
            ),
            473 => 
            array (
                'id' => 2714,
                'regionCode' => 'region.878',
                'regionName' => 'Guyana',
                'countryCode' => '',
                'type' => 1,
            ),
            474 => 
            array (
                'id' => 2715,
                'regionCode' => 'region.879',
                'regionName' => 'Cayman Inseln',
                'countryCode' => '',
                'type' => 1,
            ),
            475 => 
            array (
                'id' => 2716,
                'regionCode' => 'region.882',
                'regionName' => 'Indien - Kerala',
                'countryCode' => '',
                'type' => 1,
            ),
            476 => 
            array (
                'id' => 2717,
                'regionCode' => 'region.884',
                'regionName' => 'Kamerun',
                'countryCode' => '',
                'type' => 1,
            ),
            477 => 
            array (
                'id' => 2718,
                'regionCode' => 'region.885',
                'regionName' => 'Nigeria',
                'countryCode' => '',
                'type' => 1,
            ),
            478 => 
            array (
                'id' => 2719,
                'regionCode' => 'region.886',
                'regionName' => 'Saudi-Arabien',
                'countryCode' => '',
                'type' => 1,
            ),
            479 => 
            array (
                'id' => 2720,
                'regionCode' => 'region.887',
                'regionName' => 'Sudan',
                'countryCode' => '',
                'type' => 1,
            ),
            480 => 
            array (
                'id' => 2721,
                'regionCode' => 'region.890',
                'regionName' => 'Algerien',
                'countryCode' => '',
                'type' => 1,
            ),
            481 => 
            array (
                'id' => 2722,
                'regionCode' => 'region.896',
                'regionName' => 'Eritrea',
                'countryCode' => '',
                'type' => 1,
            ),
            482 => 
            array (
                'id' => 2723,
                'regionCode' => 'region.897',
                'regionName' => 'Mali',
                'countryCode' => '',
                'type' => 1,
            ),
            483 => 
            array (
                'id' => 2724,
                'regionCode' => 'region.899',
                'regionName' => 'Burundi',
                'countryCode' => '',
                'type' => 1,
            ),
            484 => 
            array (
                'id' => 2725,
                'regionCode' => 'region.900',
                'regionName' => 'Gibraltar',
                'countryCode' => '',
                'type' => 1,
            ),
            485 => 
            array (
                'id' => 2726,
                'regionCode' => 'region.903',
                'regionName' => 'Guinea',
                'countryCode' => '',
                'type' => 1,
            ),
            486 => 
            array (
                'id' => 2727,
                'regionCode' => 'region.904',
                'regionName' => 'Benin',
                'countryCode' => '',
                'type' => 1,
            ),
            487 => 
            array (
                'id' => 2728,
                'regionCode' => 'region.905',
                'regionName' => 'Dschibuti',
                'countryCode' => '',
                'type' => 1,
            ),
            488 => 
            array (
                'id' => 2729,
                'regionCode' => 'region.908',
                'regionName' => 'Phuket & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            489 => 
            array (
                'id' => 2730,
                'regionCode' => 'region.910',
                'regionName' => 'Indonesien - Sulawesi',
                'countryCode' => '',
                'type' => 1,
            ),
            490 => 
            array (
                'id' => 2731,
                'regionCode' => 'region.911',
                'regionName' => 'Bosnien-Herzegovina',
                'countryCode' => '',
                'type' => 1,
            ),
            491 => 
            array (
                'id' => 2732,
                'regionCode' => 'region.912',
                'regionName' => 'Indonesien - Sumatra',
                'countryCode' => '',
                'type' => 1,
            ),
            492 => 
            array (
                'id' => 2733,
                'regionCode' => 'region.915',
                'regionName' => 'Uganda',
                'countryCode' => '',
                'type' => 1,
            ),
            493 => 
            array (
                'id' => 2734,
                'regionCode' => 'region.918',
                'regionName' => 'Albanien',
                'countryCode' => '',
                'type' => 1,
            ),
            494 => 
            array (
                'id' => 2735,
                'regionCode' => 'region.919',
                'regionName' => 'El Salvador',
                'countryCode' => '',
                'type' => 1,
            ),
            495 => 
            array (
                'id' => 2736,
                'regionCode' => 'region.920',
                'regionName' => 'Somalia',
                'countryCode' => '',
                'type' => 1,
            ),
            496 => 
            array (
                'id' => 2737,
                'regionCode' => 'region.922',
                'regionName' => 'Costa Brava',
                'countryCode' => '',
                'type' => 1,
            ),
            497 => 
            array (
                'id' => 2738,
                'regionCode' => 'region.924',
                'regionName' => 'Olympische Riviera',
                'countryCode' => '',
                'type' => 1,
            ),
            498 => 
            array (
                'id' => 2739,
                'regionCode' => 'region.927',
            'regionName' => 'Zentralthailand (Rayong & Kanchanaburi)',
                'countryCode' => '',
                'type' => 1,
            ),
            499 => 
            array (
                'id' => 2740,
                'regionCode' => 'region.929',
            'regionName' => 'Südostthailand (Pattaya)',
                'countryCode' => '',
                'type' => 1,
            ),
        ));
        \DB::table('Regions')->insert(array (
            0 => 
            array (
                'id' => 2741,
                'regionCode' => 'region.932',
            'regionName' => 'Westthailand (Hua Hin - Cha Am)',
                'countryCode' => '',
                'type' => 1,
            ),
            1 => 
            array (
                'id' => 2742,
                'regionCode' => 'region.934',
                'regionName' => 'Khao Lak & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            2 => 
            array (
                'id' => 2743,
                'regionCode' => 'region.935',
                'regionName' => 'Madrid & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            3 => 
            array (
                'id' => 2744,
                'regionCode' => 'region.936',
                'regionName' => 'Republik Niger',
                'countryCode' => '',
                'type' => 1,
            ),
            4 => 
            array (
                'id' => 2745,
                'regionCode' => 'region.940',
                'regionName' => 'Cote d´Azur',
                'countryCode' => '',
                'type' => 1,
            ),
            5 => 
            array (
                'id' => 2746,
                'regionCode' => 'region.944',
                'regionName' => 'Nordirland',
                'countryCode' => '',
                'type' => 1,
            ),
            6 => 
            array (
                'id' => 2747,
                'regionCode' => 'region.947',
                'regionName' => 'Friaul',
                'countryCode' => '',
                'type' => 1,
            ),
            7 => 
            array (
                'id' => 2748,
                'regionCode' => 'region.948',
                'regionName' => 'Ruanda',
                'countryCode' => '',
                'type' => 1,
            ),
            8 => 
            array (
                'id' => 2749,
                'regionCode' => 'region.953',
                'regionName' => 'Guam',
                'countryCode' => '',
                'type' => 1,
            ),
            9 => 
            array (
                'id' => 2750,
                'regionCode' => 'region.959',
                'regionName' => 'Montserrat',
                'countryCode' => '',
                'type' => 1,
            ),
            10 => 
            array (
                'id' => 2751,
                'regionCode' => 'region.960',
                'regionName' => 'Kappadokien',
                'countryCode' => '',
                'type' => 1,
            ),
            11 => 
            array (
                'id' => 2752,
                'regionCode' => 'region.960',
                'regionName' => 'Kappadokien',
                'countryCode' => '',
                'type' => 1,
            ),
            12 => 
            array (
                'id' => 2753,
                'regionCode' => 'region.973',
                'regionName' => 'Indien - Tamil Nadu',
                'countryCode' => '',
                'type' => 1,
            ),
            13 => 
            array (
                'id' => 2754,
                'regionCode' => 'region.986',
                'regionName' => 'Indien - Maharashtra - Mumbai',
                'countryCode' => '',
                'type' => 1,
            ),
            14 => 
            array (
                'id' => 2755,
                'regionCode' => 'region.991',
                'regionName' => 'Indien - New Delhi',
                'countryCode' => '',
                'type' => 1,
            ),
            15 => 
            array (
                'id' => 2756,
                'regionCode' => 'region.992',
                'regionName' => 'Indien - Goa',
                'countryCode' => '',
                'type' => 1,
            ),
            16 => 
            array (
                'id' => 2757,
                'regionCode' => 'region.995',
                'regionName' => 'Indonesien - Molukken',
                'countryCode' => '',
                'type' => 1,
            ),
            17 => 
            array (
                'id' => 2758,
                'regionCode' => 'region.996',
                'regionName' => 'Palau',
                'countryCode' => '',
                'type' => 1,
            ),
            18 => 
            array (
                'id' => 2759,
                'regionCode' => 'region.997',
                'regionName' => 'Mauretanien',
                'countryCode' => '',
                'type' => 1,
            ),
            19 => 
            array (
                'id' => 2760,
                'regionCode' => 'region.1001',
                'regionName' => 'Tirol',
                'countryCode' => '',
                'type' => 1,
            ),
            20 => 
            array (
                'id' => 2761,
                'regionCode' => 'region.1007',
                'regionName' => 'Insel Elba',
                'countryCode' => '',
                'type' => 1,
            ),
            21 => 
            array (
                'id' => 2762,
                'regionCode' => 'region.1009',
                'regionName' => 'Nordkorea',
                'countryCode' => '',
                'type' => 1,
            ),
            22 => 
            array (
                'id' => 2763,
                'regionCode' => 'region.1012',
                'regionName' => 'Sierra Leone',
                'countryCode' => '',
                'type' => 1,
            ),
            23 => 
            array (
                'id' => 2764,
                'regionCode' => 'region.1013',
                'regionName' => 'Aruba',
                'countryCode' => '',
                'type' => 1,
            ),
            24 => 
            array (
                'id' => 2765,
                'regionCode' => 'region.1022',
                'regionName' => 'Tschad',
                'countryCode' => '',
                'type' => 1,
            ),
            25 => 
            array (
                'id' => 2766,
                'regionCode' => 'region.1023',
                'regionName' => 'Togo',
                'countryCode' => '',
                'type' => 1,
            ),
            26 => 
            array (
                'id' => 2767,
                'regionCode' => 'region.1024',
                'regionName' => 'Gabun',
                'countryCode' => '',
                'type' => 1,
            ),
            27 => 
            array (
                'id' => 2768,
                'regionCode' => 'region.1027',
                'regionName' => 'Jalisco',
                'countryCode' => '',
                'type' => 1,
            ),
            28 => 
            array (
                'id' => 2769,
                'regionCode' => 'region.1027',
                'regionName' => 'Pazifikküste',
                'countryCode' => '',
                'type' => 1,
            ),
            29 => 
            array (
                'id' => 2770,
                'regionCode' => 'region.1027',
                'regionName' => 'Puerto Vallarta & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            30 => 
            array (
                'id' => 2771,
                'regionCode' => 'region.1027,region.100168',
                'regionName' => 'Baja California',
                'countryCode' => '',
                'type' => 1,
            ),
            31 => 
            array (
                'id' => 2772,
                'regionCode' => 'region.1028',
                'regionName' => 'Assuan - Luxor - Libysche Wüste',
                'countryCode' => '',
                'type' => 1,
            ),
            32 => 
            array (
                'id' => 2773,
                'regionCode' => 'region.1030',
                'regionName' => 'Alexandria - Marsa Matruh - El Alamein',
                'countryCode' => '',
                'type' => 1,
            ),
            33 => 
            array (
                'id' => 2775,
                'regionCode' => 'region.1032',
                'regionName' => 'Marsa Alam - Quseir - Port Ghalib',
                'countryCode' => '',
                'type' => 1,
            ),
            34 => 
            array (
                'id' => 2776,
                'regionCode' => 'region.1036',
                'regionName' => 'Amalfiküste - Golf von Neapel',
                'countryCode' => '',
                'type' => 1,
            ),
            35 => 
            array (
                'id' => 2777,
                'regionCode' => 'region.1037',
                'regionName' => 'Burkina Faso',
                'countryCode' => '',
                'type' => 1,
            ),
            36 => 
            array (
                'id' => 2778,
                'regionCode' => 'region.1038',
                'regionName' => 'Tunesien Inland',
                'countryCode' => '',
                'type' => 1,
            ),
            37 => 
            array (
                'id' => 2779,
                'regionCode' => 'region.1045',
                'regionName' => 'Umbrien',
                'countryCode' => '',
                'type' => 1,
            ),
            38 => 
            array (
                'id' => 2780,
                'regionCode' => 'region.1051',
                'regionName' => 'Serbien & Kosovo',
                'countryCode' => '',
                'type' => 1,
            ),
            39 => 
            array (
                'id' => 2781,
                'regionCode' => 'region.1052,region.100397',
                'regionName' => 'Montenegro',
                'countryCode' => '',
                'type' => 1,
            ),
            40 => 
            array (
                'id' => 2782,
                'regionCode' => 'region.1053',
                'regionName' => 'Angola',
                'countryCode' => '',
                'type' => 1,
            ),
            41 => 
            array (
                'id' => 2783,
                'regionCode' => 'region.1054',
                'regionName' => 'Demokratischen Republik Kongo',
                'countryCode' => '',
                'type' => 1,
            ),
            42 => 
            array (
                'id' => 2784,
                'regionCode' => 'region.1055',
                'regionName' => 'Republik Kongo',
                'countryCode' => '',
                'type' => 1,
            ),
            43 => 
            array (
                'id' => 2785,
                'regionCode' => 'region.1056',
                'regionName' => 'Republik Liberia',
                'countryCode' => '',
                'type' => 1,
            ),
            44 => 
            array (
                'id' => 2786,
                'regionCode' => 'region.1064',
                'regionName' => 'Zentralafrikanische Republik',
                'countryCode' => '',
                'type' => 1,
            ),
            45 => 
            array (
                'id' => 2787,
                'regionCode' => 'region.1075',
                'regionName' => 'Nunavut',
                'countryCode' => '',
                'type' => 1,
            ),
            46 => 
            array (
                'id' => 2788,
                'regionCode' => 'region.1078',
                'regionName' => 'Indonesien - Timor',
                'countryCode' => '',
                'type' => 1,
            ),
            47 => 
            array (
                'id' => 2789,
                'regionCode' => 'region.1079',
                'regionName' => 'Indonesien - Java',
                'countryCode' => '',
                'type' => 1,
            ),
            48 => 
            array (
                'id' => 2790,
                'regionCode' => 'region.1080',
                'regionName' => 'Indonesien - Borneo',
                'countryCode' => '',
                'type' => 1,
            ),
            49 => 
            array (
                'id' => 2791,
                'regionCode' => 'region.1081',
                'regionName' => 'Indonesien - Neuguinea',
                'countryCode' => '',
                'type' => 1,
            ),
            50 => 
            array (
                'id' => 2792,
                'regionCode' => 'region.1082',
                'regionName' => 'Irak',
                'countryCode' => '',
                'type' => 1,
            ),
            51 => 
            array (
                'id' => 2793,
                'regionCode' => 'region.1083,region.1084',
                'regionName' => 'Bali & Lombok',
                'countryCode' => '',
                'type' => 1,
            ),
            52 => 
            array (
                'id' => 2794,
                'regionCode' => 'region.1085',
                'regionName' => 'Indonesien - Sumbawa',
                'countryCode' => '',
                'type' => 1,
            ),
            53 => 
            array (
                'id' => 2795,
                'regionCode' => 'region.1086',
                'regionName' => 'Indonesien - Flores',
                'countryCode' => '',
                'type' => 1,
            ),
            54 => 
            array (
                'id' => 2796,
                'regionCode' => 'region.1087',
                'regionName' => 'Indonesien - Riau Kepulauan',
                'countryCode' => '',
                'type' => 1,
            ),
            55 => 
            array (
                'id' => 2797,
                'regionCode' => 'region.1093',
                'regionName' => 'American Samoa',
                'countryCode' => '',
                'type' => 1,
            ),
            56 => 
            array (
                'id' => 2798,
                'regionCode' => 'region.1095',
                'regionName' => 'Osttimor',
                'countryCode' => '',
                'type' => 1,
            ),
            57 => 
            array (
                'id' => 2799,
                'regionCode' => 'region.1096',
                'regionName' => 'Wallis & Futuna ',
                'countryCode' => '',
                'type' => 1,
            ),
            58 => 
            array (
                'id' => 2800,
                'regionCode' => 'region.1099',
                'regionName' => 'Capri',
                'countryCode' => '',
                'type' => 1,
            ),
            59 => 
            array (
                'id' => 2801,
                'regionCode' => 'region.1100',
                'regionName' => 'Südafrika - Südküste',
                'countryCode' => '',
                'type' => 1,
            ),
            60 => 
            array (
                'id' => 2802,
                'regionCode' => 'region.1101',
                'regionName' => 'Äquatorial Guinea',
                'countryCode' => '',
                'type' => 1,
            ),
            61 => 
            array (
                'id' => 2803,
                'regionCode' => 'region.1108',
                'regionName' => 'Istrien',
                'countryCode' => '',
                'type' => 1,
            ),
            62 => 
            array (
                'id' => 2804,
                'regionCode' => 'region.1110',
                'regionName' => 'Marianen Inseln',
                'countryCode' => '',
                'type' => 1,
            ),
            63 => 
            array (
                'id' => 2805,
                'regionCode' => 'region.1119',
                'regionName' => 'Koh Samui',
                'countryCode' => '',
                'type' => 1,
            ),
            64 => 
            array (
                'id' => 2806,
                'regionCode' => 'region.1133',
                'regionName' => 'Aquitanien - Perigord',
                'countryCode' => '',
                'type' => 1,
            ),
            65 => 
            array (
                'id' => 2807,
                'regionCode' => 'region.1164',
                'regionName' => 'Brasilien - Rio de Janeiro & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            66 => 
            array (
                'id' => 2808,
                'regionCode' => 'region.1168',
                'regionName' => 'China - Osten',
                'countryCode' => '',
                'type' => 1,
            ),
            67 => 
            array (
                'id' => 2809,
                'regionCode' => 'region.1169',
                'regionName' => 'China - Ostküste',
                'countryCode' => '',
                'type' => 1,
            ),
            68 => 
            array (
                'id' => 2810,
                'regionCode' => 'region.1170',
                'regionName' => 'China - Südküste',
                'countryCode' => '',
                'type' => 1,
            ),
            69 => 
            array (
                'id' => 2811,
                'regionCode' => 'region.1171',
                'regionName' => 'China - Tibet',
                'countryCode' => '',
                'type' => 1,
            ),
            70 => 
            array (
                'id' => 2812,
                'regionCode' => 'region.1172',
                'regionName' => 'China - Zentralchina',
                'countryCode' => '',
                'type' => 1,
            ),
            71 => 
            array (
                'id' => 2813,
                'regionCode' => 'region.1179',
                'regionName' => 'China - Süden',
                'countryCode' => '',
                'type' => 1,
            ),
            72 => 
            array (
                'id' => 2814,
                'regionCode' => 'region.1180',
                'regionName' => 'China - Insel Hainan',
                'countryCode' => '',
                'type' => 1,
            ),
            73 => 
            array (
                'id' => 2815,
                'regionCode' => 'region.1182',
                'regionName' => 'Tadschikistan',
                'countryCode' => '',
                'type' => 1,
            ),
            74 => 
            array (
                'id' => 2816,
                'regionCode' => 'region.1185',
                'regionName' => 'Russland Ostseeküste',
                'countryCode' => '',
                'type' => 1,
            ),
            75 => 
            array (
                'id' => 2817,
                'regionCode' => 'region.1186',
                'regionName' => 'Russland Moskau & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            76 => 
            array (
                'id' => 2818,
                'regionCode' => 'region.1196',
                'regionName' => 'Färöer Inseln',
                'countryCode' => '',
                'type' => 1,
            ),
            77 => 
            array (
                'id' => 2819,
                'regionCode' => 'region.100000',
                'regionName' => 'Balearen',
                'countryCode' => '',
                'type' => 1,
            ),
            78 => 
            array (
                'id' => 2820,
                'regionCode' => 'region.100002',
                'regionName' => 'Griechische Inseln',
                'countryCode' => '',
                'type' => 1,
            ),
            79 => 
            array (
                'id' => 2821,
                'regionCode' => 'region.100007',
                'regionName' => 'Italien',
                'countryCode' => '',
                'type' => 1,
            ),
            80 => 
            array (
                'id' => 2822,
                'regionCode' => 'region.100008',
                'regionName' => 'Tunesien',
                'countryCode' => '',
                'type' => 1,
            ),
            81 => 
            array (
                'id' => 2823,
                'regionCode' => 'region.100009',
                'regionName' => 'Osteuropa',
                'countryCode' => '',
                'type' => 1,
            ),
            82 => 
            array (
                'id' => 2824,
                'regionCode' => 'region.100010',
                'regionName' => 'Großbritannien & Irland',
                'countryCode' => '',
                'type' => 1,
            ),
            83 => 
            array (
                'id' => 2825,
                'regionCode' => 'region.100012',
                'regionName' => 'Benelux',
                'countryCode' => '',
                'type' => 1,
            ),
            84 => 
            array (
                'id' => 2826,
                'regionCode' => 'region.100015',
                'regionName' => 'Afrika',
                'countryCode' => '',
                'type' => 1,
            ),
            85 => 
            array (
                'id' => 2827,
                'regionCode' => 'region.100016',
                'regionName' => 'Indischer Ozean',
                'countryCode' => '',
                'type' => 1,
            ),
            86 => 
            array (
                'id' => 2828,
                'regionCode' => 'region.100017',
                'regionName' => 'Karibik',
                'countryCode' => '',
                'type' => 1,
            ),
            87 => 
            array (
                'id' => 2829,
                'regionCode' => 'region.100018',
                'regionName' => 'Mittelamerika',
                'countryCode' => '',
                'type' => 1,
            ),
            88 => 
            array (
                'id' => 2830,
                'regionCode' => 'region.100019',
                'regionName' => 'Südamerika',
                'countryCode' => '',
                'type' => 1,
            ),
            89 => 
            array (
                'id' => 2831,
                'regionCode' => 'region.100020',
                'regionName' => 'Asien',
                'countryCode' => '',
                'type' => 1,
            ),
            90 => 
            array (
                'id' => 2832,
                'regionCode' => 'region.100021',
                'regionName' => 'Australien',
                'countryCode' => '',
                'type' => 1,
            ),
            91 => 
            array (
                'id' => 2833,
                'regionCode' => 'region.100022',
                'regionName' => 'Südsee',
                'countryCode' => '',
                'type' => 1,
            ),
            92 => 
            array (
                'id' => 2834,
                'regionCode' => 'region.100023',
                'regionName' => 'Kvarner Bucht & Adriatische Küste',
                'countryCode' => '',
                'type' => 1,
            ),
            93 => 
            array (
                'id' => 2835,
                'regionCode' => 'region.100023,region.1109',
            'regionName' => 'Inland  (Zagreb)',
                'countryCode' => '',
                'type' => 1,
            ),
            94 => 
            array (
                'id' => 2836,
                'regionCode' => 'region.100025',
                'regionName' => 'Atlantikküste weitere Angebote Frankreich',
                'countryCode' => '',
                'type' => 1,
            ),
            95 => 
            array (
                'id' => 2837,
                'regionCode' => 'region.100025',
                'regionName' => 'Asturien',
                'countryCode' => '',
                'type' => 1,
            ),
            96 => 
            array (
                'id' => 2838,
                'regionCode' => 'region.100025',
                'regionName' => 'Atlantikküste weitere Angebote Spanien',
                'countryCode' => '',
                'type' => 1,
            ),
            97 => 
            array (
                'id' => 2839,
                'regionCode' => 'region.100025',
                'regionName' => 'Baskenland',
                'countryCode' => '',
                'type' => 1,
            ),
            98 => 
            array (
                'id' => 2840,
                'regionCode' => 'region.100025',
                'regionName' => 'Galicien',
                'countryCode' => '',
                'type' => 1,
            ),
            99 => 
            array (
                'id' => 2841,
                'regionCode' => 'region.100025',
                'regionName' => 'Kantabrien',
                'countryCode' => '',
                'type' => 1,
            ),
            100 => 
            array (
                'id' => 2842,
                'regionCode' => 'region.100026',
                'regionName' => 'Kastilien',
                'countryCode' => '',
                'type' => 1,
            ),
            101 => 
            array (
                'id' => 2843,
                'regionCode' => 'region.100027',
                'regionName' => 'Barcelona & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            102 => 
            array (
                'id' => 2844,
                'regionCode' => 'region.100028',
                'regionName' => 'La Rioja',
                'countryCode' => '',
                'type' => 1,
            ),
            103 => 
            array (
                'id' => 2845,
                'regionCode' => 'region.100028',
                'regionName' => 'Navarra',
                'countryCode' => '',
                'type' => 1,
            ),
            104 => 
            array (
                'id' => 2846,
                'regionCode' => 'region.100029',
                'regionName' => 'Aostatal',
                'countryCode' => '',
                'type' => 1,
            ),
            105 => 
            array (
                'id' => 2847,
                'regionCode' => 'region.100029',
                'regionName' => 'Piemont',
                'countryCode' => '',
                'type' => 1,
            ),
            106 => 
            array (
                'id' => 2848,
                'regionCode' => 'region.100030',
                'regionName' => 'Ötztal',
                'countryCode' => '',
                'type' => 1,
            ),
            107 => 
            array (
                'id' => 2849,
                'regionCode' => 'region.100030',
                'regionName' => 'Stubaital',
                'countryCode' => '',
                'type' => 1,
            ),
            108 => 
            array (
                'id' => 2850,
                'regionCode' => 'region.100030,region.100032',
                'regionName' => 'Südtirol - Dolomiten - Alpen',
                'countryCode' => '',
                'type' => 1,
            ),
            109 => 
            array (
                'id' => 2851,
                'regionCode' => 'region.100031',
                'regionName' => 'Toskana',
                'countryCode' => '',
                'type' => 1,
            ),
            110 => 
            array (
                'id' => 2852,
                'regionCode' => 'region.100033',
                'regionName' => 'Kampanien',
                'countryCode' => '',
                'type' => 1,
            ),
            111 => 
            array (
                'id' => 2853,
                'regionCode' => 'region.100034',
                'regionName' => 'Abruzzen',
                'countryCode' => '',
                'type' => 1,
            ),
            112 => 
            array (
                'id' => 2854,
                'regionCode' => 'region.100035',
                'regionName' => 'Malta',
                'countryCode' => '',
                'type' => 1,
            ),
            113 => 
            array (
                'id' => 2855,
                'regionCode' => 'region.100036',
                'regionName' => 'Amorgos',
                'countryCode' => '',
                'type' => 1,
            ),
            114 => 
            array (
                'id' => 2856,
                'regionCode' => 'region.100036',
                'regionName' => 'Andros',
                'countryCode' => '',
                'type' => 1,
            ),
            115 => 
            array (
                'id' => 2857,
                'regionCode' => 'region.100036',
                'regionName' => 'Folegandros',
                'countryCode' => '',
                'type' => 1,
            ),
            116 => 
            array (
                'id' => 2858,
                'regionCode' => 'region.100036',
                'regionName' => 'Ios',
                'countryCode' => '',
                'type' => 1,
            ),
            117 => 
            array (
                'id' => 2859,
                'regionCode' => 'region.100036',
                'regionName' => 'Kea',
                'countryCode' => '',
                'type' => 1,
            ),
            118 => 
            array (
                'id' => 2860,
                'regionCode' => 'region.100036',
                'regionName' => 'Kimolos',
                'countryCode' => '',
                'type' => 1,
            ),
            119 => 
            array (
                'id' => 2861,
                'regionCode' => 'region.100036',
                'regionName' => 'Kykladen Inseln',
                'countryCode' => '',
                'type' => 1,
            ),
            120 => 
            array (
                'id' => 2862,
                'regionCode' => 'region.100036',
                'regionName' => 'Kythnos',
                'countryCode' => '',
                'type' => 1,
            ),
            121 => 
            array (
                'id' => 2863,
                'regionCode' => 'region.100036',
                'regionName' => 'Milos',
                'countryCode' => '',
                'type' => 1,
            ),
            122 => 
            array (
                'id' => 2864,
                'regionCode' => 'region.100036',
                'regionName' => 'Naxos',
                'countryCode' => '',
                'type' => 1,
            ),
            123 => 
            array (
                'id' => 2865,
                'regionCode' => 'region.100036',
                'regionName' => 'Paros',
                'countryCode' => '',
                'type' => 1,
            ),
            124 => 
            array (
                'id' => 2866,
                'regionCode' => 'region.100036',
                'regionName' => 'Santorini',
                'countryCode' => '',
                'type' => 1,
            ),
            125 => 
            array (
                'id' => 2867,
                'regionCode' => 'region.100036',
                'regionName' => 'Serifos',
                'countryCode' => '',
                'type' => 1,
            ),
            126 => 
            array (
                'id' => 2868,
                'regionCode' => 'region.100036',
                'regionName' => 'Sifnos',
                'countryCode' => '',
                'type' => 1,
            ),
            127 => 
            array (
                'id' => 2869,
                'regionCode' => 'region.100036',
                'regionName' => 'Syros',
                'countryCode' => '',
                'type' => 1,
            ),
            128 => 
            array (
                'id' => 2870,
                'regionCode' => 'region.100036',
                'regionName' => 'Tinos',
                'countryCode' => '',
                'type' => 1,
            ),
            129 => 
            array (
                'id' => 2871,
                'regionCode' => 'region.100037',
                'regionName' => 'Astypalea',
                'countryCode' => '',
                'type' => 1,
            ),
            130 => 
            array (
                'id' => 2872,
                'regionCode' => 'region.100037',
                'regionName' => 'Chalki',
                'countryCode' => '',
                'type' => 1,
            ),
            131 => 
            array (
                'id' => 2873,
                'regionCode' => 'region.100037',
                'regionName' => 'Kalymnos',
                'countryCode' => '',
                'type' => 1,
            ),
            132 => 
            array (
                'id' => 2874,
                'regionCode' => 'region.100037',
                'regionName' => 'Karpathos',
                'countryCode' => '',
                'type' => 1,
            ),
            133 => 
            array (
                'id' => 2875,
                'regionCode' => 'region.100037',
                'regionName' => 'Leros',
                'countryCode' => '',
                'type' => 1,
            ),
            134 => 
            array (
                'id' => 2876,
                'regionCode' => 'region.100037',
                'regionName' => 'Lipsi',
                'countryCode' => '',
                'type' => 1,
            ),
            135 => 
            array (
                'id' => 2877,
                'regionCode' => 'region.100037',
                'regionName' => 'Megisti',
                'countryCode' => '',
                'type' => 1,
            ),
            136 => 
            array (
                'id' => 2878,
                'regionCode' => 'region.100037',
                'regionName' => 'Nisyros',
                'countryCode' => '',
                'type' => 1,
            ),
            137 => 
            array (
                'id' => 2879,
                'regionCode' => 'region.100037',
                'regionName' => 'Patmos',
                'countryCode' => '',
                'type' => 1,
            ),
            138 => 
            array (
                'id' => 2880,
                'regionCode' => 'region.100037',
                'regionName' => 'Symi',
                'countryCode' => '',
                'type' => 1,
            ),
            139 => 
            array (
                'id' => 2881,
                'regionCode' => 'region.100037',
                'regionName' => 'Telendos',
                'countryCode' => '',
                'type' => 1,
            ),
            140 => 
            array (
                'id' => 2882,
                'regionCode' => 'region.100037',
                'regionName' => 'Tilos',
                'countryCode' => '',
                'type' => 1,
            ),
            141 => 
            array (
                'id' => 2883,
                'regionCode' => 'region.100038',
                'regionName' => 'Alonissos',
                'countryCode' => '',
                'type' => 1,
            ),
            142 => 
            array (
                'id' => 2884,
                'regionCode' => 'region.100038',
                'regionName' => 'Skopelos',
                'countryCode' => '',
                'type' => 1,
            ),
            143 => 
            array (
                'id' => 2885,
                'regionCode' => 'region.100038',
                'regionName' => 'Skyros',
                'countryCode' => '',
                'type' => 1,
            ),
            144 => 
            array (
                'id' => 2886,
                'regionCode' => 'region.100039',
                'regionName' => 'Samos',
                'countryCode' => '',
                'type' => 1,
            ),
            145 => 
            array (
                'id' => 2887,
                'regionCode' => 'region.100040',
                'regionName' => 'Chios',
                'countryCode' => '',
                'type' => 1,
            ),
            146 => 
            array (
                'id' => 2888,
                'regionCode' => 'region.100040',
                'regionName' => 'Fourni',
                'countryCode' => '',
                'type' => 1,
            ),
            147 => 
            array (
                'id' => 2889,
                'regionCode' => 'region.100040',
                'regionName' => 'Ikaria',
                'countryCode' => '',
                'type' => 1,
            ),
            148 => 
            array (
                'id' => 2890,
                'regionCode' => 'region.100040',
                'regionName' => 'Limnos',
                'countryCode' => '',
                'type' => 1,
            ),
            149 => 
            array (
                'id' => 2891,
                'regionCode' => 'region.100040',
                'regionName' => 'Samothraki',
                'countryCode' => '',
                'type' => 1,
            ),
            150 => 
            array (
                'id' => 2892,
                'regionCode' => 'region.100041',
                'regionName' => 'Saronischer Golf',
                'countryCode' => '',
                'type' => 1,
            ),
            151 => 
            array (
                'id' => 2893,
                'regionCode' => 'region.100041',
                'regionName' => 'Ägina',
                'countryCode' => '',
                'type' => 1,
            ),
            152 => 
            array (
                'id' => 2894,
                'regionCode' => 'region.100041',
                'regionName' => 'Hydra',
                'countryCode' => '',
                'type' => 1,
            ),
            153 => 
            array (
                'id' => 2895,
                'regionCode' => 'region.100041',
                'regionName' => 'Poros',
                'countryCode' => '',
                'type' => 1,
            ),
            154 => 
            array (
                'id' => 2896,
                'regionCode' => 'region.100041',
                'regionName' => 'Spetses',
                'countryCode' => '',
                'type' => 1,
            ),
            155 => 
            array (
                'id' => 2897,
                'regionCode' => 'region.100042',
                'regionName' => 'Ithaka',
                'countryCode' => '',
                'type' => 1,
            ),
            156 => 
            array (
                'id' => 2898,
                'regionCode' => 'region.100042',
                'regionName' => 'Kefalonia',
                'countryCode' => '',
                'type' => 1,
            ),
            157 => 
            array (
                'id' => 2899,
                'regionCode' => 'region.100042',
                'regionName' => 'Kythira',
                'countryCode' => '',
                'type' => 1,
            ),
            158 => 
            array (
                'id' => 2900,
                'regionCode' => 'region.100042',
            'regionName' => 'Lefkada (Lefkas)',
                'countryCode' => '',
                'type' => 1,
            ),
            159 => 
            array (
                'id' => 2901,
                'regionCode' => 'region.100042',
                'regionName' => 'Paxos & Andipaxos',
                'countryCode' => '',
                'type' => 1,
            ),
            160 => 
            array (
                'id' => 2902,
                'regionCode' => 'region.100043',
                'regionName' => 'Mittelgriechenland',
                'countryCode' => '',
                'type' => 1,
            ),
            161 => 
            array (
                'id' => 2903,
                'regionCode' => 'region.100043',
                'regionName' => 'Parnass Gebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            162 => 
            array (
                'id' => 2904,
                'regionCode' => 'region.100044,region.100045',
                'regionName' => 'Costa Verde - Porto',
                'countryCode' => '',
                'type' => 1,
            ),
            163 => 
            array (
                'id' => 2905,
                'regionCode' => 'region.100046',
                'regionName' => 'Costa de Prata',
                'countryCode' => '',
                'type' => 1,
            ),
            164 => 
            array (
                'id' => 2906,
                'regionCode' => 'region.100049',
                'regionName' => 'Bodrum',
                'countryCode' => '',
                'type' => 1,
            ),
            165 => 
            array (
                'id' => 2907,
                'regionCode' => 'region.100049,region.144',
                'regionName' => 'Türkische Ägäis & Halbinsel Bodrum',
                'countryCode' => '',
                'type' => 1,
            ),
            166 => 
            array (
                'id' => 2908,
                'regionCode' => 'region.100050',
                'regionName' => 'Ceuta & Melilla',
                'countryCode' => '',
                'type' => 1,
            ),
            167 => 
            array (
                'id' => 2909,
                'regionCode' => 'region.100051',
                'regionName' => 'Atlantikküste',
                'countryCode' => '',
                'type' => 1,
            ),
            168 => 
            array (
                'id' => 2910,
                'regionCode' => 'region.100052',
                'regionName' => 'Marokko Mittelmeerküste',
                'countryCode' => '',
                'type' => 1,
            ),
            169 => 
            array (
                'id' => 2911,
                'regionCode' => 'region.100053',
                'regionName' => 'Marokko Inland',
                'countryCode' => '',
                'type' => 1,
            ),
            170 => 
            array (
                'id' => 2912,
                'regionCode' => 'region.100054',
                'regionName' => 'Marrakesch',
                'countryCode' => '',
                'type' => 1,
            ),
            171 => 
            array (
                'id' => 2913,
                'regionCode' => 'region.100055',
                'regionName' => 'Oase Tozeur',
                'countryCode' => '',
                'type' => 1,
            ),
            172 => 
            array (
                'id' => 2914,
                'regionCode' => 'region.100056',
                'regionName' => 'Kairo - Gizeh - Memphis',
                'countryCode' => '',
                'type' => 1,
            ),
            173 => 
            array (
                'id' => 2915,
                'regionCode' => 'region.100057',
                'regionName' => 'Jura',
                'countryCode' => '',
                'type' => 1,
            ),
            174 => 
            array (
                'id' => 2916,
                'regionCode' => 'region.100058',
                'regionName' => 'Mittelland weitere Angebote',
                'countryCode' => '',
                'type' => 1,
            ),
            175 => 
            array (
                'id' => 2917,
                'regionCode' => 'region.100059,region.100060',
                'regionName' => 'Genfer See & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            176 => 
            array (
                'id' => 2918,
                'regionCode' => 'region.100061',
                'regionName' => 'Zürich & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            177 => 
            array (
                'id' => 2921,
                'regionCode' => 'region.100063',
                'regionName' => 'Ostseeinseln',
                'countryCode' => '',
                'type' => 1,
            ),
            178 => 
            array (
                'id' => 2922,
                'regionCode' => 'region.100063,region.100062',
                'regionName' => 'Ostseeküste',
                'countryCode' => '',
                'type' => 1,
            ),
            179 => 
            array (
                'id' => 2924,
                'regionCode' => 'region.100065',
                'regionName' => 'Insel Sylt',
                'countryCode' => '',
                'type' => 1,
            ),
            180 => 
            array (
                'id' => 2925,
                'regionCode' => 'region.100065',
                'regionName' => 'Nordseeinseln',
                'countryCode' => '',
                'type' => 1,
            ),
            181 => 
            array (
                'id' => 2926,
                'regionCode' => 'region.100065,region.100064',
                'regionName' => 'Nordseeküste',
                'countryCode' => '',
                'type' => 1,
            ),
            182 => 
            array (
                'id' => 2927,
                'regionCode' => 'region.100066',
                'regionName' => 'Lüneburger Heide',
                'countryCode' => '',
                'type' => 1,
            ),
            183 => 
            array (
                'id' => 2928,
                'regionCode' => 'region.100067',
                'regionName' => 'Sächsische Schweiz & Erzgebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            184 => 
            array (
                'id' => 2929,
                'regionCode' => 'region.100068',
                'regionName' => 'Bayerischer & Oberpfälzer Wald',
                'countryCode' => '',
                'type' => 1,
            ),
            185 => 
            array (
                'id' => 2930,
                'regionCode' => 'region.100069',
                'regionName' => 'Franken',
                'countryCode' => '',
                'type' => 1,
            ),
            186 => 
            array (
                'id' => 2932,
                'regionCode' => 'region.100069',
                'regionName' => 'Frankenwald & Fichtelgebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            187 => 
            array (
                'id' => 2933,
                'regionCode' => 'region.100070',
                'regionName' => 'Allgäu',
                'countryCode' => '',
                'type' => 1,
            ),
            188 => 
            array (
                'id' => 2934,
                'regionCode' => 'region.100070',
                'regionName' => 'Bayerisch-Schwaben',
                'countryCode' => '',
                'type' => 1,
            ),
            189 => 
            array (
                'id' => 2935,
                'regionCode' => 'region.100070',
                'regionName' => 'Allgäu',
                'countryCode' => '',
                'type' => 1,
            ),
            190 => 
            array (
                'id' => 2936,
                'regionCode' => 'region.100071',
                'regionName' => 'Oberpfalz',
                'countryCode' => '',
                'type' => 1,
            ),
            191 => 
            array (
                'id' => 2938,
                'regionCode' => 'region.100071',
                'regionName' => 'Schwarzwald',
                'countryCode' => '',
                'type' => 1,
            ),
            192 => 
            array (
                'id' => 2939,
                'regionCode' => 'region.100072',
                'regionName' => 'Bodensee & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            193 => 
            array (
                'id' => 2940,
                'regionCode' => 'region.100072',
                'regionName' => 'Bodensee & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            194 => 
            array (
                'id' => 2942,
                'regionCode' => 'region.100073',
                'regionName' => 'Rhein-Main Region',
                'countryCode' => '',
                'type' => 1,
            ),
            195 => 
            array (
                'id' => 2943,
                'regionCode' => 'region.100074',
                'regionName' => 'Mosel-Saar Region',
                'countryCode' => '',
                'type' => 1,
            ),
            196 => 
            array (
                'id' => 2944,
                'regionCode' => 'region.100074,region.625',
                'regionName' => 'Rheinland-Pfalz',
                'countryCode' => '',
                'type' => 1,
            ),
            197 => 
            array (
                'id' => 2945,
                'regionCode' => 'region.100075',
                'regionName' => 'Eifel - Taunus - Hunsrück',
                'countryCode' => '',
                'type' => 1,
            ),
            198 => 
            array (
                'id' => 2948,
                'regionCode' => 'region.100076',
                'regionName' => 'Sauerland',
                'countryCode' => '',
                'type' => 1,
            ),
            199 => 
            array (
                'id' => 2949,
                'regionCode' => 'region.100077',
                'regionName' => 'Emsland',
                'countryCode' => '',
                'type' => 1,
            ),
            200 => 
            array (
                'id' => 2950,
                'regionCode' => 'region.100078',
                'regionName' => 'Mecklenburg-Vorpommern & Seenplatte',
                'countryCode' => '',
                'type' => 1,
            ),
            201 => 
            array (
                'id' => 2952,
                'regionCode' => 'region.100079',
                'regionName' => 'Insel Usedom',
                'countryCode' => '',
                'type' => 1,
            ),
            202 => 
            array (
                'id' => 2954,
                'regionCode' => 'region.100080',
                'regionName' => 'Insel Rügen',
                'countryCode' => '',
                'type' => 1,
            ),
            203 => 
            array (
                'id' => 2956,
                'regionCode' => 'region.100081',
                'regionName' => 'Harz',
                'countryCode' => '',
                'type' => 1,
            ),
            204 => 
            array (
                'id' => 2958,
                'regionCode' => 'region.100082',
                'regionName' => 'Bremen',
                'countryCode' => '',
                'type' => 1,
            ),
            205 => 
            array (
                'id' => 2959,
                'regionCode' => 'region.100082',
                'regionName' => 'Hamburg',
                'countryCode' => '',
                'type' => 1,
            ),
            206 => 
            array (
                'id' => 2961,
                'regionCode' => 'region.100084',
                'regionName' => 'Köln & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            207 => 
            array (
                'id' => 2962,
                'regionCode' => 'region.100085',
                'regionName' => 'München & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            208 => 
            array (
                'id' => 2963,
                'regionCode' => 'region.100088',
                'regionName' => 'Nordtirol',
                'countryCode' => '',
                'type' => 1,
            ),
            209 => 
            array (
                'id' => 2964,
                'regionCode' => 'region.100088',
                'regionName' => 'Olympia Region Seefeld',
                'countryCode' => '',
                'type' => 1,
            ),
            210 => 
            array (
                'id' => 2965,
                'regionCode' => 'region.100089',
                'regionName' => 'Tirol Ost',
                'countryCode' => '',
                'type' => 1,
            ),
            211 => 
            array (
                'id' => 2966,
                'regionCode' => 'region.100089',
                'regionName' => 'Zillertal',
                'countryCode' => '',
                'type' => 1,
            ),
            212 => 
            array (
                'id' => 2967,
                'regionCode' => 'region.100091',
                'regionName' => 'Polnische Ostseeküste',
                'countryCode' => '',
                'type' => 1,
            ),
            213 => 
            array (
                'id' => 2968,
                'regionCode' => 'region.100096',
                'regionName' => 'Paris & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            214 => 
            array (
                'id' => 2969,
                'regionCode' => 'region.100099',
                'regionName' => 'Champagne Ardenne',
                'countryCode' => '',
                'type' => 1,
            ),
            215 => 
            array (
                'id' => 2970,
                'regionCode' => 'region.100099',
                'regionName' => 'Picardie',
                'countryCode' => '',
                'type' => 1,
            ),
            216 => 
            array (
                'id' => 2971,
                'regionCode' => 'region.100100,region.175',
                'regionName' => 'Belgien',
                'countryCode' => '',
                'type' => 1,
            ),
            217 => 
            array (
                'id' => 2972,
                'regionCode' => 'region.100110',
                'regionName' => 'Guernsey & St.Anne',
                'countryCode' => '',
                'type' => 1,
            ),
            218 => 
            array (
                'id' => 2973,
                'regionCode' => 'region.100110',
                'regionName' => 'Jersey',
                'countryCode' => '',
                'type' => 1,
            ),
            219 => 
            array (
                'id' => 2974,
                'regionCode' => 'region.100137',
                'regionName' => 'Sonnenstrand',
                'countryCode' => '',
                'type' => 1,
            ),
            220 => 
            array (
                'id' => 2975,
                'regionCode' => 'region.100138',
                'regionName' => 'Goldstrand',
                'countryCode' => '',
                'type' => 1,
            ),
            221 => 
            array (
                'id' => 2976,
                'regionCode' => 'region.100139',
                'regionName' => 'Sofia & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            222 => 
            array (
                'id' => 2977,
                'regionCode' => 'region.100141',
                'regionName' => 'Tschechische Republik - Prag & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            223 => 
            array (
                'id' => 2978,
                'regionCode' => 'region.100142',
                'regionName' => 'Russland St.Petersburg & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            224 => 
            array (
                'id' => 2979,
                'regionCode' => 'region.100144',
            'regionName' => 'Ungarn - Balaton (Plattensee)',
                'countryCode' => '',
                'type' => 1,
            ),
            225 => 
            array (
                'id' => 2980,
                'regionCode' => 'region.100145',
                'regionName' => 'Ungarn - Budapest & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            226 => 
            array (
                'id' => 2981,
                'regionCode' => 'region.100145,region.234',
                'regionName' => 'Ungarn',
                'countryCode' => '',
                'type' => 1,
            ),
            227 => 
            array (
                'id' => 2982,
                'regionCode' => 'region.100151',
                'regionName' => 'Polen',
                'countryCode' => '',
                'type' => 1,
            ),
            228 => 
            array (
                'id' => 2983,
                'regionCode' => 'region.100152',
                'regionName' => 'Slowenien',
                'countryCode' => '',
                'type' => 1,
            ),
            229 => 
            array (
                'id' => 2984,
                'regionCode' => 'region.100153',
                'regionName' => 'Mexiko Stadt & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            230 => 
            array (
                'id' => 2985,
                'regionCode' => 'region.100160',
                'regionName' => 'Bonaire',
                'countryCode' => '',
                'type' => 1,
            ),
            231 => 
            array (
                'id' => 2986,
                'regionCode' => 'region.100160',
                'regionName' => 'Curacao',
                'countryCode' => '',
                'type' => 1,
            ),
            232 => 
            array (
                'id' => 2987,
                'regionCode' => 'region.100160',
                'regionName' => 'Saba',
                'countryCode' => '',
                'type' => 1,
            ),
            233 => 
            array (
                'id' => 2988,
                'regionCode' => 'region.100160',
                'regionName' => 'Sint Eustatius',
                'countryCode' => '',
                'type' => 1,
            ),
            234 => 
            array (
                'id' => 2989,
                'regionCode' => 'region.100160',
                'regionName' => 'Sint Maarten',
                'countryCode' => '',
                'type' => 1,
            ),
            235 => 
            array (
                'id' => 2990,
                'regionCode' => 'region.100162',
                'regionName' => 'Antigua',
                'countryCode' => '',
                'type' => 1,
            ),
            236 => 
            array (
                'id' => 2991,
                'regionCode' => 'region.100162',
                'regionName' => 'Antigua & Barbuda',
                'countryCode' => '',
                'type' => 1,
            ),
            237 => 
            array (
                'id' => 2992,
                'regionCode' => 'region.100164',
                'regionName' => 'Amerikanische Jungferninseln',
                'countryCode' => '',
                'type' => 1,
            ),
            238 => 
            array (
                'id' => 2993,
                'regionCode' => 'region.100164',
                'regionName' => 'Britische Jungferninseln',
                'countryCode' => '',
                'type' => 1,
            ),
            239 => 
            array (
                'id' => 2994,
                'regionCode' => 'region.100165',
                'regionName' => 'Kuba - Havanna & Varadero & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            240 => 
            array (
                'id' => 2995,
                'regionCode' => 'region.100166',
                'regionName' => 'Kuba - Holguin & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            241 => 
            array (
                'id' => 2996,
                'regionCode' => 'region.100170',
                'regionName' => 'Skandinavien & Island',
                'countryCode' => '',
                'type' => 1,
            ),
            242 => 
            array (
                'id' => 2997,
                'regionCode' => 'region.100171',
            'regionName' => 'Inseln im Golf von Thailand (Koh Chang & weitere)',
                'countryCode' => '',
                'type' => 1,
            ),
            243 => 
            array (
                'id' => 2998,
                'regionCode' => 'region.100172',
                'regionName' => 'Paraguay',
                'countryCode' => '',
                'type' => 1,
            ),
            244 => 
            array (
                'id' => 2999,
                'regionCode' => 'region.100172',
                'regionName' => 'Uruguay',
                'countryCode' => '',
                'type' => 1,
            ),
            245 => 
            array (
                'id' => 3000,
                'regionCode' => 'region.100173',
                'regionName' => 'Französisch Guyana',
                'countryCode' => '',
                'type' => 1,
            ),
            246 => 
            array (
                'id' => 3001,
                'regionCode' => 'region.100173',
                'regionName' => 'Suriname',
                'countryCode' => '',
                'type' => 1,
            ),
            247 => 
            array (
                'id' => 3002,
                'regionCode' => 'region.100181',
                'regionName' => 'Nordinsel',
                'countryCode' => '',
                'type' => 1,
            ),
            248 => 
            array (
                'id' => 3003,
                'regionCode' => 'region.100182',
                'regionName' => 'Südinsel',
                'countryCode' => '',
                'type' => 1,
            ),
            249 => 
            array (
                'id' => 3004,
                'regionCode' => 'region.100187',
                'regionName' => 'Turkmenistan',
                'countryCode' => '',
                'type' => 1,
            ),
            250 => 
            array (
                'id' => 3005,
                'regionCode' => 'region.100188',
                'regionName' => 'Israel - Tel Aviv & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            251 => 
            array (
                'id' => 3006,
                'regionCode' => 'region.100189',
                'regionName' => 'Israel - Jerusalem & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            252 => 
            array (
                'id' => 3007,
                'regionCode' => 'region.100190',
                'regionName' => 'Israel - Totes Meer & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            253 => 
            array (
                'id' => 3008,
                'regionCode' => 'region.100191',
                'regionName' => 'Israel - Eilat',
                'countryCode' => '',
                'type' => 1,
            ),
            254 => 
            array (
                'id' => 3009,
                'regionCode' => 'region.100192',
                'regionName' => 'Jordanien - Amman',
                'countryCode' => '',
                'type' => 1,
            ),
            255 => 
            array (
                'id' => 3010,
                'regionCode' => 'region.100194',
                'regionName' => 'Jordanien - Totes Meer & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            256 => 
            array (
                'id' => 3011,
                'regionCode' => 'region.100196',
                'regionName' => 'Südafrika - Kapstadt  & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            257 => 
            array (
                'id' => 3012,
                'regionCode' => 'region.100197',
                'regionName' => 'Südafrika - Johannesburg  & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            258 => 
            array (
                'id' => 3013,
                'regionCode' => 'region.100198',
                'regionName' => 'China - Shanghai',
                'countryCode' => '',
                'type' => 1,
            ),
            259 => 
            array (
                'id' => 3014,
                'regionCode' => 'region.100199',
                'regionName' => 'China - Peking',
                'countryCode' => '',
                'type' => 1,
            ),
            260 => 
            array (
                'id' => 3015,
                'regionCode' => 'region.100201',
                'regionName' => 'Sao Tome & Principe',
                'countryCode' => '',
                'type' => 1,
            ),
            261 => 
            array (
                'id' => 3016,
                'regionCode' => 'region.100205',
                'regionName' => 'Westsahara',
                'countryCode' => '',
                'type' => 1,
            ),
            262 => 
            array (
                'id' => 3017,
                'regionCode' => 'region.100209',
                'regionName' => 'Salomoninseln',
                'countryCode' => '',
                'type' => 1,
            ),
            263 => 
            array (
                'id' => 3018,
                'regionCode' => 'region.100212',
                'regionName' => 'Haiti',
                'countryCode' => '',
                'type' => 1,
            ),
            264 => 
            array (
                'id' => 3019,
                'regionCode' => 'region.100213',
                'regionName' => 'Saint Barthelemy',
                'countryCode' => '',
                'type' => 1,
            ),
            265 => 
            array (
                'id' => 3020,
                'regionCode' => 'region.100215',
                'regionName' => 'Miami - Fort Lauderdale',
                'countryCode' => '',
                'type' => 1,
            ),
            266 => 
            array (
                'id' => 3021,
                'regionCode' => 'region.100216',
                'regionName' => 'Westküste',
                'countryCode' => '',
                'type' => 1,
            ),
            267 => 
            array (
                'id' => 3022,
                'regionCode' => 'region.100218',
                'regionName' => 'Mexiko',
                'countryCode' => '',
                'type' => 1,
            ),
            268 => 
            array (
                'id' => 3023,
                'regionCode' => 'region.100219',
                'regionName' => 'Chiemsee & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            269 => 
            array (
                'id' => 3024,
                'regionCode' => 'region.100220',
                'regionName' => 'Thailand',
                'countryCode' => '',
                'type' => 1,
            ),
            270 => 
            array (
                'id' => 3030,
                'regionCode' => 'region.100238',
                'regionName' => 'weitere Angebote Spanisches Festland',
                'countryCode' => '',
                'type' => 1,
            ),
            271 => 
            array (
                'id' => 3031,
                'regionCode' => 'region.100239,region.100251',
                'regionName' => 'weitere Angebote Mexiko',
                'countryCode' => '',
                'type' => 1,
            ),
            272 => 
            array (
                'id' => 3038,
                'regionCode' => 'region.100245,region.1002',
                'regionName' => 'Orlando & Ostküste',
                'countryCode' => '',
                'type' => 1,
            ),
            273 => 
            array (
                'id' => 3039,
                'regionCode' => 'region.100246',
                'regionName' => 'Kultur Reisen Ägypten',
                'countryCode' => '',
                'type' => 1,
            ),
            274 => 
            array (
                'id' => 3040,
                'regionCode' => 'region.100246',
                'regionName' => 'Rundreise Kairo & Baden',
                'countryCode' => '',
                'type' => 1,
            ),
            275 => 
            array (
                'id' => 3046,
                'regionCode' => 'region.100253',
                'regionName' => 'Disneyland Paris & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            276 => 
            array (
                'id' => 3048,
                'regionCode' => 'region.100259',
                'regionName' => 'New Jersey',
                'countryCode' => '',
                'type' => 1,
            ),
            277 => 
            array (
                'id' => 3049,
                'regionCode' => 'region.100259',
                'regionName' => 'New York',
                'countryCode' => '',
                'type' => 1,
            ),
            278 => 
            array (
                'id' => 3050,
                'regionCode' => 'region.100260',
                'regionName' => 'V.A. Emirate - Ajman',
                'countryCode' => '',
                'type' => 1,
            ),
            279 => 
            array (
                'id' => 3051,
                'regionCode' => 'region.100260',
                'regionName' => 'V.A. Emirate - Sharjah',
                'countryCode' => '',
                'type' => 1,
            ),
            280 => 
            array (
                'id' => 3059,
                'regionCode' => 'region.100290',
                'regionName' => 'Tschechische Republik - Böhmen',
                'countryCode' => '',
                'type' => 1,
            ),
            281 => 
            array (
                'id' => 3060,
                'regionCode' => 'region.100291',
                'regionName' => 'Tschechische Republik - Altvatergebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            282 => 
            array (
                'id' => 3061,
                'regionCode' => 'region.100292',
                'regionName' => 'Tschechische Republik - Erzgebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            283 => 
            array (
                'id' => 3062,
                'regionCode' => 'region.100293',
                'regionName' => 'Tschechische Republik - Isergebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            284 => 
            array (
                'id' => 3067,
                'regionCode' => 'region.100300',
                'regionName' => 'weitere Angebote Griechenland Festland',
                'countryCode' => '',
                'type' => 1,
            ),
            285 => 
            array (
                'id' => 3075,
                'regionCode' => 'region.100315,region.100224',
                'regionName' => 'weitere Angebote Tunesien',
                'countryCode' => '',
                'type' => 1,
            ),
            286 => 
            array (
                'id' => 3082,
                'regionCode' => 'region.100331',
                'regionName' => 'weiter Angebote Österreich',
                'countryCode' => '',
                'type' => 1,
            ),
            287 => 
            array (
                'id' => 3083,
                'regionCode' => 'region.100340,region.581',
                'regionName' => 'Libyen',
                'countryCode' => '',
                'type' => 1,
            ),
            288 => 
            array (
                'id' => 3084,
                'regionCode' => 'region.100341',
                'regionName' => 'spezielle Hotelangebote',
                'countryCode' => '',
                'type' => 1,
            ),
            289 => 
            array (
                'id' => 3088,
                'regionCode' => 'region.100354,region.746',
                'regionName' => 'Mauritius',
                'countryCode' => '',
                'type' => 1,
            ),
            290 => 
            array (
                'id' => 3090,
                'regionCode' => 'region.100359,region.1004',
                'regionName' => 'weitere Angebote Bulgarien',
                'countryCode' => '',
                'type' => 1,
            ),
            291 => 
            array (
                'id' => 3094,
                'regionCode' => 'region.100388',
                'regionName' => 'Marokko',
                'countryCode' => '',
                'type' => 1,
            ),
            292 => 
            array (
                'id' => 3095,
                'regionCode' => 'region.100390',
                'regionName' => 'Kiribati',
                'countryCode' => '',
                'type' => 1,
            ),
            293 => 
            array (
                'id' => 3096,
                'regionCode' => 'region.100390',
                'regionName' => 'Nauru',
                'countryCode' => '',
                'type' => 1,
            ),
            294 => 
            array (
                'id' => 3097,
                'regionCode' => 'region.100390',
                'regionName' => 'Niue',
                'countryCode' => '',
                'type' => 1,
            ),
            295 => 
            array (
                'id' => 3104,
                'regionCode' => 'region.100406,region.1003',
                'regionName' => 'weiter Angebote Schweiz',
                'countryCode' => '',
                'type' => 1,
            ),
            296 => 
            array (
                'id' => 3106,
                'regionCode' => 'region.100002,region.745,region.56,region.100043',
                'regionName' => 'Griechenland',
                'countryCode' => '',
                'type' => 1,
            ),
            297 => 
            array (
                'id' => 3107,
                'regionCode' => 'region.100006,region.100005,region.100003,region.100004',
                'regionName' => 'Deutschland',
                'countryCode' => '',
                'type' => 1,
            ),
            298 => 
            array (
                'id' => 3108,
                'regionCode' => 'region.100010,region.100114,region.100404,region.100255,region.100111,region.100113,region.100112',
                'regionName' => 'England',
                'countryCode' => '',
                'type' => 1,
            ),
            299 => 
            array (
                'id' => 3109,
                'regionCode' => 'region.100047,region.100048,region.652,region.326',
                'regionName' => 'Lissabon - Setubal & Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            300 => 
            array (
                'id' => 3110,
                'regionCode' => 'region.100068,region.615,region.100219',
                'regionName' => 'Bayern',
                'countryCode' => '',
                'type' => 1,
            ),
            301 => 
            array (
                'id' => 3111,
                'regionCode' => 'region.100070,region.615,region.100219',
                'regionName' => 'Oberbayern',
                'countryCode' => '',
                'type' => 1,
            ),
            302 => 
            array (
                'id' => 3112,
                'regionCode' => 'region.100077,region.100066,region.624',
                'regionName' => 'Niedersachsen',
                'countryCode' => '',
                'type' => 1,
            ),
            303 => 
            array (
                'id' => 3113,
                'regionCode' => 'region.100082,region.619,region.100085,region.100084',
                'regionName' => 'Deutsche Städte',
                'countryCode' => '',
                'type' => 1,
            ),
            304 => 
            array (
                'id' => 3115,
                'regionCode' => 'region.100087,region.660,region.846,region.100107,region.100108,region.100169,region.687,region.100338,region.840,region.847,region.100109,region.848,region.695',
                'regionName' => 'Dänemark',
                'countryCode' => '',
                'type' => 1,
            ),
            305 => 
            array (
                'id' => 3116,
                'regionCode' => 'region.100101,region.100102,region.100373,region.100106,region.100288,region.100104,region.100103,region.100105,region.893,region.202',
                'regionName' => 'Niederlande',
                'countryCode' => '',
                'type' => 1,
            ),
            306 => 
            array (
                'id' => 3117,
                'regionCode' => 'region.100115,region.100256,region.204,region.1050',
                'regionName' => 'Irland',
                'countryCode' => '',
                'type' => 1,
            ),
            307 => 
            array (
                'id' => 3118,
                'regionCode' => 'region.100121,region.761,region.100120,region.760,region.100119,region.758,region.100117,region.100118',
                'regionName' => 'Finnland',
                'countryCode' => '',
                'type' => 1,
            ),
            308 => 
            array (
                'id' => 3119,
                'regionCode' => 'region.100129,region.100126,region.100123,region.100372,region.100127,region.774,region.100298,region.100122,region.100125,region.100124,region.100128,region.773',
                'regionName' => 'Schweden',
                'countryCode' => '',
                'type' => 1,
            ),
            309 => 
            array (
                'id' => 3120,
                'regionCode' => 'region.100134,region.100284,region.100132,region.790,region.100130,region.100133,region.100403,region.789,region.100131',
                'regionName' => 'Norwegen',
                'countryCode' => '',
                'type' => 1,
            ),
            310 => 
            array (
                'id' => 3121,
                'regionCode' => 'region.100136,region.100386,region.1113,region.657,region.114',
                'regionName' => 'Rumänien',
                'countryCode' => '',
                'type' => 1,
            ),
            311 => 
            array (
                'id' => 3122,
                'regionCode' => 'region.100150,region.100283,region.100398',
                'regionName' => 'weitere Angebote Kanada',
                'countryCode' => '',
                'type' => 1,
            ),
            312 => 
            array (
                'id' => 3123,
                'regionCode' => 'region.100158,region.100159,region.100396,region.100157,region.16',
                'regionName' => 'Costa Rica',
                'countryCode' => '',
                'type' => 1,
            ),
            313 => 
            array (
                'id' => 3124,
                'regionCode' => 'region.100185,region.100186,region.100330,region.100184,region.100183,region.348',
                'regionName' => 'Japan',
                'countryCode' => '',
                'type' => 1,
            ),
            314 => 
            array (
                'id' => 3125,
                'regionCode' => 'region.100191,region.100189,region.100394,region.100188,region.100190,region.74',
                'regionName' => 'Israel',
                'countryCode' => '',
                'type' => 1,
            ),
            315 => 
            array (
                'id' => 3126,
                'regionCode' => 'region.100192,region.100193,region.100343,region.100194,region.87',
                'regionName' => 'Jordanien',
                'countryCode' => '',
                'type' => 1,
            ),
            316 => 
            array (
                'id' => 3127,
                'regionCode' => 'region.100217,region.1026,region.100167',
                'regionName' => 'Cancun - Riviera Maya - Yucatan',
                'countryCode' => '',
                'type' => 1,
            ),
            317 => 
            array (
                'id' => 3128,
                'regionCode' => 'region.100217,region.1026,region.100167',
                'regionName' => 'Golf von Mexiko',
                'countryCode' => '',
                'type' => 1,
            ),
            318 => 
            array (
                'id' => 3129,
                'regionCode' => 'region.100242,region.1151,region.1152,region.100',
                'regionName' => 'Malediven',
                'countryCode' => '',
                'type' => 1,
            ),
            319 => 
            array (
                'id' => 3130,
                'regionCode' => 'region.100258,region.100304,region.100280,region.100245,region.100215,region.100313,region.340,region.100216',
                'regionName' => 'USA - Florida',
                'countryCode' => '',
                'type' => 1,
            ),
            320 => 
            array (
                'id' => 3131,
                'regionCode' => 'region.100258,region.100304,region.100280,region.100313,region.340',
                'regionName' => 'Florida',
                'countryCode' => '',
                'type' => 1,
            ),
            321 => 
            array (
                'id' => 3133,
                'regionCode' => 'region.100267,region.100272,region.100274,region.100277',
                'regionName' => 'Roulettes',
                'countryCode' => '',
                'type' => 1,
            ),
            322 => 
            array (
                'id' => 3134,
                'regionCode' => 'region.100271,region.913,region.100374,region.585',
                'regionName' => 'Ukraine',
                'countryCode' => '',
                'type' => 1,
            ),
            323 => 
            array (
                'id' => 3135,
                'regionCode' => 'region.100291,region.100290,region.100292,region.100269,region.100293,region.100141,region.100328,region.232',
                'regionName' => 'Tschechische Republik',
                'countryCode' => '',
                'type' => 1,
            ),
            324 => 
            array (
                'id' => 3140,
                'regionCode' => 'region.100328,region.100374,region.100397,region.100386,region.100254,region.100300,region.100348,region.100255,region.100256,region.100323,region.100312,region.100354,region.100405,region.100257,region.100299,region.100306,region.100398,region.100356,reg',
                'regionName' => 'Rund & Kombireisen',
                'countryCode' => '',
                'type' => 1,
            ),
            325 => 
            array (
                'id' => 3144,
                'regionCode' => 'region.100350,region.100334,region.100254',
                'regionName' => 'weitere Angebote Frankreich',
                'countryCode' => '',
                'type' => 1,
            ),
            326 => 
            array (
                'id' => 3145,
                'regionCode' => 'region.100352,region.100181,region.100308,region.100182,region.1130',
                'regionName' => 'Neuseeland',
                'countryCode' => '',
                'type' => 1,
            ),
            327 => 
            array (
                'id' => 3146,
                'regionCode' => 'region.100352,region.100308,region.1130',
                'regionName' => 'weitere Angebote Neuseeland',
                'countryCode' => '',
                'type' => 1,
            ),
            328 => 
            array (
                'id' => 3147,
                'regionCode' => 'region.100357,region.100200,region.100317,region.318,region.100202',
                'regionName' => 'Namibia',
                'countryCode' => '',
                'type' => 1,
            ),
            329 => 
            array (
                'id' => 3148,
                'regionCode' => 'region.100395,region.335,region.806,region.100155,region.100154',
                'regionName' => 'Panama',
                'countryCode' => '',
                'type' => 1,
            ),
            330 => 
            array (
                'id' => 3149,
                'regionCode' => 'region.100408,region.100411,region.100409,region.100410,region.100369,region.100361,region.100365,region.100370,region.100363,region.100367,region.100368,region.100364,region.100362,region.100307,region.100325',
                'regionName' => 'Deutschland Specials',
                'countryCode' => '',
                'type' => 1,
            ),
            331 => 
            array (
                'id' => 3150,
                'regionCode' => 'region.1034,region.1040,region.81',
                'regionName' => 'Kalabrien',
                'countryCode' => '',
                'type' => 1,
            ),
            332 => 
            array (
                'id' => 3151,
                'regionCode' => 'region.1059,region.1062,region.1061',
                'regionName' => 'St.Helena - Ascension - Tristan da Cunha',
                'countryCode' => '',
                'type' => 1,
            ),
            333 => 
            array (
                'id' => 3152,
                'regionCode' => 'region.1065,region.100377,region.1173,region.1102,region.454',
                'regionName' => 'Argentinien',
                'countryCode' => '',
                'type' => 1,
            ),
            334 => 
            array (
                'id' => 3153,
                'regionCode' => 'region.1080,region.1086,region.1079,region.995,region.1081,region.1095,region.1087,region.100344,region.910,region.912,region.1085,region.1078,region.72',
                'regionName' => 'Indonesien',
                'countryCode' => '',
                'type' => 1,
            ),
            335 => 
            array (
                'id' => 3154,
                'regionCode' => 'region.1164,region.100333,region.12',
                'regionName' => 'Brasilien',
                'countryCode' => '',
                'type' => 1,
            ),
            336 => 
            array (
                'id' => 3155,
                'regionCode' => 'region.1180,region.100289,region.1168,region.1169,region.100199,region.100263,region.100198,region.1179,region.1170,region.1171,region.179,region.1172',
                'regionName' => 'China',
                'countryCode' => '',
                'type' => 1,
            ),
            337 => 
            array (
                'id' => 3156,
                'regionCode' => 'region.119,region.100000,region.851',
                'regionName' => 'Spanien',
                'countryCode' => '',
                'type' => 1,
            ),
            338 => 
            array (
                'id' => 3157,
                'regionCode' => 'region.1192,region.100143,region.1188,region.1191,region.1190,region.222,region.1189,region.1187',
                'regionName' => 'Russische Föderation',
                'countryCode' => '',
                'type' => 1,
            ),
            339 => 
            array (
                'id' => 3158,
                'regionCode' => 'region.296,region.100257,region.100392',
                'regionName' => 'Island',
                'countryCode' => '',
                'type' => 1,
            ),
            340 => 
            array (
                'id' => 3159,
                'regionCode' => 'region.314,region.100208,region.100207,region.100206',
                'regionName' => 'Fidschi',
                'countryCode' => '',
                'type' => 1,
            ),
            341 => 
            array (
                'id' => 3160,
                'regionCode' => 'region.315,region.588,region.100210',
                'regionName' => 'Französisch Polynesien',
                'countryCode' => '',
                'type' => 1,
            ),
            342 => 
            array (
                'id' => 3161,
                'regionCode' => 'region.411,region.100301,region.100324',
                'regionName' => 'Alaska',
                'countryCode' => '',
                'type' => 1,
            ),
            343 => 
            array (
                'id' => 3162,
                'regionCode' => 'region.434,region.100366,region.100029',
                'regionName' => 'Lombardei - Aostatal - Piemont',
                'countryCode' => '',
                'type' => 1,
            ),
            344 => 
            array (
                'id' => 3163,
                'regionCode' => 'region.452,region.100378,region.100382',
                'regionName' => 'Chile',
                'countryCode' => '',
                'type' => 1,
            ),
            345 => 
            array (
                'id' => 3164,
                'regionCode' => 'region.604,region.160,region.100235,region.100279',
                'regionName' => 'Dubai',
                'countryCode' => '',
                'type' => 1,
            ),
            346 => 
            array (
                'id' => 3165,
                'regionCode' => 'region.607,region.100260,region.608,region.609,region.160,region.100235,region.100279,region.100260,region.604',
                'regionName' => 'V.A. Emirate',
                'countryCode' => '',
                'type' => 1,
            ),
            347 => 
            array (
                'id' => 3166,
                'regionCode' => 'region.613,region.100376,region.100351',
                'regionName' => 'weitere Angebote Australien',
                'countryCode' => '',
                'type' => 1,
            ),
            348 => 
            array (
                'id' => 3167,
                'regionCode' => 'region.638,region.100305,region.640',
                'regionName' => 'Kenia - Inland',
                'countryCode' => '',
                'type' => 1,
            ),
            349 => 
            array (
                'id' => 3168,
                'regionCode' => 'region.638,region.100305,region.640,region.269',
                'regionName' => 'Kenia',
                'countryCode' => '',
                'type' => 1,
            ),
            350 => 
            array (
                'id' => 3169,
                'regionCode' => 'region.641,region.643,region.100379',
                'regionName' => 'Tansania',
                'countryCode' => '',
                'type' => 1,
            ),
            351 => 
            array (
                'id' => 3170,
                'regionCode' => 'region.647,region.100197,region.100196,region.100311,region.644,region.645,region.100302,region.1100,region.297,region.646',
                'regionName' => 'Südafrika',
                'countryCode' => '',
                'type' => 1,
            ),
            352 => 
            array (
                'id' => 3171,
                'regionCode' => 'region.659,region.100226,region.698,region.821,region.946,region.1108,region.1109,region.100336,region.90',
                'regionName' => 'Kroatien',
                'countryCode' => '',
                'type' => 1,
            ),
            353 => 
            array (
                'id' => 3172,
                'regionCode' => 'region.662,region.675,region.667,region.669,region.668,region.100399,region.671,region.672,region.677',
                'regionName' => 'Malaysia',
                'countryCode' => '',
                'type' => 1,
            ),
            354 => 
            array (
                'id' => 3173,
                'regionCode' => 'region.676,region.18,region.19,region.20',
                'regionName' => 'Dominikanische Republik',
                'countryCode' => '',
                'type' => 1,
            ),
            355 => 
            array (
                'id' => 3174,
                'regionCode' => 'region.698,region.821,region.946',
                'regionName' => 'Krk & Norddalmatische Inseln',
                'countryCode' => '',
                'type' => 1,
            ),
            356 => 
            array (
                'id' => 3175,
                'regionCode' => 'region.722,region.837,region.481',
                'regionName' => 'Slowakei',
                'countryCode' => '',
                'type' => 1,
            ),
            357 => 
            array (
                'id' => 3176,
                'regionCode' => 'region.752,region.940,region.574',
                'regionName' => 'Südostfrankreich',
                'countryCode' => '',
                'type' => 1,
            ),
            358 => 
            array (
                'id' => 3177,
                'regionCode' => 'region.812,region.100332,region.161',
                'regionName' => 'Venezuela',
                'countryCode' => '',
                'type' => 1,
            ),
            359 => 
            array (
                'id' => 3178,
                'regionCode' => 'region.86,region.100241,region.100347',
                'regionName' => 'Jamaika',
                'countryCode' => '',
                'type' => 1,
            ),
            360 => 
            array (
                'id' => 3179,
                'regionCode' => 'region.875,region.100174,region.1077',
                'regionName' => 'Bangladesh',
                'countryCode' => '',
                'type' => 1,
            ),
            361 => 
            array (
                'id' => 3180,
                'regionCode' => 'region.92,region.1126,region.1129,region.1128,region.1127,region.100211',
                'regionName' => 'Kuba',
                'countryCode' => '',
                'type' => 1,
            ),
            362 => 
            array (
                'id' => 3181,
                'regionCode' => 'region.991,region.992,region.882,region.986,region.100323,region.973,region.317',
                'regionName' => 'Indien',
                'countryCode' => '',
                'type' => 1,
            ),
            363 => 
            array (
                'id' => 3182,
                'regionCode' => 'region.100509',
                'regionName' => 'China - Hong Kong & Macau',
                'countryCode' => '',
                'type' => 1,
            ),
            364 => 
            array (
                'id' => 3183,
                'regionCode' => 'region.100014',
                'regionName' => 'Naher Osten - Vorderer Orient',
                'countryCode' => '',
                'type' => 1,
            ),
            365 => 
            array (
                'id' => 3184,
                'regionCode' => 'region.100069',
                'regionName' => 'Frankenwald & Fichtelgebirge',
                'countryCode' => '',
                'type' => 1,
            ),
            366 => 
            array (
                'id' => 3185,
                'regionCode' => 'region.637',
                'regionName' => 'Zypern Nord',
                'countryCode' => '',
                'type' => 1,
            ),
            367 => 
            array (
                'id' => 3186,
                'regionCode' => 'region.149',
                'regionName' => 'Side & Alanya',
                'countryCode' => '',
                'type' => 1,
            ),
            368 => 
            array (
                'id' => 3187,
                'regionCode' => 'region.149',
                'regionName' => 'Antalya & Belek',
                'countryCode' => '',
                'type' => 1,
            ),
            369 => 
            array (
                'id' => 3188,
                'regionCode' => 'region.100051',
                'regionName' => 'Atlantikküste: Agadir - Safi - Tiznit',
                'countryCode' => '',
                'type' => 1,
            ),
            370 => 
            array (
                'id' => 3189,
                'regionCode' => 'region.100085',
                'regionName' => 'München',
                'countryCode' => '',
                'type' => 1,
            ),
            371 => 
            array (
                'id' => 3190,
                'regionCode' => 'region.144',
                'regionName' => 'Ayvalik & Cesme & Izmir',
                'countryCode' => '',
                'type' => 1,
            ),
            372 => 
            array (
                'id' => 3191,
                'regionCode' => 'region.100084',
                'regionName' => 'Düsseldorf und Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            373 => 
            array (
                'id' => 3193,
                'regionCode' => 'region.100514',
                'regionName' => 'St. Martin',
                'countryCode' => '',
                'type' => 1,
            ),
            374 => 
            array (
                'id' => 3194,
                'regionCode' => 'region.88',
                'regionName' => 'Kap Verden weitere Angebote',
                'countryCode' => '',
                'type' => 1,
            ),
            375 => 
            array (
                'id' => 3195,
                'regionCode' => 'region.316',
                'regionName' => 'Philippinen',
                'countryCode' => '',
                'type' => 1,
            ),
            376 => 
            array (
                'id' => 3196,
                'regionCode' => 'region.574',
                'regionName' => 'Franz. Alpen',
                'countryCode' => '',
                'type' => 1,
            ),
            377 => 
            array (
                'id' => 3197,
                'regionCode' => 'region.491',
                'regionName' => 'Vorarlberg',
                'countryCode' => '',
                'type' => 1,
            ),
            378 => 
            array (
                'id' => 3198,
                'regionCode' => 'region.100447',
                'regionName' => 'Sylt',
                'countryCode' => '',
                'type' => 1,
            ),
            379 => 
            array (
                'id' => 3199,
                'regionCode' => 'region.494',
                'regionName' => 'Steiermark',
                'countryCode' => '',
                'type' => 1,
            ),
            380 => 
            array (
                'id' => 3200,
                'regionCode' => 'region.250',
                'regionName' => 'Zentralschweiz',
                'countryCode' => '',
                'type' => 1,
            ),
            381 => 
            array (
                'id' => 3201,
                'regionCode' => 'region.100072',
                'regionName' => 'Bodensee und Umgebung',
                'countryCode' => '',
                'type' => 1,
            ),
            382 => 
            array (
                'id' => 3202,
                'regionCode' => 'region.100068',
                'regionName' => 'Bayerischer Wald und Oberpfälzer Wald',
                'countryCode' => '',
                'type' => 1,
            ),
        ));
        
        
    }
}