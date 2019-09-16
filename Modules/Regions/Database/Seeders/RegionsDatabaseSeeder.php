<?php

namespace Modules\Regions\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('Regions')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'region_code' => 'ACH',
                    'region_name' => 'Altenrhein (CH)',
                    'country_code' => 'CH',
                    'type' => 0,
                ),
            1 =>
                array (
                    'id' => 2,
                    'region_code' => 'AMS',
                    'region_name' => 'Amsterdam (NL)',
                    'country_code' => 'NL',
                    'type' => 0,
                ),
            2 =>
                array (
                    'id' => 3,
                    'region_code' => 'BER',
                    'region_name' => 'Berlin (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            3 =>
                array (
                    'id' => 4,
                    'region_code' => 'BRE',
                    'region_name' => 'Bremen (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            4 =>
                array (
                    'id' => 5,
                    'region_code' => 'BRN',
                    'region_name' => 'Bern (CH)',
                    'country_code' => 'CH',
                    'type' => 0,
                ),
            5 =>
                array (
                    'id' => 6,
                    'region_code' => 'BRQ',
                    'region_name' => 'Brünn (CZ)',
                    'country_code' => 'CZ',
                    'type' => 0,
                ),
            6 =>
                array (
                    'id' => 7,
                    'region_code' => 'BRV',
                    'region_name' => 'Bremerhaven (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            7 =>
                array (
                    'id' => 8,
                    'region_code' => 'BSL',
                    'region_name' => 'Basel/Mulhouse (CH)',
                    'country_code' => 'CH',
                    'type' => 0,
                ),
            8 =>
                array (
                    'id' => 9,
                    'region_code' => 'BZG',
                    'region_name' => 'Bydgoszcz (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            9 =>
                array (
                    'id' => 10,
                    'region_code' => 'CGN',
                    'region_name' => 'Köln/Bonn (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            10 =>
                array (
                    'id' => 11,
                    'region_code' => 'CSO',
                    'region_name' => 'Magdeburg-Cochstedt (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            11 =>
                array (
                    'id' => 12,
                    'region_code' => 'DRS',
                    'region_name' => 'Dresden (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            12 =>
                array (
                    'id' => 13,
                    'region_code' => 'DTM',
                    'region_name' => 'Dortmund (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            13 =>
                array (
                    'id' => 14,
                    'region_code' => 'DUS',
                    'region_name' => 'Düsseldorf (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            14 =>
                array (
                    'id' => 15,
                    'region_code' => 'EIN',
                    'region_name' => 'Eindhoven (NL)',
                    'country_code' => 'NL',
                    'type' => 0,
                ),
            15 =>
                array (
                    'id' => 16,
                    'region_code' => 'ERF',
                    'region_name' => 'Erfurt (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            16 =>
                array (
                    'id' => 17,
                    'region_code' => 'FDH',
                    'region_name' => 'Friedrichshafen (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            17 =>
                array (
                    'id' => 18,
                    'region_code' => 'FKB',
                    'region_name' => 'Karlsruhe/Baden-Baden (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            18 =>
                array (
                    'id' => 19,
                    'region_code' => 'FMM',
                    'region_name' => 'Memmingen (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            19 =>
                array (
                    'id' => 20,
                    'region_code' => 'FMO',
                    'region_name' => 'Münster/Osnabrück (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            20 =>
                array (
                    'id' => 21,
                    'region_code' => 'FRA',
                    'region_name' => 'Frankfurt (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            21 =>
                array (
                    'id' => 22,
                    'region_code' => 'GDN',
                    'region_name' => 'Danzig (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            22 =>
                array (
                    'id' => 23,
                    'region_code' => 'GRQ',
                    'region_name' => 'Groningen (NL)',
                    'country_code' => 'NL',
                    'type' => 0,
                ),
            23 =>
                array (
                    'id' => 24,
                    'region_code' => 'GRZ',
                    'region_name' => 'Graz (AT)',
                    'country_code' => 'AT',
                    'type' => 0,
                ),
            24 =>
                array (
                    'id' => 25,
                    'region_code' => 'GVA',
                    'region_name' => 'Genf (CH)',
                    'country_code' => 'CH',
                    'type' => 0,
                ),
            25 =>
                array (
                    'id' => 26,
                    'region_code' => 'GWT',
                    'region_name' => 'Westerland-Sylt (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            26 =>
                array (
                    'id' => 27,
                    'region_code' => 'HAJ',
                    'region_name' => 'Hannover (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            27 =>
                array (
                    'id' => 28,
                    'region_code' => 'HAM',
                    'region_name' => 'Hamburg (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            28 =>
                array (
                    'id' => 29,
                    'region_code' => 'HDF',
                    'region_name' => 'Heringsdorf (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            29 =>
                array (
                    'id' => 30,
                    'region_code' => 'HHN',
                    'region_name' => 'Frankfurt-Hahn (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            30 =>
                array (
                    'id' => 31,
                    'region_code' => 'HOQ',
                    'region_name' => 'Hof (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            31 =>
                array (
                    'id' => 32,
                    'region_code' => 'IEG',
                    'region_name' => 'Zielona Gora (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            32 =>
                array (
                    'id' => 33,
                    'region_code' => 'INN',
                    'region_name' => 'Innsbruck (AT)',
                    'country_code' => 'AT',
                    'type' => 0,
                ),
            33 =>
                array (
                    'id' => 34,
                    'region_code' => 'KEL',
                    'region_name' => 'Kiel (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            34 =>
                array (
                    'id' => 35,
                    'region_code' => 'KLU',
                    'region_name' => 'Klagenfurt (AT)',
                    'country_code' => 'AT',
                    'type' => 0,
                ),
            35 =>
                array (
                    'id' => 36,
                    'region_code' => 'KLV',
                    'region_name' => 'Karlsbad (CZ)',
                    'country_code' => 'CZ',
                    'type' => 0,
                ),
            36 =>
                array (
                    'id' => 37,
                    'region_code' => 'KRK',
                    'region_name' => 'Krakau (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            37 =>
                array (
                    'id' => 38,
                    'region_code' => 'KSF',
                    'region_name' => 'Kassel (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            38 =>
                array (
                    'id' => 39,
                    'region_code' => 'KTW',
                    'region_name' => 'Kattowitz (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            39 =>
                array (
                    'id' => 40,
                    'region_code' => 'LBC',
                    'region_name' => 'Lübeck (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            40 =>
                array (
                    'id' => 41,
                    'region_code' => 'LCJ',
                    'region_name' => 'Lodz (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            41 =>
                array (
                    'id' => 42,
                    'region_code' => 'LEJ',
                    'region_name' => 'Leipzig/Halle (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            42 =>
                array (
                    'id' => 43,
                    'region_code' => 'LEY',
                    'region_name' => 'Lelystad (NL)',
                    'country_code' => 'NL',
                    'type' => 0,
                ),
            43 =>
                array (
                    'id' => 44,
                    'region_code' => 'LNZ',
                    'region_name' => 'Linz (AT)',
                    'country_code' => 'AT',
                    'type' => 0,
                ),
            44 =>
                array (
                    'id' => 45,
                    'region_code' => 'LUG',
                    'region_name' => 'Lugano (CH)',
                    'country_code' => 'CH',
                    'type' => 0,
                ),
            45 =>
                array (
                    'id' => 46,
                    'region_code' => 'MHG',
                    'region_name' => 'Mannheim (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            46 =>
                array (
                    'id' => 47,
                    'region_code' => 'MST',
                    'region_name' => 'Maastricht-Aachen (NL)',
                    'country_code' => 'NL',
                    'type' => 0,
                ),
            47 =>
                array (
                    'id' => 48,
                    'region_code' => 'MUC',
                    'region_name' => 'München (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            48 =>
                array (
                    'id' => 49,
                    'region_code' => 'NRN',
                    'region_name' => 'Weeze/Niederrhein (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            49 =>
                array (
                    'id' => 50,
                    'region_code' => 'NUE',
                    'region_name' => 'Nürnberg (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            50 =>
                array (
                    'id' => 51,
                    'region_code' => 'OSR',
                    'region_name' => 'Ostrava (CZ)',
                    'country_code' => 'CZ',
                    'type' => 0,
                ),
            51 =>
                array (
                    'id' => 52,
                    'region_code' => 'PAD',
                    'region_name' => 'Paderborn (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            52 =>
                array (
                    'id' => 53,
                    'region_code' => 'PED',
                    'region_name' => 'Pardubice (CZ)',
                    'country_code' => 'CZ',
                    'type' => 0,
                ),
            53 =>
                array (
                    'id' => 54,
                    'region_code' => 'POZ',
                    'region_name' => 'Posen (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            54 =>
                array (
                    'id' => 55,
                    'region_code' => 'PRG',
                    'region_name' => 'Prag (CZ)',
                    'country_code' => 'CZ',
                    'type' => 0,
                ),
            55 =>
                array (
                    'id' => 56,
                    'region_code' => 'RLG',
                    'region_name' => 'Rostock-Laage (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            56 =>
                array (
                    'id' => 57,
                    'region_code' => 'RTM',
                    'region_name' => 'Rotterdam (NL)',
                    'country_code' => 'NL',
                    'type' => 0,
                ),
            57 =>
                array (
                    'id' => 58,
                    'region_code' => 'RZE',
                    'region_name' => 'Rzeszow (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            58 =>
                array (
                    'id' => 59,
                    'region_code' => 'SCN',
                    'region_name' => 'Saarbrücken (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            59 =>
                array (
                    'id' => 60,
                    'region_code' => 'STR',
                    'region_name' => 'Stuttgart (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            60 =>
                array (
                    'id' => 61,
                    'region_code' => 'SXF',
                    'region_name' => 'Berlin-Schönefeld (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            61 =>
                array (
                    'id' => 62,
                    'region_code' => 'SZG',
                    'region_name' => 'Salzburg (AT)',
                    'country_code' => 'AT',
                    'type' => 0,
                ),
            62 =>
                array (
                    'id' => 63,
                    'region_code' => 'SZZ',
                    'region_name' => 'Stettin (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            63 =>
                array (
                    'id' => 64,
                    'region_code' => 'TXL',
                    'region_name' => 'Berlin-Tegel (DE)',
                    'country_code' => 'DE',
                    'type' => 0,
                ),
            64 =>
                array (
                    'id' => 65,
                    'region_code' => 'VIE',
                    'region_name' => 'Wien (AT)',
                    'country_code' => 'AT',
                    'type' => 0,
                ),
            65 =>
                array (
                    'id' => 66,
                    'region_code' => 'WAW',
                    'region_name' => 'Warschau (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            66 =>
                array (
                    'id' => 67,
                    'region_code' => 'WMI',
                    'region_name' => 'Warschau',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            67 =>
                array (
                    'id' => 68,
                    'region_code' => 'WRO',
                    'region_name' => 'Breslau (PL)',
                    'country_code' => 'PL',
                    'type' => 0,
                ),
            68 =>
                array (
                    'id' => 69,
                    'region_code' => 'ZRH',
                    'region_name' => 'Zürich (CH)',
                    'country_code' => 'CH',
                    'type' => 0,
                ),
            69 =>
                array (
                    'id' => 2296,
                    'region_code' => 'region.8',
                    'region_name' => 'Bahamas',
                    'country_code' => '',
                    'type' => 1,
                ),
            70 =>
                array (
                    'id' => 2297,
                    'region_code' => 'region.9',
                    'region_name' => 'Barbados',
                    'country_code' => '',
                    'type' => 1,
                ),
            71 =>
                array (
                    'id' => 2298,
                    'region_code' => 'region.12',
                    'region_name' => 'Brasilien - Amazonasgebiet',
                    'country_code' => '',
                    'type' => 1,
                ),
            72 =>
                array (
                    'id' => 2299,
                    'region_code' => 'region.12',
                    'region_name' => 'Brasilien - Mittelwesten',
                    'country_code' => '',
                    'type' => 1,
                ),
            73 =>
                array (
                    'id' => 2300,
                    'region_code' => 'region.12',
                    'region_name' => 'Brasilien - Nordosten',
                    'country_code' => '',
                    'type' => 1,
                ),
            74 =>
                array (
                    'id' => 2301,
                    'region_code' => 'region.12',
                    'region_name' => 'Brasilien - Recife & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            75 =>
                array (
                    'id' => 2302,
                    'region_code' => 'region.12',
                    'region_name' => 'Brasilien - Südosten',
                    'country_code' => '',
                    'type' => 1,
                ),
            76 =>
                array (
                    'id' => 2303,
                    'region_code' => 'region.18',
                    'region_name' => 'Dom. Republik Norden (Puerto Plata)',
                    'country_code' => '',
                    'type' => 1,
                ),
            77 =>
                array (
                    'id' => 2304,
                    'region_code' => 'region.19',
                    'region_name' => 'Dom. Republik Osten (Punta Cana)',
                    'country_code' => '',
                    'type' => 1,
                ),
            78 =>
                array (
                    'id' => 2305,
                    'region_code' => 'region.20',
                    'region_name' => 'Dom. Republik Süden (Santo Domingo)',
                    'country_code' => '',
                    'type' => 1,
                ),
            79 =>
                array (
                    'id' => 2306,
                    'region_code' => 'region.21',
                    'region_name' => 'Burgund',
                    'country_code' => '',
                    'type' => 1,
                ),
            80 =>
                array (
                    'id' => 2307,
                    'region_code' => 'region.21',
                    'region_name' => 'Frankreich - Landesinnere',
                    'country_code' => '',
                    'type' => 1,
                ),
            81 =>
                array (
                    'id' => 2308,
                    'region_code' => 'region.21',
                    'region_name' => 'Frenche Comte',
                    'country_code' => '',
                    'type' => 1,
                ),
            82 =>
                array (
                    'id' => 2309,
                    'region_code' => 'region.21',
                    'region_name' => 'Limousin',
                    'country_code' => '',
                    'type' => 1,
                ),
            83 =>
                array (
                    'id' => 2310,
                    'region_code' => 'region.21',
                    'region_name' => 'Midi Pyrenees',
                    'country_code' => '',
                    'type' => 1,
                ),
            84 =>
                array (
                    'id' => 2311,
                    'region_code' => 'region.21',
                    'region_name' => 'Zentralfrankreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            85 =>
                array (
                    'id' => 2312,
                    'region_code' => 'region.23',
                    'region_name' => 'Gambia',
                    'country_code' => '',
                    'type' => 1,
                ),
            86 =>
                array (
                    'id' => 2313,
                    'region_code' => 'region.24',
                    'region_name' => 'Grenada',
                    'country_code' => '',
                    'type' => 1,
                ),
            87 =>
                array (
                    'id' => 2314,
                    'region_code' => 'region.30',
                    'region_name' => 'Attika (Athen & Umgebung)',
                    'country_code' => '',
                    'type' => 1,
                ),
            88 =>
                array (
                    'id' => 2315,
                    'region_code' => 'region.31',
                    'region_name' => 'Chalkidiki',
                    'country_code' => '',
                    'type' => 1,
                ),
            89 =>
                array (
                    'id' => 2316,
                    'region_code' => 'region.33',
                    'region_name' => 'Epirus',
                    'country_code' => '',
                    'type' => 1,
                ),
            90 =>
                array (
                    'id' => 2317,
                    'region_code' => 'region.34',
                    'region_name' => 'Euböa (Evia) & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            91 =>
                array (
                    'id' => 2318,
                    'region_code' => 'region.36',
                    'region_name' => 'Golf von Korinth',
                    'country_code' => '',
                    'type' => 1,
                ),
            92 =>
                array (
                    'id' => 2319,
                    'region_code' => 'region.44',
                    'region_name' => 'Korfu',
                    'country_code' => '',
                    'type' => 1,
                ),
            93 =>
                array (
                    'id' => 2320,
                    'region_code' => 'region.45',
                    'region_name' => 'Kos',
                    'country_code' => '',
                    'type' => 1,
                ),
            94 =>
                array (
                    'id' => 2321,
                    'region_code' => 'region.46',
                    'region_name' => 'Koufonisi',
                    'country_code' => '',
                    'type' => 1,
                ),
            95 =>
                array (
                    'id' => 2322,
                    'region_code' => 'region.46',
                    'region_name' => 'Kreta',
                    'country_code' => '',
                    'type' => 1,
                ),
            96 =>
                array (
                    'id' => 2323,
                    'region_code' => 'region.49',
                    'region_name' => 'Lesbos',
                    'country_code' => '',
                    'type' => 1,
                ),
            97 =>
                array (
                    'id' => 2324,
                    'region_code' => 'region.51',
                    'region_name' => 'Mykonos',
                    'country_code' => '',
                    'type' => 1,
                ),
            98 =>
                array (
                    'id' => 2325,
                    'region_code' => 'region.56',
                    'region_name' => 'Peloponnes',
                    'country_code' => '',
                    'type' => 1,
                ),
            99 =>
                array (
                    'id' => 2326,
                    'region_code' => 'region.56',
                    'region_name' => 'Westgriechenland',
                    'country_code' => '',
                    'type' => 1,
                ),
            100 =>
                array (
                    'id' => 2327,
                    'region_code' => 'region.57',
                    'region_name' => 'Pilion',
                    'country_code' => '',
                    'type' => 1,
                ),
            101 =>
                array (
                    'id' => 2328,
                    'region_code' => 'region.59',
                    'region_name' => 'Rhodos',
                    'country_code' => '',
                    'type' => 1,
                ),
            102 =>
                array (
                    'id' => 2329,
                    'region_code' => 'region.62',
                    'region_name' => 'Skiathos',
                    'country_code' => '',
                    'type' => 1,
                ),
            103 =>
                array (
                    'id' => 2330,
                    'region_code' => 'region.68',
                    'region_name' => 'Thassos',
                    'country_code' => '',
                    'type' => 1,
                ),
            104 =>
                array (
                    'id' => 2331,
                    'region_code' => 'region.71',
                    'region_name' => 'Zakynthos',
                    'country_code' => '',
                    'type' => 1,
                ),
            105 =>
                array (
                    'id' => 2332,
                    'region_code' => 'region.74',
                    'region_name' => 'Israel - Haifa & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            106 =>
                array (
                    'id' => 2333,
                    'region_code' => 'region.76',
                    'region_name' => 'Marken',
                    'country_code' => '',
                    'type' => 1,
                ),
            107 =>
                array (
                    'id' => 2334,
                    'region_code' => 'region.77',
                    'region_name' => 'Adria',
                    'country_code' => '',
                    'type' => 1,
                ),
            108 =>
                array (
                    'id' => 2335,
                    'region_code' => 'region.77',
                    'region_name' => 'Molise',
                    'country_code' => '',
                    'type' => 1,
                ),
            109 =>
                array (
                    'id' => 2336,
                    'region_code' => 'region.78',
                    'region_name' => 'Apulien',
                    'country_code' => '',
                    'type' => 1,
                ),
            110 =>
                array (
                    'id' => 2337,
                    'region_code' => 'region.79',
                    'region_name' => 'Oberitalienische Seen - Gardasee',
                    'country_code' => '',
                    'type' => 1,
                ),
            111 =>
                array (
                    'id' => 2338,
                    'region_code' => 'region.80',
                    'region_name' => 'Ischia',
                    'country_code' => '',
                    'type' => 1,
                ),
            112 =>
                array (
                    'id' => 2339,
                    'region_code' => 'region.82',
                    'region_name' => 'Italienische Riviera ( Cinque Terre - San Remo)',
                    'country_code' => '',
                    'type' => 1,
                ),
            113 =>
                array (
                    'id' => 2340,
                    'region_code' => 'region.83',
                    'region_name' => 'Sardinien',
                    'country_code' => '',
                    'type' => 1,
                ),
            114 =>
                array (
                    'id' => 2341,
                    'region_code' => 'region.84',
                    'region_name' => 'Sizilien',
                    'country_code' => '',
                    'type' => 1,
                ),
            115 =>
                array (
                    'id' => 2342,
                    'region_code' => 'region.87',
                    'region_name' => 'Jordanien - Aqaba',
                    'country_code' => '',
                    'type' => 1,
                ),
            116 =>
                array (
                    'id' => 2343,
                    'region_code' => 'region.88,region.100353',
                    'region_name' => 'Kap Verde - Insel Boa Vista',
                    'country_code' => '',
                    'type' => 1,
                ),
            117 =>
                array (
                    'id' => 2344,
                    'region_code' => 'region.88,region.100353',
                    'region_name' => 'Kap Verde - Insel Sal',
                    'country_code' => '',
                    'type' => 1,
                ),
            118 =>
                array (
                    'id' => 2345,
                    'region_code' => 'region.88,region.100353',
                    'region_name' => 'Kap Verde - Insel Santiago & Fogo & Sao Vicente',
                    'country_code' => '',
                    'type' => 1,
                ),
            119 =>
                array (
                    'id' => 2346,
                    'region_code' => 'region.106',
                    'region_name' => 'Tabasco',
                    'country_code' => '',
                    'type' => 1,
                ),
            120 =>
                array (
                    'id' => 2347,
                    'region_code' => 'region.108',
                    'region_name' => 'Oman - Muskat & Salalah',
                    'country_code' => '',
                    'type' => 1,
                ),
            121 =>
                array (
                    'id' => 2348,
                    'region_code' => 'region.109',
                    'region_name' => 'Algarve',
                    'country_code' => '',
                    'type' => 1,
                ),
            122 =>
                array (
                    'id' => 2349,
                    'region_code' => 'region.109',
                    'region_name' => 'Costa Azul',
                    'country_code' => '',
                    'type' => 1,
                ),
            123 =>
                array (
                    'id' => 2350,
                    'region_code' => 'region.110',
                    'region_name' => 'Azoren',
                    'country_code' => '',
                    'type' => 1,
                ),
            124 =>
                array (
                    'id' => 2351,
                    'region_code' => 'region.111',
                    'region_name' => 'Nordportugal',
                    'country_code' => '',
                    'type' => 1,
                ),
            125 =>
                array (
                    'id' => 2352,
                    'region_code' => 'region.113',
                    'region_name' => 'La Reunion',
                    'country_code' => '',
                    'type' => 1,
                ),
            126 =>
                array (
                    'id' => 2353,
                    'region_code' => 'region.115',
                    'region_name' => 'Senegal',
                    'country_code' => '',
                    'type' => 1,
                ),
            127 =>
                array (
                    'id' => 2354,
                    'region_code' => 'region.116,region.100405',
                    'region_name' => 'Seychellen',
                    'country_code' => '',
                    'type' => 1,
                ),
            128 =>
                array (
                    'id' => 2355,
                    'region_code' => 'region.119',
                    'region_name' => 'Spanisches Festland',
                    'country_code' => '',
                    'type' => 1,
                ),
            129 =>
                array (
                    'id' => 2356,
                    'region_code' => 'region.125',
                    'region_name' => 'El Hierro',
                    'country_code' => '',
                    'type' => 1,
                ),
            130 =>
                array (
                    'id' => 2357,
                    'region_code' => 'region.126',
                    'region_name' => 'Formentera',
                    'country_code' => '',
                    'type' => 1,
                ),
            131 =>
                array (
                    'id' => 2358,
                    'region_code' => 'region.127',
                    'region_name' => 'Fuerteventura',
                    'country_code' => '',
                    'type' => 1,
                ),
            132 =>
                array (
                    'id' => 2359,
                    'region_code' => 'region.128',
                    'region_name' => 'Gran Canaria',
                    'country_code' => '',
                    'type' => 1,
                ),
            133 =>
                array (
                    'id' => 2360,
                    'region_code' => 'region.129',
                    'region_name' => 'Ibiza',
                    'country_code' => '',
                    'type' => 1,
                ),
            134 =>
                array (
                    'id' => 2361,
                    'region_code' => 'region.130',
                    'region_name' => 'La Gomera',
                    'country_code' => '',
                    'type' => 1,
                ),
            135 =>
                array (
                    'id' => 2362,
                    'region_code' => 'region.131',
                    'region_name' => 'La Palma',
                    'country_code' => '',
                    'type' => 1,
                ),
            136 =>
                array (
                    'id' => 2363,
                    'region_code' => 'region.132,region.655',
                    'region_name' => 'Lanzarote',
                    'country_code' => '',
                    'type' => 1,
                ),
            137 =>
                array (
                    'id' => 2364,
                    'region_code' => 'region.133',
                    'region_name' => 'Mallorca',
                    'country_code' => '',
                    'type' => 1,
                ),
            138 =>
                array (
                    'id' => 2365,
                    'region_code' => 'region.134',
                    'region_name' => 'Menorca',
                    'country_code' => '',
                    'type' => 1,
                ),
            139 =>
                array (
                    'id' => 2366,
                    'region_code' => 'region.135',
                    'region_name' => 'Teneriffa',
                    'country_code' => '',
                    'type' => 1,
                ),
            140 =>
                array (
                    'id' => 2367,
                    'region_code' => 'region.136,region.100312',
                    'region_name' => 'Sri Lanka',
                    'country_code' => '',
                    'type' => 1,
                ),
            141 =>
                array (
                    'id' => 2368,
                    'region_code' => 'region.137',
                    'region_name' => 'Santa Lucia',
                    'country_code' => '',
                    'type' => 1,
                ),
            142 =>
                array (
                    'id' => 2369,
                    'region_code' => 'region.138',
                    'region_name' => 'Sansibar',
                    'country_code' => '',
                    'type' => 1,
                ),
            143 =>
                array (
                    'id' => 2370,
                    'region_code' => 'region.139',
                    'region_name' => 'Bangkok & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            144 =>
                array (
                    'id' => 2371,
                    'region_code' => 'region.140',
                    'region_name' => 'Isaan (Nordost-Thailand)',
                    'country_code' => '',
                    'type' => 1,
                ),
            145 =>
                array (
                    'id' => 2372,
                    'region_code' => 'region.140',
                    'region_name' => 'Nordthailand (Chiang Rai & Chiang Mai)',
                    'country_code' => '',
                    'type' => 1,
                ),
            146 =>
                array (
                    'id' => 2373,
                    'region_code' => 'region.141',
                    'region_name' => 'Krabi & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            147 =>
                array (
                    'id' => 2374,
                    'region_code' => 'region.142',
                    'region_name' => 'Trinidad & Tobago',
                    'country_code' => '',
                    'type' => 1,
                ),
            148 =>
                array (
                    'id' => 2376,
                    'region_code' => 'region.144',
                    'region_name' => 'Dalyan - Dalaman - Fethiye - Kas',
                    'country_code' => '',
                    'type' => 1,
                ),
            149 =>
                array (
                    'id' => 2377,
                    'region_code' => 'region.144',
                    'region_name' => 'Gümüldür - Kusadasi',
                    'country_code' => '',
                    'type' => 1,
                ),
            150 =>
                array (
                    'id' => 2378,
                    'region_code' => 'region.144',
                    'region_name' => 'Marmaris - Sarigerme - Icmeler',
                    'country_code' => '',
                    'type' => 1,
                ),
            151 =>
                array (
                    'id' => 2379,
                    'region_code' => 'region.147',
                    'region_name' => 'Istanbul & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            152 =>
                array (
                    'id' => 2380,
                    'region_code' => 'region.148',
                    'region_name' => 'Marmarameer',
                    'country_code' => '',
                    'type' => 1,
                ),
            153 =>
                array (
                    'id' => 2381,
                    'region_code' => 'region.148',
                    'region_name' => 'Ost-Thrakien & Marmarameer',
                    'country_code' => '',
                    'type' => 1,
                ),
            154 =>
                array (
                    'id' => 2383,
                    'region_code' => 'region.149',
                    'region_name' => 'Kemer - Beldibi',
                    'country_code' => '',
                    'type' => 1,
                ),
            155 =>
                array (
                    'id' => 2385,
                    'region_code' => 'region.149',
                    'region_name' => 'Türkische Riviera',
                    'country_code' => '',
                    'type' => 1,
                ),
            156 =>
                array (
                    'id' => 2386,
                    'region_code' => 'region.150',
                    'region_name' => 'Djerba & Oase Zarzis',
                    'country_code' => '',
                    'type' => 1,
                ),
            157 =>
                array (
                    'id' => 2387,
                    'region_code' => 'region.151',
                    'region_name' => 'Monastir & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            158 =>
                array (
                    'id' => 2388,
                    'region_code' => 'region.154,region.152',
                    'region_name' => 'Tunis & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            159 =>
                array (
                    'id' => 2389,
                    'region_code' => 'region.155',
                    'region_name' => 'Turks- und Caicos-Inseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            160 =>
                array (
                    'id' => 2390,
                    'region_code' => 'region.604,region.160,region.100235,region.100279',
                    'region_name' => 'V.A. Emirate - Dubai',
                    'country_code' => '',
                    'type' => 1,
                ),
            161 =>
                array (
                    'id' => 2391,
                    'region_code' => 'region.163',
                    'region_name' => 'Zypern Süd',
                    'country_code' => '',
                    'type' => 1,
                ),
            162 =>
                array (
                    'id' => 2392,
                    'region_code' => 'region.163',
                    'region_name' => 'Republik Zypern - Süden',
                    'country_code' => '',
                    'type' => 1,
                ),
            163 =>
                array (
                    'id' => 2393,
                    'region_code' => 'region.178',
                    'region_name' => 'Landesinnere',
                    'country_code' => '',
                    'type' => 1,
                ),
            164 =>
                array (
                    'id' => 2394,
                    'region_code' => 'region.194',
                    'region_name' => 'Monaco',
                    'country_code' => '',
                    'type' => 1,
                ),
            165 =>
                array (
                    'id' => 2395,
                    'region_code' => 'region.194',
                    'region_name' => 'Fürstentum Monaco',
                    'country_code' => '',
                    'type' => 1,
                ),
            166 =>
                array (
                    'id' => 2396,
                    'region_code' => 'region.214',
                    'region_name' => 'Luxemburg',
                    'country_code' => '',
                    'type' => 1,
                ),
            167 =>
                array (
                    'id' => 2397,
                    'region_code' => 'region.225,region.100287',
                    'region_name' => 'Singapur',
                    'country_code' => '',
                    'type' => 1,
                ),
            168 =>
                array (
                    'id' => 2398,
                    'region_code' => 'region.232',
                    'region_name' => 'Tschechische Republik - Adlergebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            169 =>
                array (
                    'id' => 2399,
                    'region_code' => 'region.232',
                    'region_name' => 'Tschechische Republik - Braunauer Bergland',
                    'country_code' => '',
                    'type' => 1,
                ),
            170 =>
                array (
                    'id' => 2400,
                    'region_code' => 'region.232',
                    'region_name' => 'Tschechische Republik - Kaiserwald',
                    'country_code' => '',
                    'type' => 1,
                ),
            171 =>
                array (
                    'id' => 2401,
                    'region_code' => 'region.232',
                    'region_name' => 'Tschechische Republik - Lausitzer Gebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            172 =>
                array (
                    'id' => 2402,
                    'region_code' => 'region.232',
                    'region_name' => 'Tschechische Republik - Mähren',
                    'country_code' => '',
                    'type' => 1,
                ),
            173 =>
                array (
                    'id' => 2403,
                    'region_code' => 'region.232',
                    'region_name' => 'Tschechische Republik - Westkarpaten',
                    'country_code' => '',
                    'type' => 1,
                ),
            174 =>
                array (
                    'id' => 2404,
                    'region_code' => 'region.250',
                    'region_name' => 'Uri',
                    'country_code' => '',
                    'type' => 1,
                ),
            175 =>
                array (
                    'id' => 2405,
                    'region_code' => 'region.250',
                    'region_name' => 'Vierwaldstätter See & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            176 =>
                array (
                    'id' => 2406,
                    'region_code' => 'region.250',
                    'region_name' => 'Zentralschweiz',
                    'country_code' => '',
                    'type' => 1,
                ),
            177 =>
                array (
                    'id' => 2407,
                    'region_code' => 'region.255',
                    'region_name' => 'Anguilla',
                    'country_code' => '',
                    'type' => 1,
                ),
            178 =>
                array (
                    'id' => 2408,
                    'region_code' => 'region.258',
                    'region_name' => 'Thessalien',
                    'country_code' => '',
                    'type' => 1,
                ),
            179 =>
                array (
                    'id' => 2409,
                    'region_code' => 'region.269',
                    'region_name' => 'Kenia - Küste',
                    'country_code' => '',
                    'type' => 1,
                ),
            180 =>
                array (
                    'id' => 2410,
                    'region_code' => 'region.283',
                    'region_name' => 'Rom & Latinum',
                    'country_code' => '',
                    'type' => 1,
                ),
            181 =>
                array (
                    'id' => 2412,
                    'region_code' => 'region.292',
                    'region_name' => 'Türkei Inland',
                    'country_code' => '',
                    'type' => 1,
                ),
            182 =>
                array (
                    'id' => 2413,
                    'region_code' => 'region.308',
                    'region_name' => 'Saint Vincent & die Grenadinen',
                    'country_code' => '',
                    'type' => 1,
                ),
            183 =>
                array (
                    'id' => 2414,
                    'region_code' => 'region.310',
                    'region_name' => 'Nothern Territory Darwin & weitere Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            184 =>
                array (
                    'id' => 2415,
                    'region_code' => 'region.312',
                    'region_name' => 'Tonga',
                    'country_code' => '',
                    'type' => 1,
                ),
            185 =>
                array (
                    'id' => 2416,
                    'region_code' => 'region.313',
                    'region_name' => 'Cook Inseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            186 =>
                array (
                    'id' => 2417,
                    'region_code' => 'region.316',
                    'region_name' => 'Philippinen',
                    'country_code' => '',
                    'type' => 1,
                ),
            187 =>
                array (
                    'id' => 2418,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Andaman & Nicobar Islands',
                    'country_code' => '',
                    'type' => 1,
                ),
            188 =>
                array (
                    'id' => 2419,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Andhra Pradesh',
                    'country_code' => '',
                    'type' => 1,
                ),
            189 =>
                array (
                    'id' => 2420,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Arunachal Pradesh',
                    'country_code' => '',
                    'type' => 1,
                ),
            190 =>
                array (
                    'id' => 2421,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Assam',
                    'country_code' => '',
                    'type' => 1,
                ),
            191 =>
                array (
                    'id' => 2422,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Bihar',
                    'country_code' => '',
                    'type' => 1,
                ),
            192 =>
                array (
                    'id' => 2423,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Chhattisgarh',
                    'country_code' => '',
                    'type' => 1,
                ),
            193 =>
                array (
                    'id' => 2424,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Dadra & Nagar Haveli',
                    'country_code' => '',
                    'type' => 1,
                ),
            194 =>
                array (
                    'id' => 2425,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Daman & Diu',
                    'country_code' => '',
                    'type' => 1,
                ),
            195 =>
                array (
                    'id' => 2426,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Gujarat',
                    'country_code' => '',
                    'type' => 1,
                ),
            196 =>
                array (
                    'id' => 2427,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Haryana',
                    'country_code' => '',
                    'type' => 1,
                ),
            197 =>
                array (
                    'id' => 2428,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Himachal Pradesh',
                    'country_code' => '',
                    'type' => 1,
                ),
            198 =>
                array (
                    'id' => 2429,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Jharkhand',
                    'country_code' => '',
                    'type' => 1,
                ),
            199 =>
                array (
                    'id' => 2430,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Karnataka',
                    'country_code' => '',
                    'type' => 1,
                ),
            200 =>
                array (
                    'id' => 2431,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Kashmir & Jammu',
                    'country_code' => '',
                    'type' => 1,
                ),
            201 =>
                array (
                    'id' => 2432,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Lakshadweep Islands',
                    'country_code' => '',
                    'type' => 1,
                ),
            202 =>
                array (
                    'id' => 2433,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Madhya Pradesh',
                    'country_code' => '',
                    'type' => 1,
                ),
            203 =>
                array (
                    'id' => 2434,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Manipur',
                    'country_code' => '',
                    'type' => 1,
                ),
            204 =>
                array (
                    'id' => 2435,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Meghalaya',
                    'country_code' => '',
                    'type' => 1,
                ),
            205 =>
                array (
                    'id' => 2436,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Mizoram',
                    'country_code' => '',
                    'type' => 1,
                ),
            206 =>
                array (
                    'id' => 2437,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Nagaland',
                    'country_code' => '',
                    'type' => 1,
                ),
            207 =>
                array (
                    'id' => 2438,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Orissa',
                    'country_code' => '',
                    'type' => 1,
                ),
            208 =>
                array (
                    'id' => 2439,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Punjab',
                    'country_code' => '',
                    'type' => 1,
                ),
            209 =>
                array (
                    'id' => 2440,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Rajasthan',
                    'country_code' => '',
                    'type' => 1,
                ),
            210 =>
                array (
                    'id' => 2441,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Sikkim',
                    'country_code' => '',
                    'type' => 1,
                ),
            211 =>
                array (
                    'id' => 2442,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Tripura',
                    'country_code' => '',
                    'type' => 1,
                ),
            212 =>
                array (
                    'id' => 2443,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Uttar Pradesh',
                    'country_code' => '',
                    'type' => 1,
                ),
            213 =>
                array (
                    'id' => 2444,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - Uttarakhand',
                    'country_code' => '',
                    'type' => 1,
                ),
            214 =>
                array (
                    'id' => 2445,
                    'region_code' => 'region.317',
                    'region_name' => 'Indien - West Bengal',
                    'country_code' => '',
                    'type' => 1,
                ),
            215 =>
                array (
                    'id' => 2446,
                    'region_code' => 'region.319',
                    'region_name' => 'Botswana',
                    'country_code' => '',
                    'type' => 1,
                ),
            216 =>
                array (
                    'id' => 2447,
                    'region_code' => 'region.320',
                    'region_name' => 'Simbabwe',
                    'country_code' => '',
                    'type' => 1,
                ),
            217 =>
                array (
                    'id' => 2448,
                    'region_code' => 'region.320',
                    'region_name' => 'Simbabwe - Nationalparks',
                    'country_code' => '',
                    'type' => 1,
                ),
            218 =>
                array (
                    'id' => 2449,
                    'region_code' => 'region.321,region.100345',
                    'region_name' => 'Sambia',
                    'country_code' => '',
                    'type' => 1,
                ),
            219 =>
                array (
                    'id' => 2450,
                    'region_code' => 'region.323,region.100319',
                    'region_name' => 'Vietnam',
                    'country_code' => '',
                    'type' => 1,
                ),
            220 =>
                array (
                    'id' => 2451,
                    'region_code' => 'region.337,region.100295',
                    'region_name' => 'Libanon',
                    'country_code' => '',
                    'type' => 1,
                ),
            221 =>
                array (
                    'id' => 2452,
                    'region_code' => 'region.340',
                    'region_name' => 'Südspitzen Keys',
                    'country_code' => '',
                    'type' => 1,
                ),
            222 =>
                array (
                    'id' => 2453,
                    'region_code' => 'region.342',
                    'region_name' => 'Bermuda',
                    'country_code' => '',
                    'type' => 1,
                ),
            223 =>
                array (
                    'id' => 2454,
                    'region_code' => 'region.344',
                    'region_name' => 'Guadeloupe',
                    'country_code' => '',
                    'type' => 1,
                ),
            224 =>
                array (
                    'id' => 2455,
                    'region_code' => 'region.346',
                    'region_name' => 'Martinique',
                    'country_code' => '',
                    'type' => 1,
                ),
            225 =>
                array (
                    'id' => 2456,
                    'region_code' => 'region.347',
                    'region_name' => 'Puerto Rico',
                    'country_code' => '',
                    'type' => 1,
                ),
            226 =>
                array (
                    'id' => 2457,
                    'region_code' => 'region.349,region.100281',
                    'region_name' => 'Taiwan',
                    'country_code' => '',
                    'type' => 1,
                ),
            227 =>
                array (
                    'id' => 2458,
                    'region_code' => 'region.350',
                    'region_name' => 'Südkorea',
                    'country_code' => '',
                    'type' => 1,
                ),
            228 =>
                array (
                    'id' => 2459,
                    'region_code' => 'region.352',
                    'region_name' => 'Katar',
                    'country_code' => '',
                    'type' => 1,
                ),
            229 =>
                array (
                    'id' => 2460,
                    'region_code' => 'region.353',
                    'region_name' => 'Bahrain',
                    'country_code' => '',
                    'type' => 1,
                ),
            230 =>
                array (
                    'id' => 2461,
                    'region_code' => 'region.354',
                    'region_name' => 'Kambodscha',
                    'country_code' => '',
                    'type' => 1,
                ),
            231 =>
                array (
                    'id' => 2462,
                    'region_code' => 'region.357',
                    'region_name' => 'Laos',
                    'country_code' => '',
                    'type' => 1,
                ),
            232 =>
                array (
                    'id' => 2463,
                    'region_code' => 'region.360',
                    'region_name' => 'Michigan',
                    'country_code' => '',
                    'type' => 1,
                ),
            233 =>
                array (
                    'id' => 2464,
                    'region_code' => 'region.361',
                    'region_name' => 'Wisconsin',
                    'country_code' => '',
                    'type' => 1,
                ),
            234 =>
                array (
                    'id' => 2465,
                    'region_code' => 'region.362',
                    'region_name' => 'Minnesota',
                    'country_code' => '',
                    'type' => 1,
                ),
            235 =>
                array (
                    'id' => 2466,
                    'region_code' => 'region.363',
                    'region_name' => 'North Dakota',
                    'country_code' => '',
                    'type' => 1,
                ),
            236 =>
                array (
                    'id' => 2467,
                    'region_code' => 'region.364',
                    'region_name' => 'South Dakota',
                    'country_code' => '',
                    'type' => 1,
                ),
            237 =>
                array (
                    'id' => 2468,
                    'region_code' => 'region.365',
                    'region_name' => 'Nebraska',
                    'country_code' => '',
                    'type' => 1,
                ),
            238 =>
                array (
                    'id' => 2469,
                    'region_code' => 'region.366',
                    'region_name' => 'Iowa',
                    'country_code' => '',
                    'type' => 1,
                ),
            239 =>
                array (
                    'id' => 2470,
                    'region_code' => 'region.367',
                    'region_name' => 'Illinois',
                    'country_code' => '',
                    'type' => 1,
                ),
            240 =>
                array (
                    'id' => 2471,
                    'region_code' => 'region.368',
                    'region_name' => 'Indiana',
                    'country_code' => '',
                    'type' => 1,
                ),
            241 =>
                array (
                    'id' => 2472,
                    'region_code' => 'region.369',
                    'region_name' => 'Ohio',
                    'country_code' => '',
                    'type' => 1,
                ),
            242 =>
                array (
                    'id' => 2473,
                    'region_code' => 'region.370',
                    'region_name' => 'Kentucky',
                    'country_code' => '',
                    'type' => 1,
                ),
            243 =>
                array (
                    'id' => 2474,
                    'region_code' => 'region.371',
                    'region_name' => 'Missouri',
                    'country_code' => '',
                    'type' => 1,
                ),
            244 =>
                array (
                    'id' => 2475,
                    'region_code' => 'region.372',
                    'region_name' => 'Kansas',
                    'country_code' => '',
                    'type' => 1,
                ),
            245 =>
                array (
                    'id' => 2476,
                    'region_code' => 'region.373',
                    'region_name' => 'Montana',
                    'country_code' => '',
                    'type' => 1,
                ),
            246 =>
                array (
                    'id' => 2477,
                    'region_code' => 'region.374',
                    'region_name' => 'Washington',
                    'country_code' => '',
                    'type' => 1,
                ),
            247 =>
                array (
                    'id' => 2478,
                    'region_code' => 'region.375',
                    'region_name' => 'Oregon',
                    'country_code' => '',
                    'type' => 1,
                ),
            248 =>
                array (
                    'id' => 2479,
                    'region_code' => 'region.376',
                    'region_name' => 'Idaho',
                    'country_code' => '',
                    'type' => 1,
                ),
            249 =>
                array (
                    'id' => 2480,
                    'region_code' => 'region.377',
                    'region_name' => 'Maine',
                    'country_code' => '',
                    'type' => 1,
                ),
            250 =>
                array (
                    'id' => 2481,
                    'region_code' => 'region.378',
                    'region_name' => 'New Hampshire',
                    'country_code' => '',
                    'type' => 1,
                ),
            251 =>
                array (
                    'id' => 2482,
                    'region_code' => 'region.379',
                    'region_name' => 'Vermont',
                    'country_code' => '',
                    'type' => 1,
                ),
            252 =>
                array (
                    'id' => 2483,
                    'region_code' => 'region.381',
                    'region_name' => 'Massachusetts',
                    'country_code' => '',
                    'type' => 1,
                ),
            253 =>
                array (
                    'id' => 2484,
                    'region_code' => 'region.382',
                    'region_name' => 'Rhode Island',
                    'country_code' => '',
                    'type' => 1,
                ),
            254 =>
                array (
                    'id' => 2485,
                    'region_code' => 'region.383',
                    'region_name' => 'Connecticut',
                    'country_code' => '',
                    'type' => 1,
                ),
            255 =>
                array (
                    'id' => 2486,
                    'region_code' => 'region.385',
                    'region_name' => 'Pennsylvania',
                    'country_code' => '',
                    'type' => 1,
                ),
            256 =>
                array (
                    'id' => 2487,
                    'region_code' => 'region.386',
                    'region_name' => 'Delaware',
                    'country_code' => '',
                    'type' => 1,
                ),
            257 =>
                array (
                    'id' => 2488,
                    'region_code' => 'region.387',
                    'region_name' => 'Maryland',
                    'country_code' => '',
                    'type' => 1,
                ),
            258 =>
                array (
                    'id' => 2489,
                    'region_code' => 'region.388',
                    'region_name' => 'Washington D.C.',
                    'country_code' => '',
                    'type' => 1,
                ),
            259 =>
                array (
                    'id' => 2490,
                    'region_code' => 'region.389',
                    'region_name' => 'West Virginia',
                    'country_code' => '',
                    'type' => 1,
                ),
            260 =>
                array (
                    'id' => 2491,
                    'region_code' => 'region.390',
                    'region_name' => 'Virginia',
                    'country_code' => '',
                    'type' => 1,
                ),
            261 =>
                array (
                    'id' => 2492,
                    'region_code' => 'region.391',
                    'region_name' => 'North Carolina',
                    'country_code' => '',
                    'type' => 1,
                ),
            262 =>
                array (
                    'id' => 2493,
                    'region_code' => 'region.392',
                    'region_name' => 'South Carolina',
                    'country_code' => '',
                    'type' => 1,
                ),
            263 =>
                array (
                    'id' => 2494,
                    'region_code' => 'region.393',
                    'region_name' => 'Tennessee',
                    'country_code' => '',
                    'type' => 1,
                ),
            264 =>
                array (
                    'id' => 2495,
                    'region_code' => 'region.394',
                    'region_name' => 'Arkansas',
                    'country_code' => '',
                    'type' => 1,
                ),
            265 =>
                array (
                    'id' => 2496,
                    'region_code' => 'region.395',
                    'region_name' => 'Texas',
                    'country_code' => '',
                    'type' => 1,
                ),
            266 =>
                array (
                    'id' => 2497,
                    'region_code' => 'region.396',
                    'region_name' => 'Louisiana',
                    'country_code' => '',
                    'type' => 1,
                ),
            267 =>
                array (
                    'id' => 2498,
                    'region_code' => 'region.397',
                    'region_name' => 'Mississippi',
                    'country_code' => '',
                    'type' => 1,
                ),
            268 =>
                array (
                    'id' => 2499,
                    'region_code' => 'region.398',
                    'region_name' => 'Alabama',
                    'country_code' => '',
                    'type' => 1,
                ),
            269 =>
                array (
                    'id' => 2500,
                    'region_code' => 'region.399',
                    'region_name' => 'Georgia',
                    'country_code' => '',
                    'type' => 1,
                ),
            270 =>
                array (
                    'id' => 2501,
                    'region_code' => 'region.401',
                    'region_name' => 'Colorado',
                    'country_code' => '',
                    'type' => 1,
                ),
            271 =>
                array (
                    'id' => 2502,
                    'region_code' => 'region.402',
                    'region_name' => 'Utah',
                    'country_code' => '',
                    'type' => 1,
                ),
            272 =>
                array (
                    'id' => 2503,
                    'region_code' => 'region.403',
                    'region_name' => 'Las Vegas',
                    'country_code' => '',
                    'type' => 1,
                ),
            273 =>
                array (
                    'id' => 2504,
                    'region_code' => 'region.403',
                    'region_name' => 'Nevada',
                    'country_code' => '',
                    'type' => 1,
                ),
            274 =>
                array (
                    'id' => 2505,
                    'region_code' => 'region.403',
                    'region_name' => 'Sierra Nevada',
                    'country_code' => '',
                    'type' => 1,
                ),
            275 =>
                array (
                    'id' => 2506,
                    'region_code' => 'region.404',
                    'region_name' => 'USA - Kalifornien',
                    'country_code' => '',
                    'type' => 1,
                ),
            276 =>
                array (
                    'id' => 2507,
                    'region_code' => 'region.404',
                    'region_name' => 'Kalifornien',
                    'country_code' => '',
                    'type' => 1,
                ),
            277 =>
                array (
                    'id' => 2508,
                    'region_code' => 'region.404',
                    'region_name' => 'Los Angeles',
                    'country_code' => '',
                    'type' => 1,
                ),
            278 =>
                array (
                    'id' => 2509,
                    'region_code' => 'region.404',
                    'region_name' => 'San Diego',
                    'country_code' => '',
                    'type' => 1,
                ),
            279 =>
                array (
                    'id' => 2510,
                    'region_code' => 'region.404',
                    'region_name' => 'San Francisco',
                    'country_code' => '',
                    'type' => 1,
                ),
            280 =>
                array (
                    'id' => 2511,
                    'region_code' => 'region.405',
                    'region_name' => 'Arizona',
                    'country_code' => '',
                    'type' => 1,
                ),
            281 =>
                array (
                    'id' => 2512,
                    'region_code' => 'region.406',
                    'region_name' => 'New Mexico',
                    'country_code' => '',
                    'type' => 1,
                ),
            282 =>
                array (
                    'id' => 2513,
                    'region_code' => 'region.408',
                    'region_name' => 'USA - Hawaii',
                    'country_code' => '',
                    'type' => 1,
                ),
            283 =>
                array (
                    'id' => 2514,
                    'region_code' => 'region.408',
                    'region_name' => 'Big Island',
                    'country_code' => '',
                    'type' => 1,
                ),
            284 =>
                array (
                    'id' => 2515,
                    'region_code' => 'region.408',
                    'region_name' => 'Kauai',
                    'country_code' => '',
                    'type' => 1,
                ),
            285 =>
                array (
                    'id' => 2516,
                    'region_code' => 'region.408',
                    'region_name' => 'Lanai',
                    'country_code' => '',
                    'type' => 1,
                ),
            286 =>
                array (
                    'id' => 2517,
                    'region_code' => 'region.408',
                    'region_name' => 'Maui',
                    'country_code' => '',
                    'type' => 1,
                ),
            287 =>
                array (
                    'id' => 2518,
                    'region_code' => 'region.408',
                    'region_name' => 'Molokai',
                    'country_code' => '',
                    'type' => 1,
                ),
            288 =>
                array (
                    'id' => 2519,
                    'region_code' => 'region.408',
                    'region_name' => 'Oahu (Honolulu)',
                    'country_code' => '',
                    'type' => 1,
                ),
            289 =>
                array (
                    'id' => 2520,
                    'region_code' => 'region.409',
                    'region_name' => 'Wyoming',
                    'country_code' => '',
                    'type' => 1,
                ),
            290 =>
                array (
                    'id' => 2521,
                    'region_code' => 'region.410',
                    'region_name' => 'Oklahoma',
                    'country_code' => '',
                    'type' => 1,
                ),
            291 =>
                array (
                    'id' => 2522,
                    'region_code' => 'region.430,region.100355',
                    'region_name' => 'Nepal - Kathmandu & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            292 =>
                array (
                    'id' => 2523,
                    'region_code' => 'region.431,region.100321',
                    'region_name' => 'Myanmar',
                    'country_code' => '',
                    'type' => 1,
                ),
            293 =>
                array (
                    'id' => 2524,
                    'region_code' => 'region.433',
                    'region_name' => 'Emilia Romagna',
                    'country_code' => '',
                    'type' => 1,
                ),
            294 =>
                array (
                    'id' => 2525,
                    'region_code' => 'region.437,region.100261',
                    'region_name' => 'Venetien',
                    'country_code' => '',
                    'type' => 1,
                ),
            295 =>
                array (
                    'id' => 2526,
                    'region_code' => 'region.440',
                    'region_name' => 'Basilikata',
                    'country_code' => '',
                    'type' => 1,
                ),
            296 =>
                array (
                    'id' => 2527,
                    'region_code' => 'region.442',
                    'region_name' => 'Belize',
                    'country_code' => '',
                    'type' => 1,
                ),
            297 =>
                array (
                    'id' => 2528,
                    'region_code' => 'region.443,region.100156',
                    'region_name' => 'Guatemala',
                    'country_code' => '',
                    'type' => 1,
                ),
            298 =>
                array (
                    'id' => 2529,
                    'region_code' => 'region.444',
                    'region_name' => 'Nicaragua',
                    'country_code' => '',
                    'type' => 1,
                ),
            299 =>
                array (
                    'id' => 2530,
                    'region_code' => 'region.445',
                    'region_name' => 'Honduras',
                    'country_code' => '',
                    'type' => 1,
                ),
            300 =>
                array (
                    'id' => 2531,
                    'region_code' => 'region.447',
                    'region_name' => 'Kolumbien',
                    'country_code' => '',
                    'type' => 1,
                ),
            301 =>
                array (
                    'id' => 2532,
                    'region_code' => 'region.448,region.100326',
                    'region_name' => 'Ecuador',
                    'country_code' => '',
                    'type' => 1,
                ),
            302 =>
                array (
                    'id' => 2533,
                    'region_code' => 'region.450',
                    'region_name' => 'Peru',
                    'country_code' => '',
                    'type' => 1,
                ),
            303 =>
                array (
                    'id' => 2534,
                    'region_code' => 'region.451',
                    'region_name' => 'Bolivien',
                    'country_code' => '',
                    'type' => 1,
                ),
            304 =>
                array (
                    'id' => 2535,
                    'region_code' => 'region.473',
                    'region_name' => 'Estland',
                    'country_code' => '',
                    'type' => 1,
                ),
            305 =>
                array (
                    'id' => 2536,
                    'region_code' => 'region.479',
                    'region_name' => 'Lettland',
                    'country_code' => '',
                    'type' => 1,
                ),
            306 =>
                array (
                    'id' => 2537,
                    'region_code' => 'region.480',
                    'region_name' => 'Litauen',
                    'country_code' => '',
                    'type' => 1,
                ),
            307 =>
                array (
                    'id' => 2538,
                    'region_code' => 'region.483',
                    'region_name' => 'Andorra',
                    'country_code' => '',
                    'type' => 1,
                ),
            308 =>
                array (
                    'id' => 2539,
                    'region_code' => 'region.483',
                    'region_name' => 'Fürstentum Andorra',
                    'country_code' => '',
                    'type' => 1,
                ),
            309 =>
                array (
                    'id' => 2540,
                    'region_code' => 'region.484',
                    'region_name' => 'Elfenbeinküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            310 =>
                array (
                    'id' => 2541,
                    'region_code' => 'region.485',
                    'region_name' => 'Samoa',
                    'country_code' => '',
                    'type' => 1,
                ),
            311 =>
                array (
                    'id' => 2542,
                    'region_code' => 'region.486',
                    'region_name' => 'Kuwait',
                    'country_code' => '',
                    'type' => 1,
                ),
            312 =>
                array (
                    'id' => 2543,
                    'region_code' => 'region.487',
                    'region_name' => 'Saint Kitts & Nevis',
                    'country_code' => '',
                    'type' => 1,
                ),
            313 =>
                array (
                    'id' => 2544,
                    'region_code' => 'region.488',
                    'region_name' => 'Äthiopien',
                    'country_code' => '',
                    'type' => 1,
                ),
            314 =>
                array (
                    'id' => 2545,
                    'region_code' => 'region.491',
                    'region_name' => 'Vorarlberg',
                    'country_code' => '',
                    'type' => 1,
                ),
            315 =>
                array (
                    'id' => 2546,
                    'region_code' => 'region.492,region.100090',
                    'region_name' => 'Salzburger Land',
                    'country_code' => '',
                    'type' => 1,
                ),
            316 =>
                array (
                    'id' => 2547,
                    'region_code' => 'region.493',
                    'region_name' => 'Oberösterreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            317 =>
                array (
                    'id' => 2548,
                    'region_code' => 'region.494',
                    'region_name' => 'Steiermark',
                    'country_code' => '',
                    'type' => 1,
                ),
            318 =>
                array (
                    'id' => 2549,
                    'region_code' => 'region.495',
                    'region_name' => 'Kärnten',
                    'country_code' => '',
                    'type' => 1,
                ),
            319 =>
                array (
                    'id' => 2550,
                    'region_code' => 'region.496',
                    'region_name' => 'Burgenland',
                    'country_code' => '',
                    'type' => 1,
                ),
            320 =>
                array (
                    'id' => 2551,
                    'region_code' => 'region.497',
                    'region_name' => 'Wallis',
                    'country_code' => '',
                    'type' => 1,
                ),
            321 =>
                array (
                    'id' => 2552,
                    'region_code' => 'region.498',
                    'region_name' => 'Graubünden',
                    'country_code' => '',
                    'type' => 1,
                ),
            322 =>
                array (
                    'id' => 2553,
                    'region_code' => 'region.499',
                    'region_name' => 'Bern & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            323 =>
                array (
                    'id' => 2554,
                    'region_code' => 'region.500',
                    'region_name' => 'Heidiland',
                    'country_code' => '',
                    'type' => 1,
                ),
            324 =>
                array (
                    'id' => 2555,
                    'region_code' => 'region.500',
                    'region_name' => 'Ostschweiz',
                    'country_code' => '',
                    'type' => 1,
                ),
            325 =>
                array (
                    'id' => 2556,
                    'region_code' => 'region.500',
                    'region_name' => 'Schaffhausen',
                    'country_code' => '',
                    'type' => 1,
                ),
            326 =>
                array (
                    'id' => 2557,
                    'region_code' => 'region.500',
                    'region_name' => 'Thurgau',
                    'country_code' => '',
                    'type' => 1,
                ),
            327 =>
                array (
                    'id' => 2558,
                    'region_code' => 'region.501',
                    'region_name' => 'Tessin',
                    'country_code' => '',
                    'type' => 1,
                ),
            328 =>
                array (
                    'id' => 2559,
                    'region_code' => 'region.504',
                    'region_name' => 'Pays de la Loire',
                    'country_code' => '',
                    'type' => 1,
                ),
            329 =>
                array (
                    'id' => 2560,
                    'region_code' => 'region.504',
                    'region_name' => 'Poitou Charentes',
                    'country_code' => '',
                    'type' => 1,
                ),
            330 =>
                array (
                    'id' => 2561,
                    'region_code' => 'region.505',
                    'region_name' => 'Korsika',
                    'country_code' => '',
                    'type' => 1,
                ),
            331 =>
                array (
                    'id' => 2562,
                    'region_code' => 'region.507',
                    'region_name' => 'Mittelmeerküste weitere Angebote',
                    'country_code' => '',
                    'type' => 1,
                ),
            332 =>
                array (
                    'id' => 2563,
                    'region_code' => 'region.518',
                    'region_name' => 'Alberta',
                    'country_code' => '',
                    'type' => 1,
                ),
            333 =>
                array (
                    'id' => 2564,
                    'region_code' => 'region.519',
                    'region_name' => 'British Columbia',
                    'country_code' => '',
                    'type' => 1,
                ),
            334 =>
                array (
                    'id' => 2565,
                    'region_code' => 'region.520',
                    'region_name' => 'Manitoba',
                    'country_code' => '',
                    'type' => 1,
                ),
            335 =>
                array (
                    'id' => 2566,
                    'region_code' => 'region.521',
                    'region_name' => 'New Brunswick',
                    'country_code' => '',
                    'type' => 1,
                ),
            336 =>
                array (
                    'id' => 2567,
                    'region_code' => 'region.522,region.528',
                    'region_name' => 'Ontario',
                    'country_code' => '',
                    'type' => 1,
                ),
            337 =>
                array (
                    'id' => 2568,
                    'region_code' => 'region.523',
                    'region_name' => 'Prince Edward Island',
                    'country_code' => '',
                    'type' => 1,
                ),
            338 =>
                array (
                    'id' => 2569,
                    'region_code' => 'region.524',
                    'region_name' => 'Quebec',
                    'country_code' => '',
                    'type' => 1,
                ),
            339 =>
                array (
                    'id' => 2570,
                    'region_code' => 'region.525',
                    'region_name' => 'Saskatchewan',
                    'country_code' => '',
                    'type' => 1,
                ),
            340 =>
                array (
                    'id' => 2571,
                    'region_code' => 'region.526',
                    'region_name' => 'Yukon',
                    'country_code' => '',
                    'type' => 1,
                ),
            341 =>
                array (
                    'id' => 2572,
                    'region_code' => 'region.527',
                    'region_name' => 'Nova Scotia',
                    'country_code' => '',
                    'type' => 1,
                ),
            342 =>
                array (
                    'id' => 2573,
                    'region_code' => 'region.559',
                    'region_name' => 'Schwarzmeerküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            343 =>
                array (
                    'id' => 2574,
                    'region_code' => 'region.559',
                    'region_name' => 'Schwarzmeerküste Türkei',
                    'country_code' => '',
                    'type' => 1,
                ),
            344 =>
                array (
                    'id' => 2575,
                    'region_code' => 'region.560,region.1031',
                    'region_name' => 'Hurghada - Safaga - El Gouna',
                    'country_code' => '',
                    'type' => 1,
                ),
            345 =>
                array (
                    'id' => 2576,
                    'region_code' => 'region.561',
                    'region_name' => 'Sharm El Sheikh - Taba - Dahab',
                    'country_code' => '',
                    'type' => 1,
                ),
            346 =>
                array (
                    'id' => 2577,
                    'region_code' => 'region.564',
                    'region_name' => 'Madagaskar',
                    'country_code' => '',
                    'type' => 1,
                ),
            347 =>
                array (
                    'id' => 2578,
                    'region_code' => 'region.565,region.100387',
                    'region_name' => 'Syrien',
                    'country_code' => '',
                    'type' => 1,
                ),
            348 =>
                array (
                    'id' => 2579,
                    'region_code' => 'region.568',
                    'region_name' => 'Neufundland',
                    'country_code' => '',
                    'type' => 1,
                ),
            349 =>
                array (
                    'id' => 2580,
                    'region_code' => 'region.571',
                    'region_name' => 'USA',
                    'country_code' => '',
                    'type' => 1,
                ),
            350 =>
                array (
                    'id' => 2581,
                    'region_code' => 'region.572',
                    'region_name' => 'Österreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            351 =>
                array (
                    'id' => 2582,
                    'region_code' => 'region.574',
                    'region_name' => 'Alpen',
                    'country_code' => '',
                    'type' => 1,
                ),
            352 =>
                array (
                    'id' => 2583,
                    'region_code' => 'region.574',
                    'region_name' => 'Genfersee & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            353 =>
                array (
                    'id' => 2584,
                    'region_code' => 'region.574',
                    'region_name' => 'Jura Gebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            354 =>
                array (
                    'id' => 2585,
                    'region_code' => 'region.577',
                    'region_name' => 'Brunei',
                    'country_code' => '',
                    'type' => 1,
                ),
            355 =>
                array (
                    'id' => 2586,
                    'region_code' => 'region.578,region.100318',
                    'region_name' => 'Usbekistan',
                    'country_code' => '',
                    'type' => 1,
                ),
            356 =>
                array (
                    'id' => 2587,
                    'region_code' => 'region.582,region.100335',
                    'region_name' => 'Iran',
                    'country_code' => '',
                    'type' => 1,
                ),
            357 =>
                array (
                    'id' => 2588,
                    'region_code' => 'region.583',
                    'region_name' => 'Jemen',
                    'country_code' => '',
                    'type' => 1,
                ),
            358 =>
                array (
                    'id' => 2589,
                    'region_code' => 'region.591',
                    'region_name' => 'Andalusien',
                    'country_code' => '',
                    'type' => 1,
                ),
            359 =>
                array (
                    'id' => 2590,
                    'region_code' => 'region.592',
                    'region_name' => 'Kanada',
                    'country_code' => '',
                    'type' => 1,
                ),
            360 =>
                array (
                    'id' => 2591,
                    'region_code' => 'region.597',
                    'region_name' => 'Queensland Brisbane & weitere Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            361 =>
                array (
                    'id' => 2592,
                    'region_code' => 'region.598',
                    'region_name' => 'New South Wales Sydney & weitere Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            362 =>
                array (
                    'id' => 2593,
                    'region_code' => 'region.599',
                    'region_name' => 'Victoria  Melborne & weitere Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            363 =>
                array (
                    'id' => 2594,
                    'region_code' => 'region.600',
                    'region_name' => 'Tasmanien Hobart & weitere Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            364 =>
                array (
                    'id' => 2595,
                    'region_code' => 'region.601',
                    'region_name' => 'South Australia Adelaide & weiter Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            365 =>
                array (
                    'id' => 2596,
                    'region_code' => 'region.602',
                    'region_name' => 'Western Australia Perth & weitere  Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            366 =>
                array (
                    'id' => 2597,
                    'region_code' => 'region.604',
                    'region_name' => 'V.A. Emirate - Abu Dhabi',
                    'country_code' => '',
                    'type' => 1,
                ),
            367 =>
                array (
                    'id' => 2598,
                    'region_code' => 'region.607',
                    'region_name' => 'V.A. Emirate - Umm Al Quwain',
                    'country_code' => '',
                    'type' => 1,
                ),
            368 =>
                array (
                    'id' => 2599,
                    'region_code' => 'region.608',
                    'region_name' => 'V.A. Emirate - Ras Al Khaimah',
                    'country_code' => '',
                    'type' => 1,
                ),
            369 =>
                array (
                    'id' => 2600,
                    'region_code' => 'region.609',
                    'region_name' => 'V.A. Emirate - Fujairah',
                    'country_code' => '',
                    'type' => 1,
                ),
            370 =>
                array (
                    'id' => 2601,
                    'region_code' => 'region.614',
                    'region_name' => 'Ligurien',
                    'country_code' => '',
                    'type' => 1,
                ),
            371 =>
                array (
                    'id' => 2602,
                    'region_code' => 'region.615',
                    'region_name' => 'Bayerische Alpen',
                    'country_code' => '',
                    'type' => 1,
                ),
            372 =>
                array (
                    'id' => 2603,
                    'region_code' => 'region.615',
                    'region_name' => 'Berchtesgadener Land',
                    'country_code' => '',
                    'type' => 1,
                ),
            373 =>
                array (
                    'id' => 2604,
                    'region_code' => 'region.615,region.100068',
                    'region_name' => 'Niederbayern',
                    'country_code' => '',
                    'type' => 1,
                ),
            374 =>
                array (
                    'id' => 2605,
                    'region_code' => 'region.616',
                    'region_name' => 'Baden-Württemberg',
                    'country_code' => '',
                    'type' => 1,
                ),
            375 =>
                array (
                    'id' => 2606,
                    'region_code' => 'region.616',
                    'region_name' => 'Baden-Württemberg',
                    'country_code' => '',
                    'type' => 1,
                ),
            376 =>
                array (
                    'id' => 2607,
                    'region_code' => 'region.617',
                    'region_name' => 'Münsterland',
                    'country_code' => '',
                    'type' => 1,
                ),
            377 =>
                array (
                    'id' => 2608,
                    'region_code' => 'region.617',
                    'region_name' => 'Nordrhein-Westfalen',
                    'country_code' => '',
                    'type' => 1,
                ),
            378 =>
                array (
                    'id' => 2610,
                    'region_code' => 'region.619',
                    'region_name' => 'Berlin',
                    'country_code' => '',
                    'type' => 1,
                ),
            379 =>
                array (
                    'id' => 2611,
                    'region_code' => 'region.619',
                    'region_name' => 'Brandenburg',
                    'country_code' => '',
                    'type' => 1,
                ),
            380 =>
                array (
                    'id' => 2612,
                    'region_code' => 'region.619',
                    'region_name' => 'Berlin',
                    'country_code' => '',
                    'type' => 1,
                ),
            381 =>
                array (
                    'id' => 2614,
                    'region_code' => 'region.622',
                    'region_name' => 'Hessen',
                    'country_code' => '',
                    'type' => 1,
                ),
            382 =>
                array (
                    'id' => 2617,
                    'region_code' => 'region.626',
                    'region_name' => 'Ruhrgebiet',
                    'country_code' => '',
                    'type' => 1,
                ),
            383 =>
                array (
                    'id' => 2619,
                    'region_code' => 'region.626',
                    'region_name' => 'Saarland',
                    'country_code' => '',
                    'type' => 1,
                ),
            384 =>
                array (
                    'id' => 2621,
                    'region_code' => 'region.627,region.100067',
                    'region_name' => 'Sachsen',
                    'country_code' => '',
                    'type' => 1,
                ),
            385 =>
                array (
                    'id' => 2623,
                    'region_code' => 'region.628',
                    'region_name' => 'Sachsen-Anhalt',
                    'country_code' => '',
                    'type' => 1,
                ),
            386 =>
                array (
                    'id' => 2625,
                    'region_code' => 'region.629',
                    'region_name' => 'Schleswig-Holstein',
                    'country_code' => '',
                    'type' => 1,
                ),
            387 =>
                array (
                    'id' => 2628,
                    'region_code' => 'region.630',
                    'region_name' => 'Thüringen und Thüringer Wald',
                    'country_code' => '',
                    'type' => 1,
                ),
            388 =>
                array (
                    'id' => 2629,
                    'region_code' => 'region.634',
                    'region_name' => 'Frankreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            389 =>
                array (
                    'id' => 2630,
                    'region_code' => 'region.635',
                    'region_name' => 'Bretagne',
                    'country_code' => '',
                    'type' => 1,
                ),
            390 =>
                array (
                    'id' => 2631,
                    'region_code' => 'region.636',
                    'region_name' => 'Nordfrankreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            391 =>
                array (
                    'id' => 2632,
                    'region_code' => 'region.637',
                    'region_name' => 'Nordzypern',
                    'country_code' => '',
                    'type' => 1,
                ),
            392 =>
                array (
                    'id' => 2633,
                    'region_code' => 'region.637',
                    'region_name' => 'Zypern Nord',
                    'country_code' => '',
                    'type' => 1,
                ),
            393 =>
                array (
                    'id' => 2634,
                    'region_code' => 'region.644',
                    'region_name' => 'Südafrika - Nationalparks',
                    'country_code' => '',
                    'type' => 1,
                ),
            394 =>
                array (
                    'id' => 2635,
                    'region_code' => 'region.645',
                    'region_name' => 'Südafrika  - Durban & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            395 =>
                array (
                    'id' => 2636,
                    'region_code' => 'region.646',
                    'region_name' => 'Südafrika - Westküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            396 =>
                array (
                    'id' => 2637,
                    'region_code' => 'region.647',
                    'region_name' => 'Südafrika - Landesinnere',
                    'country_code' => '',
                    'type' => 1,
                ),
            397 =>
                array (
                    'id' => 2638,
                    'region_code' => 'region.648',
                    'region_name' => 'Swasiland',
                    'country_code' => '',
                    'type' => 1,
                ),
            398 =>
                array (
                    'id' => 2639,
                    'region_code' => 'region.649',
                    'region_name' => 'Lesotho',
                    'country_code' => '',
                    'type' => 1,
                ),
            399 =>
                array (
                    'id' => 2640,
                    'region_code' => 'region.651',
                    'region_name' => 'Ägypten',
                    'country_code' => '',
                    'type' => 1,
                ),
            400 =>
                array (
                    'id' => 2641,
                    'region_code' => 'region.653',
                    'region_name' => 'Alentejo',
                    'country_code' => '',
                    'type' => 1,
                ),
            401 =>
                array (
                    'id' => 2642,
                    'region_code' => 'region.654,region.112',
                    'region_name' => 'Madeira - Porto Santo',
                    'country_code' => '',
                    'type' => 1,
                ),
            402 =>
                array (
                    'id' => 2643,
                    'region_code' => 'region.655',
                    'region_name' => 'La Graciosa',
                    'country_code' => '',
                    'type' => 1,
                ),
            403 =>
                array (
                    'id' => 2644,
                    'region_code' => 'region.659',
                    'region_name' => 'Brac & Süddalmatische Inseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            404 =>
                array (
                    'id' => 2645,
                    'region_code' => 'region.659',
                    'region_name' => 'Dalmatien',
                    'country_code' => '',
                    'type' => 1,
                ),
            405 =>
                array (
                    'id' => 2646,
                    'region_code' => 'region.676',
                    'region_name' => 'Dom. Republik Halbinsel Samana',
                    'country_code' => '',
                    'type' => 1,
                ),
            406 =>
                array (
                    'id' => 2647,
                    'region_code' => 'region.682',
                    'region_name' => 'China - Innere Mongolei',
                    'country_code' => '',
                    'type' => 1,
                ),
            407 =>
                array (
                    'id' => 2648,
                    'region_code' => 'region.682',
                    'region_name' => 'Mongolei',
                    'country_code' => '',
                    'type' => 1,
                ),
            408 =>
                array (
                    'id' => 2649,
                    'region_code' => 'region.700',
                    'region_name' => 'Niederösterreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            409 =>
                array (
                    'id' => 2650,
                    'region_code' => 'region.701',
                    'region_name' => 'Wien & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            410 =>
                array (
                    'id' => 2651,
                    'region_code' => 'region.704',
                    'region_name' => 'Golf von Almeria',
                    'country_code' => '',
                    'type' => 1,
                ),
            411 =>
                array (
                    'id' => 2652,
                    'region_code' => 'region.705',
                    'region_name' => 'Luzern & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            412 =>
                array (
                    'id' => 2653,
                    'region_code' => 'region.707',
                    'region_name' => 'Costa Blanca & Costa Calida',
                    'country_code' => '',
                    'type' => 1,
                ),
            413 =>
                array (
                    'id' => 2654,
                    'region_code' => 'region.708',
                    'region_name' => 'Costa Dorada',
                    'country_code' => '',
                    'type' => 1,
                ),
            414 =>
                array (
                    'id' => 2655,
                    'region_code' => 'region.710',
                    'region_name' => 'Dom. Republik',
                    'country_code' => '',
                    'type' => 1,
                ),
            415 =>
                array (
                    'id' => 2656,
                    'region_code' => 'region.714',
                    'region_name' => 'Nordwest Terretorien',
                    'country_code' => '',
                    'type' => 1,
                ),
            416 =>
                array (
                    'id' => 2657,
                    'region_code' => 'region.720',
                    'region_name' => 'Katalonien',
                    'country_code' => '',
                    'type' => 1,
                ),
            417 =>
                array (
                    'id' => 2658,
                    'region_code' => 'region.721',
                    'region_name' => 'Tschechische Republik - Riesengebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            418 =>
                array (
                    'id' => 2659,
                    'region_code' => 'region.723',
                    'region_name' => 'San Marino',
                    'country_code' => '',
                    'type' => 1,
                ),
            419 =>
                array (
                    'id' => 2660,
                    'region_code' => 'region.723',
                    'region_name' => 'Republik San Marino',
                    'country_code' => '',
                    'type' => 1,
                ),
            420 =>
                array (
                    'id' => 2661,
                    'region_code' => 'region.724,region.292',
                    'region_name' => 'Türkei',
                    'country_code' => '',
                    'type' => 1,
                ),
            421 =>
                array (
                    'id' => 2662,
                    'region_code' => 'region.725',
                    'region_name' => 'Portugal',
                    'country_code' => '',
                    'type' => 1,
                ),
            422 =>
                array (
                    'id' => 2663,
                    'region_code' => 'region.727',
                    'region_name' => 'Papua Neuguinea',
                    'country_code' => '',
                    'type' => 1,
                ),
            423 =>
                array (
                    'id' => 2664,
                    'region_code' => 'region.728',
                    'region_name' => 'Föderierte Staaten von Mikronesien',
                    'country_code' => '',
                    'type' => 1,
                ),
            424 =>
                array (
                    'id' => 2665,
                    'region_code' => 'region.733',
                    'region_name' => 'Costa del Azahar',
                    'country_code' => '',
                    'type' => 1,
                ),
            425 =>
                array (
                    'id' => 2666,
                    'region_code' => 'region.735',
                    'region_name' => 'Costa de la Luz',
                    'country_code' => '',
                    'type' => 1,
                ),
            426 =>
                array (
                    'id' => 2667,
                    'region_code' => 'region.736',
                    'region_name' => 'Costa del Sol & Costa Tropical',
                    'country_code' => '',
                    'type' => 1,
                ),
            427 =>
                array (
                    'id' => 2668,
                    'region_code' => 'region.737',
                    'region_name' => 'Murcia',
                    'country_code' => '',
                    'type' => 1,
                ),
            428 =>
                array (
                    'id' => 2669,
                    'region_code' => 'region.741',
                    'region_name' => 'Aragonien',
                    'country_code' => '',
                    'type' => 1,
                ),
            429 =>
                array (
                    'id' => 2670,
                    'region_code' => 'region.743',
                    'region_name' => 'Bulgarien',
                    'country_code' => '',
                    'type' => 1,
                ),
            430 =>
                array (
                    'id' => 2671,
                    'region_code' => 'region.744',
                    'region_name' => 'Schweiz',
                    'country_code' => '',
                    'type' => 1,
                ),
            431 =>
                array (
                    'id' => 2672,
                    'region_code' => 'region.745',
                    'region_name' => 'Griechenland Festland',
                    'country_code' => '',
                    'type' => 1,
                ),
            432 =>
                array (
                    'id' => 2673,
                    'region_code' => 'region.751',
                    'region_name' => 'Pyrenäen Frankreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            433 =>
                array (
                    'id' => 2674,
                    'region_code' => 'region.752',
                    'region_name' => 'Provence',
                    'country_code' => '',
                    'type' => 1,
                ),
            434 =>
                array (
                    'id' => 2675,
                    'region_code' => 'region.753',
                    'region_name' => 'Languedoc Roussillon',
                    'country_code' => '',
                    'type' => 1,
                ),
            435 =>
                array (
                    'id' => 2676,
                    'region_code' => 'region.754',
                    'region_name' => 'Normandie',
                    'country_code' => '',
                    'type' => 1,
                ),
            436 =>
                array (
                    'id' => 2677,
                    'region_code' => 'region.755',
                    'region_name' => 'Elsass - Lothringen',
                    'country_code' => '',
                    'type' => 1,
                ),
            437 =>
                array (
                    'id' => 2678,
                    'region_code' => 'region.770',
                    'region_name' => 'Ghana',
                    'country_code' => '',
                    'type' => 1,
                ),
            438 =>
                array (
                    'id' => 2679,
                    'region_code' => 'region.797',
                    'region_name' => 'Polen Masuren',
                    'country_code' => '',
                    'type' => 1,
                ),
            439 =>
                array (
                    'id' => 2680,
                    'region_code' => 'region.799',
                    'region_name' => 'Grönland',
                    'country_code' => '',
                    'type' => 1,
                ),
            440 =>
                array (
                    'id' => 2681,
                    'region_code' => 'region.800,region.802',
                    'region_name' => 'Schottland',
                    'country_code' => '',
                    'type' => 1,
                ),
            441 =>
                array (
                    'id' => 2682,
                    'region_code' => 'region.801',
                    'region_name' => 'Wales',
                    'country_code' => '',
                    'type' => 1,
                ),
            442 =>
                array (
                    'id' => 2683,
                    'region_code' => 'region.803',
                    'region_name' => 'Mosambik',
                    'country_code' => '',
                    'type' => 1,
                ),
            443 =>
                array (
                    'id' => 2684,
                    'region_code' => 'region.804',
                    'region_name' => 'Malawi',
                    'country_code' => '',
                    'type' => 1,
                ),
            444 =>
                array (
                    'id' => 2685,
                    'region_code' => 'region.812',
                    'region_name' => 'Venezuela - Isla Margarita',
                    'country_code' => '',
                    'type' => 1,
                ),
            445 =>
                array (
                    'id' => 2686,
                    'region_code' => 'region.813',
                    'region_name' => 'Dominica',
                    'country_code' => '',
                    'type' => 1,
                ),
            446 =>
                array (
                    'id' => 2687,
                    'region_code' => 'region.817',
                    'region_name' => 'Kasachstan',
                    'country_code' => '',
                    'type' => 1,
                ),
            447 =>
                array (
                    'id' => 2688,
                    'region_code' => 'region.819',
                    'region_name' => 'Hammamet & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            448 =>
                array (
                    'id' => 2689,
                    'region_code' => 'region.820',
                    'region_name' => 'Liechtenstein',
                    'country_code' => '',
                    'type' => 1,
                ),
            449 =>
                array (
                    'id' => 2690,
                    'region_code' => 'region.820',
                    'region_name' => 'Fürstentum Liechtenstein',
                    'country_code' => '',
                    'type' => 1,
                ),
            450 =>
                array (
                    'id' => 2691,
                    'region_code' => 'region.833',
                    'region_name' => 'Makedonien',
                    'country_code' => '',
                    'type' => 1,
                ),
            451 =>
                array (
                    'id' => 2692,
                    'region_code' => 'region.835',
                    'region_name' => 'Loire Tal',
                    'country_code' => '',
                    'type' => 1,
                ),
            452 =>
                array (
                    'id' => 2693,
                    'region_code' => 'region.838',
                    'region_name' => 'Neukaledonien',
                    'country_code' => '',
                    'type' => 1,
                ),
            453 =>
                array (
                    'id' => 2694,
                    'region_code' => 'region.844',
                    'region_name' => 'Komoren',
                    'country_code' => '',
                    'type' => 1,
                ),
            454 =>
                array (
                    'id' => 2695,
                    'region_code' => 'region.850',
                    'region_name' => 'Girona',
                    'country_code' => '',
                    'type' => 1,
                ),
            455 =>
                array (
                    'id' => 2696,
                    'region_code' => 'region.851',
                    'region_name' => 'Kanaren',
                    'country_code' => '',
                    'type' => 1,
                ),
            456 =>
                array (
                    'id' => 2697,
                    'region_code' => 'region.852',
                    'region_name' => 'Mersin - Adana - Antakya',
                    'country_code' => '',
                    'type' => 1,
                ),
            457 =>
                array (
                    'id' => 2698,
                    'region_code' => 'region.852',
                    'region_name' => 'Mersin - Adana - Antalya',
                    'country_code' => '',
                    'type' => 1,
                ),
            458 =>
                array (
                    'id' => 2699,
                    'region_code' => 'region.854',
                    'region_name' => 'Auvergne',
                    'country_code' => '',
                    'type' => 1,
                ),
            459 =>
                array (
                    'id' => 2700,
                    'region_code' => 'region.857',
                    'region_name' => 'Castellon',
                    'country_code' => '',
                    'type' => 1,
                ),
            460 =>
                array (
                    'id' => 2701,
                    'region_code' => 'region.858',
                    'region_name' => 'Basel & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            461 =>
                array (
                    'id' => 2702,
                    'region_code' => 'region.859',
                    'region_name' => 'Georgien',
                    'country_code' => '',
                    'type' => 1,
                ),
            462 =>
                array (
                    'id' => 2703,
                    'region_code' => 'region.860',
                    'region_name' => 'Aserbaidschan',
                    'country_code' => '',
                    'type' => 1,
                ),
            463 =>
                array (
                    'id' => 2704,
                    'region_code' => 'region.861',
                    'region_name' => 'Weißrussland',
                    'country_code' => '',
                    'type' => 1,
                ),
            464 =>
                array (
                    'id' => 2705,
                    'region_code' => 'region.862',
                    'region_name' => 'Vanuatu',
                    'country_code' => '',
                    'type' => 1,
                ),
            465 =>
                array (
                    'id' => 2706,
                    'region_code' => 'region.863',
                    'region_name' => 'Bhutan',
                    'country_code' => '',
                    'type' => 1,
                ),
            466 =>
                array (
                    'id' => 2707,
                    'region_code' => 'region.866',
                    'region_name' => 'Moldawien',
                    'country_code' => '',
                    'type' => 1,
                ),
            467 =>
                array (
                    'id' => 2708,
                    'region_code' => 'region.867',
                    'region_name' => 'Kirgistan',
                    'country_code' => '',
                    'type' => 1,
                ),
            468 =>
                array (
                    'id' => 2709,
                    'region_code' => 'region.868',
                    'region_name' => 'Armenien',
                    'country_code' => '',
                    'type' => 1,
                ),
            469 =>
                array (
                    'id' => 2710,
                    'region_code' => 'region.871',
                    'region_name' => 'Afghanistan',
                    'country_code' => '',
                    'type' => 1,
                ),
            470 =>
                array (
                    'id' => 2711,
                    'region_code' => 'region.873',
                    'region_name' => 'Mazedonien',
                    'country_code' => '',
                    'type' => 1,
                ),
            471 =>
                array (
                    'id' => 2712,
                    'region_code' => 'region.874',
                    'region_name' => 'Pakistan',
                    'country_code' => '',
                    'type' => 1,
                ),
            472 =>
                array (
                    'id' => 2713,
                    'region_code' => 'region.877',
                    'region_name' => 'Pyrenäen Spanien',
                    'country_code' => '',
                    'type' => 1,
                ),
            473 =>
                array (
                    'id' => 2714,
                    'region_code' => 'region.878',
                    'region_name' => 'Guyana',
                    'country_code' => '',
                    'type' => 1,
                ),
            474 =>
                array (
                    'id' => 2715,
                    'region_code' => 'region.879',
                    'region_name' => 'Cayman Inseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            475 =>
                array (
                    'id' => 2716,
                    'region_code' => 'region.882',
                    'region_name' => 'Indien - Kerala',
                    'country_code' => '',
                    'type' => 1,
                ),
            476 =>
                array (
                    'id' => 2717,
                    'region_code' => 'region.884',
                    'region_name' => 'Kamerun',
                    'country_code' => '',
                    'type' => 1,
                ),
            477 =>
                array (
                    'id' => 2718,
                    'region_code' => 'region.885',
                    'region_name' => 'Nigeria',
                    'country_code' => '',
                    'type' => 1,
                ),
            478 =>
                array (
                    'id' => 2719,
                    'region_code' => 'region.886',
                    'region_name' => 'Saudi-Arabien',
                    'country_code' => '',
                    'type' => 1,
                ),
            479 =>
                array (
                    'id' => 2720,
                    'region_code' => 'region.887',
                    'region_name' => 'Sudan',
                    'country_code' => '',
                    'type' => 1,
                ),
            480 =>
                array (
                    'id' => 2721,
                    'region_code' => 'region.890',
                    'region_name' => 'Algerien',
                    'country_code' => '',
                    'type' => 1,
                ),
            481 =>
                array (
                    'id' => 2722,
                    'region_code' => 'region.896',
                    'region_name' => 'Eritrea',
                    'country_code' => '',
                    'type' => 1,
                ),
            482 =>
                array (
                    'id' => 2723,
                    'region_code' => 'region.897',
                    'region_name' => 'Mali',
                    'country_code' => '',
                    'type' => 1,
                ),
            483 =>
                array (
                    'id' => 2724,
                    'region_code' => 'region.899',
                    'region_name' => 'Burundi',
                    'country_code' => '',
                    'type' => 1,
                ),
            484 =>
                array (
                    'id' => 2725,
                    'region_code' => 'region.900',
                    'region_name' => 'Gibraltar',
                    'country_code' => '',
                    'type' => 1,
                ),
            485 =>
                array (
                    'id' => 2726,
                    'region_code' => 'region.903',
                    'region_name' => 'Guinea',
                    'country_code' => '',
                    'type' => 1,
                ),
            486 =>
                array (
                    'id' => 2727,
                    'region_code' => 'region.904',
                    'region_name' => 'Benin',
                    'country_code' => '',
                    'type' => 1,
                ),
            487 =>
                array (
                    'id' => 2728,
                    'region_code' => 'region.905',
                    'region_name' => 'Dschibuti',
                    'country_code' => '',
                    'type' => 1,
                ),
            488 =>
                array (
                    'id' => 2729,
                    'region_code' => 'region.908',
                    'region_name' => 'Phuket & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            489 =>
                array (
                    'id' => 2730,
                    'region_code' => 'region.910',
                    'region_name' => 'Indonesien - Sulawesi',
                    'country_code' => '',
                    'type' => 1,
                ),
            490 =>
                array (
                    'id' => 2731,
                    'region_code' => 'region.911',
                    'region_name' => 'Bosnien-Herzegovina',
                    'country_code' => '',
                    'type' => 1,
                ),
            491 =>
                array (
                    'id' => 2732,
                    'region_code' => 'region.912',
                    'region_name' => 'Indonesien - Sumatra',
                    'country_code' => '',
                    'type' => 1,
                ),
            492 =>
                array (
                    'id' => 2733,
                    'region_code' => 'region.915',
                    'region_name' => 'Uganda',
                    'country_code' => '',
                    'type' => 1,
                ),
            493 =>
                array (
                    'id' => 2734,
                    'region_code' => 'region.918',
                    'region_name' => 'Albanien',
                    'country_code' => '',
                    'type' => 1,
                ),
            494 =>
                array (
                    'id' => 2735,
                    'region_code' => 'region.919',
                    'region_name' => 'El Salvador',
                    'country_code' => '',
                    'type' => 1,
                ),
            495 =>
                array (
                    'id' => 2736,
                    'region_code' => 'region.920',
                    'region_name' => 'Somalia',
                    'country_code' => '',
                    'type' => 1,
                ),
            496 =>
                array (
                    'id' => 2737,
                    'region_code' => 'region.922',
                    'region_name' => 'Costa Brava',
                    'country_code' => '',
                    'type' => 1,
                ),
            497 =>
                array (
                    'id' => 2738,
                    'region_code' => 'region.924',
                    'region_name' => 'Olympische Riviera',
                    'country_code' => '',
                    'type' => 1,
                ),
            498 =>
                array (
                    'id' => 2739,
                    'region_code' => 'region.927',
                    'region_name' => 'Zentralthailand (Rayong & Kanchanaburi)',
                    'country_code' => '',
                    'type' => 1,
                ),
            499 =>
                array (
                    'id' => 2740,
                    'region_code' => 'region.929',
                    'region_name' => 'Südostthailand (Pattaya)',
                    'country_code' => '',
                    'type' => 1,
                ),
        ));
    }
}
