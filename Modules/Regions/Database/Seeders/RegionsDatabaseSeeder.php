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

        DB::table('Regions')->insert(array (
            0 =>
                array (
                    'id' => 2741,
                    'region_code' => 'region.932',
                    'region_name' => 'Westthailand (Hua Hin - Cha Am)',
                    'country_code' => '',
                    'type' => 1,
                ),
            1 =>
                array (
                    'id' => 2742,
                    'region_code' => 'region.934',
                    'region_name' => 'Khao Lak & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            2 =>
                array (
                    'id' => 2743,
                    'region_code' => 'region.935',
                    'region_name' => 'Madrid & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            3 =>
                array (
                    'id' => 2744,
                    'region_code' => 'region.936',
                    'region_name' => 'Republik Niger',
                    'country_code' => '',
                    'type' => 1,
                ),
            4 =>
                array (
                    'id' => 2745,
                    'region_code' => 'region.940',
                    'region_name' => 'Cote d´Azur',
                    'country_code' => '',
                    'type' => 1,
                ),
            5 =>
                array (
                    'id' => 2746,
                    'region_code' => 'region.944',
                    'region_name' => 'Nordirland',
                    'country_code' => '',
                    'type' => 1,
                ),
            6 =>
                array (
                    'id' => 2747,
                    'region_code' => 'region.947',
                    'region_name' => 'Friaul',
                    'country_code' => '',
                    'type' => 1,
                ),
            7 =>
                array (
                    'id' => 2748,
                    'region_code' => 'region.948',
                    'region_name' => 'Ruanda',
                    'country_code' => '',
                    'type' => 1,
                ),
            8 =>
                array (
                    'id' => 2749,
                    'region_code' => 'region.953',
                    'region_name' => 'Guam',
                    'country_code' => '',
                    'type' => 1,
                ),
            9 =>
                array (
                    'id' => 2750,
                    'region_code' => 'region.959',
                    'region_name' => 'Montserrat',
                    'country_code' => '',
                    'type' => 1,
                ),
            10 =>
                array (
                    'id' => 2751,
                    'region_code' => 'region.960',
                    'region_name' => 'Kappadokien',
                    'country_code' => '',
                    'type' => 1,
                ),
            11 =>
                array (
                    'id' => 2752,
                    'region_code' => 'region.960',
                    'region_name' => 'Kappadokien',
                    'country_code' => '',
                    'type' => 1,
                ),
            12 =>
                array (
                    'id' => 2753,
                    'region_code' => 'region.973',
                    'region_name' => 'Indien - Tamil Nadu',
                    'country_code' => '',
                    'type' => 1,
                ),
            13 =>
                array (
                    'id' => 2754,
                    'region_code' => 'region.986',
                    'region_name' => 'Indien - Maharashtra - Mumbai',
                    'country_code' => '',
                    'type' => 1,
                ),
            14 =>
                array (
                    'id' => 2755,
                    'region_code' => 'region.991',
                    'region_name' => 'Indien - New Delhi',
                    'country_code' => '',
                    'type' => 1,
                ),
            15 =>
                array (
                    'id' => 2756,
                    'region_code' => 'region.992',
                    'region_name' => 'Indien - Goa',
                    'country_code' => '',
                    'type' => 1,
                ),
            16 =>
                array (
                    'id' => 2757,
                    'region_code' => 'region.995',
                    'region_name' => 'Indonesien - Molukken',
                    'country_code' => '',
                    'type' => 1,
                ),
            17 =>
                array (
                    'id' => 2758,
                    'region_code' => 'region.996',
                    'region_name' => 'Palau',
                    'country_code' => '',
                    'type' => 1,
                ),
            18 =>
                array (
                    'id' => 2759,
                    'region_code' => 'region.997',
                    'region_name' => 'Mauretanien',
                    'country_code' => '',
                    'type' => 1,
                ),
            19 =>
                array (
                    'id' => 2760,
                    'region_code' => 'region.1001',
                    'region_name' => 'Tirol',
                    'country_code' => '',
                    'type' => 1,
                ),
            20 =>
                array (
                    'id' => 2761,
                    'region_code' => 'region.1007',
                    'region_name' => 'Insel Elba',
                    'country_code' => '',
                    'type' => 1,
                ),
            21 =>
                array (
                    'id' => 2762,
                    'region_code' => 'region.1009',
                    'region_name' => 'Nordkorea',
                    'country_code' => '',
                    'type' => 1,
                ),
            22 =>
                array (
                    'id' => 2763,
                    'region_code' => 'region.1012',
                    'region_name' => 'Sierra Leone',
                    'country_code' => '',
                    'type' => 1,
                ),
            23 =>
                array (
                    'id' => 2764,
                    'region_code' => 'region.1013',
                    'region_name' => 'Aruba',
                    'country_code' => '',
                    'type' => 1,
                ),
            24 =>
                array (
                    'id' => 2765,
                    'region_code' => 'region.1022',
                    'region_name' => 'Tschad',
                    'country_code' => '',
                    'type' => 1,
                ),
            25 =>
                array (
                    'id' => 2766,
                    'region_code' => 'region.1023',
                    'region_name' => 'Togo',
                    'country_code' => '',
                    'type' => 1,
                ),
            26 =>
                array (
                    'id' => 2767,
                    'region_code' => 'region.1024',
                    'region_name' => 'Gabun',
                    'country_code' => '',
                    'type' => 1,
                ),
            27 =>
                array (
                    'id' => 2768,
                    'region_code' => 'region.1027',
                    'region_name' => 'Jalisco',
                    'country_code' => '',
                    'type' => 1,
                ),
            28 =>
                array (
                    'id' => 2769,
                    'region_code' => 'region.1027',
                    'region_name' => 'Pazifikküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            29 =>
                array (
                    'id' => 2770,
                    'region_code' => 'region.1027',
                    'region_name' => 'Puerto Vallarta & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            30 =>
                array (
                    'id' => 2771,
                    'region_code' => 'region.1027,region.100168',
                    'region_name' => 'Baja California',
                    'country_code' => '',
                    'type' => 1,
                ),
            31 =>
                array (
                    'id' => 2772,
                    'region_code' => 'region.1028',
                    'region_name' => 'Assuan - Luxor - Libysche Wüste',
                    'country_code' => '',
                    'type' => 1,
                ),
            32 =>
                array (
                    'id' => 2773,
                    'region_code' => 'region.1030',
                    'region_name' => 'Alexandria - Marsa Matruh - El Alamein',
                    'country_code' => '',
                    'type' => 1,
                ),
            33 =>
                array (
                    'id' => 2775,
                    'region_code' => 'region.1032',
                    'region_name' => 'Marsa Alam - Quseir - Port Ghalib',
                    'country_code' => '',
                    'type' => 1,
                ),
            34 =>
                array (
                    'id' => 2776,
                    'region_code' => 'region.1036',
                    'region_name' => 'Amalfiküste - Golf von Neapel',
                    'country_code' => '',
                    'type' => 1,
                ),
            35 =>
                array (
                    'id' => 2777,
                    'region_code' => 'region.1037',
                    'region_name' => 'Burkina Faso',
                    'country_code' => '',
                    'type' => 1,
                ),
            36 =>
                array (
                    'id' => 2778,
                    'region_code' => 'region.1038',
                    'region_name' => 'Tunesien Inland',
                    'country_code' => '',
                    'type' => 1,
                ),
            37 =>
                array (
                    'id' => 2779,
                    'region_code' => 'region.1045',
                    'region_name' => 'Umbrien',
                    'country_code' => '',
                    'type' => 1,
                ),
            38 =>
                array (
                    'id' => 2780,
                    'region_code' => 'region.1051',
                    'region_name' => 'Serbien & Kosovo',
                    'country_code' => '',
                    'type' => 1,
                ),
            39 =>
                array (
                    'id' => 2781,
                    'region_code' => 'region.1052,region.100397',
                    'region_name' => 'Montenegro',
                    'country_code' => '',
                    'type' => 1,
                ),
            40 =>
                array (
                    'id' => 2782,
                    'region_code' => 'region.1053',
                    'region_name' => 'Angola',
                    'country_code' => '',
                    'type' => 1,
                ),
            41 =>
                array (
                    'id' => 2783,
                    'region_code' => 'region.1054',
                    'region_name' => 'Demokratischen Republik Kongo',
                    'country_code' => '',
                    'type' => 1,
                ),
            42 =>
                array (
                    'id' => 2784,
                    'region_code' => 'region.1055',
                    'region_name' => 'Republik Kongo',
                    'country_code' => '',
                    'type' => 1,
                ),
            43 =>
                array (
                    'id' => 2785,
                    'region_code' => 'region.1056',
                    'region_name' => 'Republik Liberia',
                    'country_code' => '',
                    'type' => 1,
                ),
            44 =>
                array (
                    'id' => 2786,
                    'region_code' => 'region.1064',
                    'region_name' => 'Zentralafrikanische Republik',
                    'country_code' => '',
                    'type' => 1,
                ),
            45 =>
                array (
                    'id' => 2787,
                    'region_code' => 'region.1075',
                    'region_name' => 'Nunavut',
                    'country_code' => '',
                    'type' => 1,
                ),
            46 =>
                array (
                    'id' => 2788,
                    'region_code' => 'region.1078',
                    'region_name' => 'Indonesien - Timor',
                    'country_code' => '',
                    'type' => 1,
                ),
            47 =>
                array (
                    'id' => 2789,
                    'region_code' => 'region.1079',
                    'region_name' => 'Indonesien - Java',
                    'country_code' => '',
                    'type' => 1,
                ),
            48 =>
                array (
                    'id' => 2790,
                    'region_code' => 'region.1080',
                    'region_name' => 'Indonesien - Borneo',
                    'country_code' => '',
                    'type' => 1,
                ),
            49 =>
                array (
                    'id' => 2791,
                    'region_code' => 'region.1081',
                    'region_name' => 'Indonesien - Neuguinea',
                    'country_code' => '',
                    'type' => 1,
                ),
            50 =>
                array (
                    'id' => 2792,
                    'region_code' => 'region.1082',
                    'region_name' => 'Irak',
                    'country_code' => '',
                    'type' => 1,
                ),
            51 =>
                array (
                    'id' => 2793,
                    'region_code' => 'region.1083,region.1084',
                    'region_name' => 'Bali & Lombok',
                    'country_code' => '',
                    'type' => 1,
                ),
            52 =>
                array (
                    'id' => 2794,
                    'region_code' => 'region.1085',
                    'region_name' => 'Indonesien - Sumbawa',
                    'country_code' => '',
                    'type' => 1,
                ),
            53 =>
                array (
                    'id' => 2795,
                    'region_code' => 'region.1086',
                    'region_name' => 'Indonesien - Flores',
                    'country_code' => '',
                    'type' => 1,
                ),
            54 =>
                array (
                    'id' => 2796,
                    'region_code' => 'region.1087',
                    'region_name' => 'Indonesien - Riau Kepulauan',
                    'country_code' => '',
                    'type' => 1,
                ),
            55 =>
                array (
                    'id' => 2797,
                    'region_code' => 'region.1093',
                    'region_name' => 'American Samoa',
                    'country_code' => '',
                    'type' => 1,
                ),
            56 =>
                array (
                    'id' => 2798,
                    'region_code' => 'region.1095',
                    'region_name' => 'Osttimor',
                    'country_code' => '',
                    'type' => 1,
                ),
            57 =>
                array (
                    'id' => 2799,
                    'region_code' => 'region.1096',
                    'region_name' => 'Wallis & Futuna ',
                    'country_code' => '',
                    'type' => 1,
                ),
            58 =>
                array (
                    'id' => 2800,
                    'region_code' => 'region.1099',
                    'region_name' => 'Capri',
                    'country_code' => '',
                    'type' => 1,
                ),
            59 =>
                array (
                    'id' => 2801,
                    'region_code' => 'region.1100',
                    'region_name' => 'Südafrika - Südküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            60 =>
                array (
                    'id' => 2802,
                    'region_code' => 'region.1101',
                    'region_name' => 'Äquatorial Guinea',
                    'country_code' => '',
                    'type' => 1,
                ),
            61 =>
                array (
                    'id' => 2803,
                    'region_code' => 'region.1108',
                    'region_name' => 'Istrien',
                    'country_code' => '',
                    'type' => 1,
                ),
            62 =>
                array (
                    'id' => 2804,
                    'region_code' => 'region.1110',
                    'region_name' => 'Marianen Inseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            63 =>
                array (
                    'id' => 2805,
                    'region_code' => 'region.1119',
                    'region_name' => 'Koh Samui',
                    'country_code' => '',
                    'type' => 1,
                ),
            64 =>
                array (
                    'id' => 2806,
                    'region_code' => 'region.1133',
                    'region_name' => 'Aquitanien - Perigord',
                    'country_code' => '',
                    'type' => 1,
                ),
            65 =>
                array (
                    'id' => 2807,
                    'region_code' => 'region.1164',
                    'region_name' => 'Brasilien - Rio de Janeiro & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            66 =>
                array (
                    'id' => 2808,
                    'region_code' => 'region.1168',
                    'region_name' => 'China - Osten',
                    'country_code' => '',
                    'type' => 1,
                ),
            67 =>
                array (
                    'id' => 2809,
                    'region_code' => 'region.1169',
                    'region_name' => 'China - Ostküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            68 =>
                array (
                    'id' => 2810,
                    'region_code' => 'region.1170',
                    'region_name' => 'China - Südküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            69 =>
                array (
                    'id' => 2811,
                    'region_code' => 'region.1171',
                    'region_name' => 'China - Tibet',
                    'country_code' => '',
                    'type' => 1,
                ),
            70 =>
                array (
                    'id' => 2812,
                    'region_code' => 'region.1172',
                    'region_name' => 'China - Zentralchina',
                    'country_code' => '',
                    'type' => 1,
                ),
            71 =>
                array (
                    'id' => 2813,
                    'region_code' => 'region.1179',
                    'region_name' => 'China - Süden',
                    'country_code' => '',
                    'type' => 1,
                ),
            72 =>
                array (
                    'id' => 2814,
                    'region_code' => 'region.1180',
                    'region_name' => 'China - Insel Hainan',
                    'country_code' => '',
                    'type' => 1,
                ),
            73 =>
                array (
                    'id' => 2815,
                    'region_code' => 'region.1182',
                    'region_name' => 'Tadschikistan',
                    'country_code' => '',
                    'type' => 1,
                ),
            74 =>
                array (
                    'id' => 2816,
                    'region_code' => 'region.1185',
                    'region_name' => 'Russland Ostseeküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            75 =>
                array (
                    'id' => 2817,
                    'region_code' => 'region.1186',
                    'region_name' => 'Russland Moskau & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            76 =>
                array (
                    'id' => 2818,
                    'region_code' => 'region.1196',
                    'region_name' => 'Färöer Inseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            77 =>
                array (
                    'id' => 2819,
                    'region_code' => 'region.100000',
                    'region_name' => 'Balearen',
                    'country_code' => '',
                    'type' => 1,
                ),
            78 =>
                array (
                    'id' => 2820,
                    'region_code' => 'region.100002',
                    'region_name' => 'Griechische Inseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            79 =>
                array (
                    'id' => 2821,
                    'region_code' => 'region.100007',
                    'region_name' => 'Italien',
                    'country_code' => '',
                    'type' => 1,
                ),
            80 =>
                array (
                    'id' => 2822,
                    'region_code' => 'region.100008',
                    'region_name' => 'Tunesien',
                    'country_code' => '',
                    'type' => 1,
                ),
            81 =>
                array (
                    'id' => 2823,
                    'region_code' => 'region.100009',
                    'region_name' => 'Osteuropa',
                    'country_code' => '',
                    'type' => 1,
                ),
            82 =>
                array (
                    'id' => 2824,
                    'region_code' => 'region.100010',
                    'region_name' => 'Großbritannien & Irland',
                    'country_code' => '',
                    'type' => 1,
                ),
            83 =>
                array (
                    'id' => 2825,
                    'region_code' => 'region.100012',
                    'region_name' => 'Benelux',
                    'country_code' => '',
                    'type' => 1,
                ),
            84 =>
                array (
                    'id' => 2826,
                    'region_code' => 'region.100015',
                    'region_name' => 'Afrika',
                    'country_code' => '',
                    'type' => 1,
                ),
            85 =>
                array (
                    'id' => 2827,
                    'region_code' => 'region.100016',
                    'region_name' => 'Indischer Ozean',
                    'country_code' => '',
                    'type' => 1,
                ),
            86 =>
                array (
                    'id' => 2828,
                    'region_code' => 'region.100017',
                    'region_name' => 'Karibik',
                    'country_code' => '',
                    'type' => 1,
                ),
            87 =>
                array (
                    'id' => 2829,
                    'region_code' => 'region.100018',
                    'region_name' => 'Mittelamerika',
                    'country_code' => '',
                    'type' => 1,
                ),
            88 =>
                array (
                    'id' => 2830,
                    'region_code' => 'region.100019',
                    'region_name' => 'Südamerika',
                    'country_code' => '',
                    'type' => 1,
                ),
            89 =>
                array (
                    'id' => 2831,
                    'region_code' => 'region.100020',
                    'region_name' => 'Asien',
                    'country_code' => '',
                    'type' => 1,
                ),
            90 =>
                array (
                    'id' => 2832,
                    'region_code' => 'region.100021',
                    'region_name' => 'Australien',
                    'country_code' => '',
                    'type' => 1,
                ),
            91 =>
                array (
                    'id' => 2833,
                    'region_code' => 'region.100022',
                    'region_name' => 'Südsee',
                    'country_code' => '',
                    'type' => 1,
                ),
            92 =>
                array (
                    'id' => 2834,
                    'region_code' => 'region.100023',
                    'region_name' => 'Kvarner Bucht & Adriatische Küste',
                    'country_code' => '',
                    'type' => 1,
                ),
            93 =>
                array (
                    'id' => 2835,
                    'region_code' => 'region.100023,region.1109',
                    'region_name' => 'Inland  (Zagreb)',
                    'country_code' => '',
                    'type' => 1,
                ),
            94 =>
                array (
                    'id' => 2836,
                    'region_code' => 'region.100025',
                    'region_name' => 'Atlantikküste weitere Angebote Frankreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            95 =>
                array (
                    'id' => 2837,
                    'region_code' => 'region.100025',
                    'region_name' => 'Asturien',
                    'country_code' => '',
                    'type' => 1,
                ),
            96 =>
                array (
                    'id' => 2838,
                    'region_code' => 'region.100025',
                    'region_name' => 'Atlantikküste weitere Angebote Spanien',
                    'country_code' => '',
                    'type' => 1,
                ),
            97 =>
                array (
                    'id' => 2839,
                    'region_code' => 'region.100025',
                    'region_name' => 'Baskenland',
                    'country_code' => '',
                    'type' => 1,
                ),
            98 =>
                array (
                    'id' => 2840,
                    'region_code' => 'region.100025',
                    'region_name' => 'Galicien',
                    'country_code' => '',
                    'type' => 1,
                ),
            99 =>
                array (
                    'id' => 2841,
                    'region_code' => 'region.100025',
                    'region_name' => 'Kantabrien',
                    'country_code' => '',
                    'type' => 1,
                ),
            100 =>
                array (
                    'id' => 2842,
                    'region_code' => 'region.100026',
                    'region_name' => 'Kastilien',
                    'country_code' => '',
                    'type' => 1,
                ),
            101 =>
                array (
                    'id' => 2843,
                    'region_code' => 'region.100027',
                    'region_name' => 'Barcelona & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            102 =>
                array (
                    'id' => 2844,
                    'region_code' => 'region.100028',
                    'region_name' => 'La Rioja',
                    'country_code' => '',
                    'type' => 1,
                ),
            103 =>
                array (
                    'id' => 2845,
                    'region_code' => 'region.100028',
                    'region_name' => 'Navarra',
                    'country_code' => '',
                    'type' => 1,
                ),
            104 =>
                array (
                    'id' => 2846,
                    'region_code' => 'region.100029',
                    'region_name' => 'Aostatal',
                    'country_code' => '',
                    'type' => 1,
                ),
            105 =>
                array (
                    'id' => 2847,
                    'region_code' => 'region.100029',
                    'region_name' => 'Piemont',
                    'country_code' => '',
                    'type' => 1,
                ),
            106 =>
                array (
                    'id' => 2848,
                    'region_code' => 'region.100030',
                    'region_name' => 'Ötztal',
                    'country_code' => '',
                    'type' => 1,
                ),
            107 =>
                array (
                    'id' => 2849,
                    'region_code' => 'region.100030',
                    'region_name' => 'Stubaital',
                    'country_code' => '',
                    'type' => 1,
                ),
            108 =>
                array (
                    'id' => 2850,
                    'region_code' => 'region.100030,region.100032',
                    'region_name' => 'Südtirol - Dolomiten - Alpen',
                    'country_code' => '',
                    'type' => 1,
                ),
            109 =>
                array (
                    'id' => 2851,
                    'region_code' => 'region.100031',
                    'region_name' => 'Toskana',
                    'country_code' => '',
                    'type' => 1,
                ),
            110 =>
                array (
                    'id' => 2852,
                    'region_code' => 'region.100033',
                    'region_name' => 'Kampanien',
                    'country_code' => '',
                    'type' => 1,
                ),
            111 =>
                array (
                    'id' => 2853,
                    'region_code' => 'region.100034',
                    'region_name' => 'Abruzzen',
                    'country_code' => '',
                    'type' => 1,
                ),
            112 =>
                array (
                    'id' => 2854,
                    'region_code' => 'region.100035',
                    'region_name' => 'Malta',
                    'country_code' => '',
                    'type' => 1,
                ),
            113 =>
                array (
                    'id' => 2855,
                    'region_code' => 'region.100036',
                    'region_name' => 'Amorgos',
                    'country_code' => '',
                    'type' => 1,
                ),
            114 =>
                array (
                    'id' => 2856,
                    'region_code' => 'region.100036',
                    'region_name' => 'Andros',
                    'country_code' => '',
                    'type' => 1,
                ),
            115 =>
                array (
                    'id' => 2857,
                    'region_code' => 'region.100036',
                    'region_name' => 'Folegandros',
                    'country_code' => '',
                    'type' => 1,
                ),
            116 =>
                array (
                    'id' => 2858,
                    'region_code' => 'region.100036',
                    'region_name' => 'Ios',
                    'country_code' => '',
                    'type' => 1,
                ),
            117 =>
                array (
                    'id' => 2859,
                    'region_code' => 'region.100036',
                    'region_name' => 'Kea',
                    'country_code' => '',
                    'type' => 1,
                ),
            118 =>
                array (
                    'id' => 2860,
                    'region_code' => 'region.100036',
                    'region_name' => 'Kimolos',
                    'country_code' => '',
                    'type' => 1,
                ),
            119 =>
                array (
                    'id' => 2861,
                    'region_code' => 'region.100036',
                    'region_name' => 'Kykladen Inseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            120 =>
                array (
                    'id' => 2862,
                    'region_code' => 'region.100036',
                    'region_name' => 'Kythnos',
                    'country_code' => '',
                    'type' => 1,
                ),
            121 =>
                array (
                    'id' => 2863,
                    'region_code' => 'region.100036',
                    'region_name' => 'Milos',
                    'country_code' => '',
                    'type' => 1,
                ),
            122 =>
                array (
                    'id' => 2864,
                    'region_code' => 'region.100036',
                    'region_name' => 'Naxos',
                    'country_code' => '',
                    'type' => 1,
                ),
            123 =>
                array (
                    'id' => 2865,
                    'region_code' => 'region.100036',
                    'region_name' => 'Paros',
                    'country_code' => '',
                    'type' => 1,
                ),
            124 =>
                array (
                    'id' => 2866,
                    'region_code' => 'region.100036',
                    'region_name' => 'Santorini',
                    'country_code' => '',
                    'type' => 1,
                ),
            125 =>
                array (
                    'id' => 2867,
                    'region_code' => 'region.100036',
                    'region_name' => 'Serifos',
                    'country_code' => '',
                    'type' => 1,
                ),
            126 =>
                array (
                    'id' => 2868,
                    'region_code' => 'region.100036',
                    'region_name' => 'Sifnos',
                    'country_code' => '',
                    'type' => 1,
                ),
            127 =>
                array (
                    'id' => 2869,
                    'region_code' => 'region.100036',
                    'region_name' => 'Syros',
                    'country_code' => '',
                    'type' => 1,
                ),
            128 =>
                array (
                    'id' => 2870,
                    'region_code' => 'region.100036',
                    'region_name' => 'Tinos',
                    'country_code' => '',
                    'type' => 1,
                ),
            129 =>
                array (
                    'id' => 2871,
                    'region_code' => 'region.100037',
                    'region_name' => 'Astypalea',
                    'country_code' => '',
                    'type' => 1,
                ),
            130 =>
                array (
                    'id' => 2872,
                    'region_code' => 'region.100037',
                    'region_name' => 'Chalki',
                    'country_code' => '',
                    'type' => 1,
                ),
            131 =>
                array (
                    'id' => 2873,
                    'region_code' => 'region.100037',
                    'region_name' => 'Kalymnos',
                    'country_code' => '',
                    'type' => 1,
                ),
            132 =>
                array (
                    'id' => 2874,
                    'region_code' => 'region.100037',
                    'region_name' => 'Karpathos',
                    'country_code' => '',
                    'type' => 1,
                ),
            133 =>
                array (
                    'id' => 2875,
                    'region_code' => 'region.100037',
                    'region_name' => 'Leros',
                    'country_code' => '',
                    'type' => 1,
                ),
            134 =>
                array (
                    'id' => 2876,
                    'region_code' => 'region.100037',
                    'region_name' => 'Lipsi',
                    'country_code' => '',
                    'type' => 1,
                ),
            135 =>
                array (
                    'id' => 2877,
                    'region_code' => 'region.100037',
                    'region_name' => 'Megisti',
                    'country_code' => '',
                    'type' => 1,
                ),
            136 =>
                array (
                    'id' => 2878,
                    'region_code' => 'region.100037',
                    'region_name' => 'Nisyros',
                    'country_code' => '',
                    'type' => 1,
                ),
            137 =>
                array (
                    'id' => 2879,
                    'region_code' => 'region.100037',
                    'region_name' => 'Patmos',
                    'country_code' => '',
                    'type' => 1,
                ),
            138 =>
                array (
                    'id' => 2880,
                    'region_code' => 'region.100037',
                    'region_name' => 'Symi',
                    'country_code' => '',
                    'type' => 1,
                ),
            139 =>
                array (
                    'id' => 2881,
                    'region_code' => 'region.100037',
                    'region_name' => 'Telendos',
                    'country_code' => '',
                    'type' => 1,
                ),
            140 =>
                array (
                    'id' => 2882,
                    'region_code' => 'region.100037',
                    'region_name' => 'Tilos',
                    'country_code' => '',
                    'type' => 1,
                ),
            141 =>
                array (
                    'id' => 2883,
                    'region_code' => 'region.100038',
                    'region_name' => 'Alonissos',
                    'country_code' => '',
                    'type' => 1,
                ),
            142 =>
                array (
                    'id' => 2884,
                    'region_code' => 'region.100038',
                    'region_name' => 'Skopelos',
                    'country_code' => '',
                    'type' => 1,
                ),
            143 =>
                array (
                    'id' => 2885,
                    'region_code' => 'region.100038',
                    'region_name' => 'Skyros',
                    'country_code' => '',
                    'type' => 1,
                ),
            144 =>
                array (
                    'id' => 2886,
                    'region_code' => 'region.100039',
                    'region_name' => 'Samos',
                    'country_code' => '',
                    'type' => 1,
                ),
            145 =>
                array (
                    'id' => 2887,
                    'region_code' => 'region.100040',
                    'region_name' => 'Chios',
                    'country_code' => '',
                    'type' => 1,
                ),
            146 =>
                array (
                    'id' => 2888,
                    'region_code' => 'region.100040',
                    'region_name' => 'Fourni',
                    'country_code' => '',
                    'type' => 1,
                ),
            147 =>
                array (
                    'id' => 2889,
                    'region_code' => 'region.100040',
                    'region_name' => 'Ikaria',
                    'country_code' => '',
                    'type' => 1,
                ),
            148 =>
                array (
                    'id' => 2890,
                    'region_code' => 'region.100040',
                    'region_name' => 'Limnos',
                    'country_code' => '',
                    'type' => 1,
                ),
            149 =>
                array (
                    'id' => 2891,
                    'region_code' => 'region.100040',
                    'region_name' => 'Samothraki',
                    'country_code' => '',
                    'type' => 1,
                ),
            150 =>
                array (
                    'id' => 2892,
                    'region_code' => 'region.100041',
                    'region_name' => 'Saronischer Golf',
                    'country_code' => '',
                    'type' => 1,
                ),
            151 =>
                array (
                    'id' => 2893,
                    'region_code' => 'region.100041',
                    'region_name' => 'Ägina',
                    'country_code' => '',
                    'type' => 1,
                ),
            152 =>
                array (
                    'id' => 2894,
                    'region_code' => 'region.100041',
                    'region_name' => 'Hydra',
                    'country_code' => '',
                    'type' => 1,
                ),
            153 =>
                array (
                    'id' => 2895,
                    'region_code' => 'region.100041',
                    'region_name' => 'Poros',
                    'country_code' => '',
                    'type' => 1,
                ),
            154 =>
                array (
                    'id' => 2896,
                    'region_code' => 'region.100041',
                    'region_name' => 'Spetses',
                    'country_code' => '',
                    'type' => 1,
                ),
            155 =>
                array (
                    'id' => 2897,
                    'region_code' => 'region.100042',
                    'region_name' => 'Ithaka',
                    'country_code' => '',
                    'type' => 1,
                ),
            156 =>
                array (
                    'id' => 2898,
                    'region_code' => 'region.100042',
                    'region_name' => 'Kefalonia',
                    'country_code' => '',
                    'type' => 1,
                ),
            157 =>
                array (
                    'id' => 2899,
                    'region_code' => 'region.100042',
                    'region_name' => 'Kythira',
                    'country_code' => '',
                    'type' => 1,
                ),
            158 =>
                array (
                    'id' => 2900,
                    'region_code' => 'region.100042',
                    'region_name' => 'Lefkada (Lefkas)',
                    'country_code' => '',
                    'type' => 1,
                ),
            159 =>
                array (
                    'id' => 2901,
                    'region_code' => 'region.100042',
                    'region_name' => 'Paxos & Andipaxos',
                    'country_code' => '',
                    'type' => 1,
                ),
            160 =>
                array (
                    'id' => 2902,
                    'region_code' => 'region.100043',
                    'region_name' => 'Mittelgriechenland',
                    'country_code' => '',
                    'type' => 1,
                ),
            161 =>
                array (
                    'id' => 2903,
                    'region_code' => 'region.100043',
                    'region_name' => 'Parnass Gebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            162 =>
                array (
                    'id' => 2904,
                    'region_code' => 'region.100044,region.100045',
                    'region_name' => 'Costa Verde - Porto',
                    'country_code' => '',
                    'type' => 1,
                ),
            163 =>
                array (
                    'id' => 2905,
                    'region_code' => 'region.100046',
                    'region_name' => 'Costa de Prata',
                    'country_code' => '',
                    'type' => 1,
                ),
            164 =>
                array (
                    'id' => 2906,
                    'region_code' => 'region.100049',
                    'region_name' => 'Bodrum',
                    'country_code' => '',
                    'type' => 1,
                ),
            165 =>
                array (
                    'id' => 2907,
                    'region_code' => 'region.100049,region.144',
                    'region_name' => 'Türkische Ägäis & Halbinsel Bodrum',
                    'country_code' => '',
                    'type' => 1,
                ),
            166 =>
                array (
                    'id' => 2908,
                    'region_code' => 'region.100050',
                    'region_name' => 'Ceuta & Melilla',
                    'country_code' => '',
                    'type' => 1,
                ),
            167 =>
                array (
                    'id' => 2909,
                    'region_code' => 'region.100051',
                    'region_name' => 'Atlantikküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            168 =>
                array (
                    'id' => 2910,
                    'region_code' => 'region.100052',
                    'region_name' => 'Marokko Mittelmeerküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            169 =>
                array (
                    'id' => 2911,
                    'region_code' => 'region.100053',
                    'region_name' => 'Marokko Inland',
                    'country_code' => '',
                    'type' => 1,
                ),
            170 =>
                array (
                    'id' => 2912,
                    'region_code' => 'region.100054',
                    'region_name' => 'Marrakesch',
                    'country_code' => '',
                    'type' => 1,
                ),
            171 =>
                array (
                    'id' => 2913,
                    'region_code' => 'region.100055',
                    'region_name' => 'Oase Tozeur',
                    'country_code' => '',
                    'type' => 1,
                ),
            172 =>
                array (
                    'id' => 2914,
                    'region_code' => 'region.100056',
                    'region_name' => 'Kairo - Gizeh - Memphis',
                    'country_code' => '',
                    'type' => 1,
                ),
            173 =>
                array (
                    'id' => 2915,
                    'region_code' => 'region.100057',
                    'region_name' => 'Jura',
                    'country_code' => '',
                    'type' => 1,
                ),
            174 =>
                array (
                    'id' => 2916,
                    'region_code' => 'region.100058',
                    'region_name' => 'Mittelland weitere Angebote',
                    'country_code' => '',
                    'type' => 1,
                ),
            175 =>
                array (
                    'id' => 2917,
                    'region_code' => 'region.100059,region.100060',
                    'region_name' => 'Genfer See & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            176 =>
                array (
                    'id' => 2918,
                    'region_code' => 'region.100061',
                    'region_name' => 'Zürich & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            177 =>
                array (
                    'id' => 2921,
                    'region_code' => 'region.100063',
                    'region_name' => 'Ostseeinseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            178 =>
                array (
                    'id' => 2922,
                    'region_code' => 'region.100063,region.100062',
                    'region_name' => 'Ostseeküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            179 =>
                array (
                    'id' => 2924,
                    'region_code' => 'region.100065',
                    'region_name' => 'Insel Sylt',
                    'country_code' => '',
                    'type' => 1,
                ),
            180 =>
                array (
                    'id' => 2925,
                    'region_code' => 'region.100065',
                    'region_name' => 'Nordseeinseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            181 =>
                array (
                    'id' => 2926,
                    'region_code' => 'region.100065,region.100064',
                    'region_name' => 'Nordseeküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            182 =>
                array (
                    'id' => 2927,
                    'region_code' => 'region.100066',
                    'region_name' => 'Lüneburger Heide',
                    'country_code' => '',
                    'type' => 1,
                ),
            183 =>
                array (
                    'id' => 2928,
                    'region_code' => 'region.100067',
                    'region_name' => 'Sächsische Schweiz & Erzgebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            184 =>
                array (
                    'id' => 2929,
                    'region_code' => 'region.100068',
                    'region_name' => 'Bayerischer & Oberpfälzer Wald',
                    'country_code' => '',
                    'type' => 1,
                ),
            185 =>
                array (
                    'id' => 2930,
                    'region_code' => 'region.100069',
                    'region_name' => 'Franken',
                    'country_code' => '',
                    'type' => 1,
                ),
            186 =>
                array (
                    'id' => 2932,
                    'region_code' => 'region.100069',
                    'region_name' => 'Frankenwald & Fichtelgebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            187 =>
                array (
                    'id' => 2933,
                    'region_code' => 'region.100070',
                    'region_name' => 'Allgäu',
                    'country_code' => '',
                    'type' => 1,
                ),
            188 =>
                array (
                    'id' => 2934,
                    'region_code' => 'region.100070',
                    'region_name' => 'Bayerisch-Schwaben',
                    'country_code' => '',
                    'type' => 1,
                ),
            189 =>
                array (
                    'id' => 2935,
                    'region_code' => 'region.100070',
                    'region_name' => 'Allgäu',
                    'country_code' => '',
                    'type' => 1,
                ),
            190 =>
                array (
                    'id' => 2936,
                    'region_code' => 'region.100071',
                    'region_name' => 'Oberpfalz',
                    'country_code' => '',
                    'type' => 1,
                ),
            191 =>
                array (
                    'id' => 2938,
                    'region_code' => 'region.100071',
                    'region_name' => 'Schwarzwald',
                    'country_code' => '',
                    'type' => 1,
                ),
            192 =>
                array (
                    'id' => 2939,
                    'region_code' => 'region.100072',
                    'region_name' => 'Bodensee & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            193 =>
                array (
                    'id' => 2940,
                    'region_code' => 'region.100072',
                    'region_name' => 'Bodensee & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            194 =>
                array (
                    'id' => 2942,
                    'region_code' => 'region.100073',
                    'region_name' => 'Rhein-Main Region',
                    'country_code' => '',
                    'type' => 1,
                ),
            195 =>
                array (
                    'id' => 2943,
                    'region_code' => 'region.100074',
                    'region_name' => 'Mosel-Saar Region',
                    'country_code' => '',
                    'type' => 1,
                ),
            196 =>
                array (
                    'id' => 2944,
                    'region_code' => 'region.100074,region.625',
                    'region_name' => 'Rheinland-Pfalz',
                    'country_code' => '',
                    'type' => 1,
                ),
            197 =>
                array (
                    'id' => 2945,
                    'region_code' => 'region.100075',
                    'region_name' => 'Eifel - Taunus - Hunsrück',
                    'country_code' => '',
                    'type' => 1,
                ),
            198 =>
                array (
                    'id' => 2948,
                    'region_code' => 'region.100076',
                    'region_name' => 'Sauerland',
                    'country_code' => '',
                    'type' => 1,
                ),
            199 =>
                array (
                    'id' => 2949,
                    'region_code' => 'region.100077',
                    'region_name' => 'Emsland',
                    'country_code' => '',
                    'type' => 1,
                ),
            200 =>
                array (
                    'id' => 2950,
                    'region_code' => 'region.100078',
                    'region_name' => 'Mecklenburg-Vorpommern & Seenplatte',
                    'country_code' => '',
                    'type' => 1,
                ),
            201 =>
                array (
                    'id' => 2952,
                    'region_code' => 'region.100079',
                    'region_name' => 'Insel Usedom',
                    'country_code' => '',
                    'type' => 1,
                ),
            202 =>
                array (
                    'id' => 2954,
                    'region_code' => 'region.100080',
                    'region_name' => 'Insel Rügen',
                    'country_code' => '',
                    'type' => 1,
                ),
            203 =>
                array (
                    'id' => 2956,
                    'region_code' => 'region.100081',
                    'region_name' => 'Harz',
                    'country_code' => '',
                    'type' => 1,
                ),
            204 =>
                array (
                    'id' => 2958,
                    'region_code' => 'region.100082',
                    'region_name' => 'Bremen',
                    'country_code' => '',
                    'type' => 1,
                ),
            205 =>
                array (
                    'id' => 2959,
                    'region_code' => 'region.100082',
                    'region_name' => 'Hamburg',
                    'country_code' => '',
                    'type' => 1,
                ),
            206 =>
                array (
                    'id' => 2961,
                    'region_code' => 'region.100084',
                    'region_name' => 'Köln & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            207 =>
                array (
                    'id' => 2962,
                    'region_code' => 'region.100085',
                    'region_name' => 'München & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            208 =>
                array (
                    'id' => 2963,
                    'region_code' => 'region.100088',
                    'region_name' => 'Nordtirol',
                    'country_code' => '',
                    'type' => 1,
                ),
            209 =>
                array (
                    'id' => 2964,
                    'region_code' => 'region.100088',
                    'region_name' => 'Olympia Region Seefeld',
                    'country_code' => '',
                    'type' => 1,
                ),
            210 =>
                array (
                    'id' => 2965,
                    'region_code' => 'region.100089',
                    'region_name' => 'Tirol Ost',
                    'country_code' => '',
                    'type' => 1,
                ),
            211 =>
                array (
                    'id' => 2966,
                    'region_code' => 'region.100089',
                    'region_name' => 'Zillertal',
                    'country_code' => '',
                    'type' => 1,
                ),
            212 =>
                array (
                    'id' => 2967,
                    'region_code' => 'region.100091',
                    'region_name' => 'Polnische Ostseeküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            213 =>
                array (
                    'id' => 2968,
                    'region_code' => 'region.100096',
                    'region_name' => 'Paris & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            214 =>
                array (
                    'id' => 2969,
                    'region_code' => 'region.100099',
                    'region_name' => 'Champagne Ardenne',
                    'country_code' => '',
                    'type' => 1,
                ),
            215 =>
                array (
                    'id' => 2970,
                    'region_code' => 'region.100099',
                    'region_name' => 'Picardie',
                    'country_code' => '',
                    'type' => 1,
                ),
            216 =>
                array (
                    'id' => 2971,
                    'region_code' => 'region.100100,region.175',
                    'region_name' => 'Belgien',
                    'country_code' => '',
                    'type' => 1,
                ),
            217 =>
                array (
                    'id' => 2972,
                    'region_code' => 'region.100110',
                    'region_name' => 'Guernsey & St.Anne',
                    'country_code' => '',
                    'type' => 1,
                ),
            218 =>
                array (
                    'id' => 2973,
                    'region_code' => 'region.100110',
                    'region_name' => 'Jersey',
                    'country_code' => '',
                    'type' => 1,
                ),
            219 =>
                array (
                    'id' => 2974,
                    'region_code' => 'region.100137',
                    'region_name' => 'Sonnenstrand',
                    'country_code' => '',
                    'type' => 1,
                ),
            220 =>
                array (
                    'id' => 2975,
                    'region_code' => 'region.100138',
                    'region_name' => 'Goldstrand',
                    'country_code' => '',
                    'type' => 1,
                ),
            221 =>
                array (
                    'id' => 2976,
                    'region_code' => 'region.100139',
                    'region_name' => 'Sofia & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            222 =>
                array (
                    'id' => 2977,
                    'region_code' => 'region.100141',
                    'region_name' => 'Tschechische Republik - Prag & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            223 =>
                array (
                    'id' => 2978,
                    'region_code' => 'region.100142',
                    'region_name' => 'Russland St.Petersburg & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            224 =>
                array (
                    'id' => 2979,
                    'region_code' => 'region.100144',
                    'region_name' => 'Ungarn - Balaton (Plattensee)',
                    'country_code' => '',
                    'type' => 1,
                ),
            225 =>
                array (
                    'id' => 2980,
                    'region_code' => 'region.100145',
                    'region_name' => 'Ungarn - Budapest & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            226 =>
                array (
                    'id' => 2981,
                    'region_code' => 'region.100145,region.234',
                    'region_name' => 'Ungarn',
                    'country_code' => '',
                    'type' => 1,
                ),
            227 =>
                array (
                    'id' => 2982,
                    'region_code' => 'region.100151',
                    'region_name' => 'Polen',
                    'country_code' => '',
                    'type' => 1,
                ),
            228 =>
                array (
                    'id' => 2983,
                    'region_code' => 'region.100152',
                    'region_name' => 'Slowenien',
                    'country_code' => '',
                    'type' => 1,
                ),
            229 =>
                array (
                    'id' => 2984,
                    'region_code' => 'region.100153',
                    'region_name' => 'Mexiko Stadt & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            230 =>
                array (
                    'id' => 2985,
                    'region_code' => 'region.100160',
                    'region_name' => 'Bonaire',
                    'country_code' => '',
                    'type' => 1,
                ),
            231 =>
                array (
                    'id' => 2986,
                    'region_code' => 'region.100160',
                    'region_name' => 'Curacao',
                    'country_code' => '',
                    'type' => 1,
                ),
            232 =>
                array (
                    'id' => 2987,
                    'region_code' => 'region.100160',
                    'region_name' => 'Saba',
                    'country_code' => '',
                    'type' => 1,
                ),
            233 =>
                array (
                    'id' => 2988,
                    'region_code' => 'region.100160',
                    'region_name' => 'Sint Eustatius',
                    'country_code' => '',
                    'type' => 1,
                ),
            234 =>
                array (
                    'id' => 2989,
                    'region_code' => 'region.100160',
                    'region_name' => 'Sint Maarten',
                    'country_code' => '',
                    'type' => 1,
                ),
            235 =>
                array (
                    'id' => 2990,
                    'region_code' => 'region.100162',
                    'region_name' => 'Antigua',
                    'country_code' => '',
                    'type' => 1,
                ),
            236 =>
                array (
                    'id' => 2991,
                    'region_code' => 'region.100162',
                    'region_name' => 'Antigua & Barbuda',
                    'country_code' => '',
                    'type' => 1,
                ),
            237 =>
                array (
                    'id' => 2992,
                    'region_code' => 'region.100164',
                    'region_name' => 'Amerikanische Jungferninseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            238 =>
                array (
                    'id' => 2993,
                    'region_code' => 'region.100164',
                    'region_name' => 'Britische Jungferninseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            239 =>
                array (
                    'id' => 2994,
                    'region_code' => 'region.100165',
                    'region_name' => 'Kuba - Havanna & Varadero & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            240 =>
                array (
                    'id' => 2995,
                    'region_code' => 'region.100166',
                    'region_name' => 'Kuba - Holguin & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            241 =>
                array (
                    'id' => 2996,
                    'region_code' => 'region.100170',
                    'region_name' => 'Skandinavien & Island',
                    'country_code' => '',
                    'type' => 1,
                ),
            242 =>
                array (
                    'id' => 2997,
                    'region_code' => 'region.100171',
                    'region_name' => 'Inseln im Golf von Thailand (Koh Chang & weitere)',
                    'country_code' => '',
                    'type' => 1,
                ),
            243 =>
                array (
                    'id' => 2998,
                    'region_code' => 'region.100172',
                    'region_name' => 'Paraguay',
                    'country_code' => '',
                    'type' => 1,
                ),
            244 =>
                array (
                    'id' => 2999,
                    'region_code' => 'region.100172',
                    'region_name' => 'Uruguay',
                    'country_code' => '',
                    'type' => 1,
                ),
            245 =>
                array (
                    'id' => 3000,
                    'region_code' => 'region.100173',
                    'region_name' => 'Französisch Guyana',
                    'country_code' => '',
                    'type' => 1,
                ),
            246 =>
                array (
                    'id' => 3001,
                    'region_code' => 'region.100173',
                    'region_name' => 'Suriname',
                    'country_code' => '',
                    'type' => 1,
                ),
            247 =>
                array (
                    'id' => 3002,
                    'region_code' => 'region.100181',
                    'region_name' => 'Nordinsel',
                    'country_code' => '',
                    'type' => 1,
                ),
            248 =>
                array (
                    'id' => 3003,
                    'region_code' => 'region.100182',
                    'region_name' => 'Südinsel',
                    'country_code' => '',
                    'type' => 1,
                ),
            249 =>
                array (
                    'id' => 3004,
                    'region_code' => 'region.100187',
                    'region_name' => 'Turkmenistan',
                    'country_code' => '',
                    'type' => 1,
                ),
            250 =>
                array (
                    'id' => 3005,
                    'region_code' => 'region.100188',
                    'region_name' => 'Israel - Tel Aviv & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            251 =>
                array (
                    'id' => 3006,
                    'region_code' => 'region.100189',
                    'region_name' => 'Israel - Jerusalem & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            252 =>
                array (
                    'id' => 3007,
                    'region_code' => 'region.100190',
                    'region_name' => 'Israel - Totes Meer & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            253 =>
                array (
                    'id' => 3008,
                    'region_code' => 'region.100191',
                    'region_name' => 'Israel - Eilat',
                    'country_code' => '',
                    'type' => 1,
                ),
            254 =>
                array (
                    'id' => 3009,
                    'region_code' => 'region.100192',
                    'region_name' => 'Jordanien - Amman',
                    'country_code' => '',
                    'type' => 1,
                ),
            255 =>
                array (
                    'id' => 3010,
                    'region_code' => 'region.100194',
                    'region_name' => 'Jordanien - Totes Meer & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            256 =>
                array (
                    'id' => 3011,
                    'region_code' => 'region.100196',
                    'region_name' => 'Südafrika - Kapstadt  & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            257 =>
                array (
                    'id' => 3012,
                    'region_code' => 'region.100197',
                    'region_name' => 'Südafrika - Johannesburg  & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            258 =>
                array (
                    'id' => 3013,
                    'region_code' => 'region.100198',
                    'region_name' => 'China - Shanghai',
                    'country_code' => '',
                    'type' => 1,
                ),
            259 =>
                array (
                    'id' => 3014,
                    'region_code' => 'region.100199',
                    'region_name' => 'China - Peking',
                    'country_code' => '',
                    'type' => 1,
                ),
            260 =>
                array (
                    'id' => 3015,
                    'region_code' => 'region.100201',
                    'region_name' => 'Sao Tome & Principe',
                    'country_code' => '',
                    'type' => 1,
                ),
            261 =>
                array (
                    'id' => 3016,
                    'region_code' => 'region.100205',
                    'region_name' => 'Westsahara',
                    'country_code' => '',
                    'type' => 1,
                ),
            262 =>
                array (
                    'id' => 3017,
                    'region_code' => 'region.100209',
                    'region_name' => 'Salomoninseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            263 =>
                array (
                    'id' => 3018,
                    'region_code' => 'region.100212',
                    'region_name' => 'Haiti',
                    'country_code' => '',
                    'type' => 1,
                ),
            264 =>
                array (
                    'id' => 3019,
                    'region_code' => 'region.100213',
                    'region_name' => 'Saint Barthelemy',
                    'country_code' => '',
                    'type' => 1,
                ),
            265 =>
                array (
                    'id' => 3020,
                    'region_code' => 'region.100215',
                    'region_name' => 'Miami - Fort Lauderdale',
                    'country_code' => '',
                    'type' => 1,
                ),
            266 =>
                array (
                    'id' => 3021,
                    'region_code' => 'region.100216',
                    'region_name' => 'Westküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            267 =>
                array (
                    'id' => 3022,
                    'region_code' => 'region.100218',
                    'region_name' => 'Mexiko',
                    'country_code' => '',
                    'type' => 1,
                ),
            268 =>
                array (
                    'id' => 3023,
                    'region_code' => 'region.100219',
                    'region_name' => 'Chiemsee & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            269 =>
                array (
                    'id' => 3024,
                    'region_code' => 'region.100220',
                    'region_name' => 'Thailand',
                    'country_code' => '',
                    'type' => 1,
                ),
            270 =>
                array (
                    'id' => 3030,
                    'region_code' => 'region.100238',
                    'region_name' => 'weitere Angebote Spanisches Festland',
                    'country_code' => '',
                    'type' => 1,
                ),
            271 =>
                array (
                    'id' => 3031,
                    'region_code' => 'region.100239,region.100251',
                    'region_name' => 'weitere Angebote Mexiko',
                    'country_code' => '',
                    'type' => 1,
                ),
            272 =>
                array (
                    'id' => 3038,
                    'region_code' => 'region.100245,region.1002',
                    'region_name' => 'Orlando & Ostküste',
                    'country_code' => '',
                    'type' => 1,
                ),
            273 =>
                array (
                    'id' => 3039,
                    'region_code' => 'region.100246',
                    'region_name' => 'Kultur Reisen Ägypten',
                    'country_code' => '',
                    'type' => 1,
                ),
            274 =>
                array (
                    'id' => 3040,
                    'region_code' => 'region.100246',
                    'region_name' => 'Rundreise Kairo & Baden',
                    'country_code' => '',
                    'type' => 1,
                ),
            275 =>
                array (
                    'id' => 3046,
                    'region_code' => 'region.100253',
                    'region_name' => 'Disneyland Paris & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            276 =>
                array (
                    'id' => 3048,
                    'region_code' => 'region.100259',
                    'region_name' => 'New Jersey',
                    'country_code' => '',
                    'type' => 1,
                ),
            277 =>
                array (
                    'id' => 3049,
                    'region_code' => 'region.100259',
                    'region_name' => 'New York',
                    'country_code' => '',
                    'type' => 1,
                ),
            278 =>
                array (
                    'id' => 3050,
                    'region_code' => 'region.100260',
                    'region_name' => 'V.A. Emirate - Ajman',
                    'country_code' => '',
                    'type' => 1,
                ),
            279 =>
                array (
                    'id' => 3051,
                    'region_code' => 'region.100260',
                    'region_name' => 'V.A. Emirate - Sharjah',
                    'country_code' => '',
                    'type' => 1,
                ),
            280 =>
                array (
                    'id' => 3059,
                    'region_code' => 'region.100290',
                    'region_name' => 'Tschechische Republik - Böhmen',
                    'country_code' => '',
                    'type' => 1,
                ),
            281 =>
                array (
                    'id' => 3060,
                    'region_code' => 'region.100291',
                    'region_name' => 'Tschechische Republik - Altvatergebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            282 =>
                array (
                    'id' => 3061,
                    'region_code' => 'region.100292',
                    'region_name' => 'Tschechische Republik - Erzgebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            283 =>
                array (
                    'id' => 3062,
                    'region_code' => 'region.100293',
                    'region_name' => 'Tschechische Republik - Isergebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            284 =>
                array (
                    'id' => 3067,
                    'region_code' => 'region.100300',
                    'region_name' => 'weitere Angebote Griechenland Festland',
                    'country_code' => '',
                    'type' => 1,
                ),
            285 =>
                array (
                    'id' => 3075,
                    'region_code' => 'region.100315,region.100224',
                    'region_name' => 'weitere Angebote Tunesien',
                    'country_code' => '',
                    'type' => 1,
                ),
            286 =>
                array (
                    'id' => 3082,
                    'region_code' => 'region.100331',
                    'region_name' => 'weiter Angebote Österreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            287 =>
                array (
                    'id' => 3083,
                    'region_code' => 'region.100340,region.581',
                    'region_name' => 'Libyen',
                    'country_code' => '',
                    'type' => 1,
                ),
            288 =>
                array (
                    'id' => 3084,
                    'region_code' => 'region.100341',
                    'region_name' => 'spezielle Hotelangebote',
                    'country_code' => '',
                    'type' => 1,
                ),
            289 =>
                array (
                    'id' => 3088,
                    'region_code' => 'region.100354,region.746',
                    'region_name' => 'Mauritius',
                    'country_code' => '',
                    'type' => 1,
                ),
            290 =>
                array (
                    'id' => 3090,
                    'region_code' => 'region.100359,region.1004',
                    'region_name' => 'weitere Angebote Bulgarien',
                    'country_code' => '',
                    'type' => 1,
                ),
            291 =>
                array (
                    'id' => 3094,
                    'region_code' => 'region.100388',
                    'region_name' => 'Marokko',
                    'country_code' => '',
                    'type' => 1,
                ),
            292 =>
                array (
                    'id' => 3095,
                    'region_code' => 'region.100390',
                    'region_name' => 'Kiribati',
                    'country_code' => '',
                    'type' => 1,
                ),
            293 =>
                array (
                    'id' => 3096,
                    'region_code' => 'region.100390',
                    'region_name' => 'Nauru',
                    'country_code' => '',
                    'type' => 1,
                ),
            294 =>
                array (
                    'id' => 3097,
                    'region_code' => 'region.100390',
                    'region_name' => 'Niue',
                    'country_code' => '',
                    'type' => 1,
                ),
            295 =>
                array (
                    'id' => 3104,
                    'region_code' => 'region.100406,region.1003',
                    'region_name' => 'weiter Angebote Schweiz',
                    'country_code' => '',
                    'type' => 1,
                ),
            296 =>
                array (
                    'id' => 3106,
                    'region_code' => 'region.100002,region.745,region.56,region.100043',
                    'region_name' => 'Griechenland',
                    'country_code' => '',
                    'type' => 1,
                ),
            297 =>
                array (
                    'id' => 3107,
                    'region_code' => 'region.100006,region.100005,region.100003,region.100004',
                    'region_name' => 'Deutschland',
                    'country_code' => '',
                    'type' => 1,
                ),
            298 =>
                array (
                    'id' => 3108,
                    'region_code' => 'region.100010,region.100114,region.100404,region.100255,region.100111,region.100113,region.100112',
                    'region_name' => 'England',
                    'country_code' => '',
                    'type' => 1,
                ),
            299 =>
                array (
                    'id' => 3109,
                    'region_code' => 'region.100047,region.100048,region.652,region.326',
                    'region_name' => 'Lissabon - Setubal & Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            300 =>
                array (
                    'id' => 3110,
                    'region_code' => 'region.100068,region.615,region.100219',
                    'region_name' => 'Bayern',
                    'country_code' => '',
                    'type' => 1,
                ),
            301 =>
                array (
                    'id' => 3111,
                    'region_code' => 'region.100070,region.615,region.100219',
                    'region_name' => 'Oberbayern',
                    'country_code' => '',
                    'type' => 1,
                ),
            302 =>
                array (
                    'id' => 3112,
                    'region_code' => 'region.100077,region.100066,region.624',
                    'region_name' => 'Niedersachsen',
                    'country_code' => '',
                    'type' => 1,
                ),
            303 =>
                array (
                    'id' => 3113,
                    'region_code' => 'region.100082,region.619,region.100085,region.100084',
                    'region_name' => 'Deutsche Städte',
                    'country_code' => '',
                    'type' => 1,
                ),
            304 =>
                array (
                    'id' => 3115,
                    'region_code' => 'region.100087,region.660,region.846,region.100107,region.100108,region.100169,region.687,region.100338,region.840,region.847,region.100109,region.848,region.695',
                    'region_name' => 'Dänemark',
                    'country_code' => '',
                    'type' => 1,
                ),
            305 =>
                array (
                    'id' => 3116,
                    'region_code' => 'region.100101,region.100102,region.100373,region.100106,region.100288,region.100104,region.100103,region.100105,region.893,region.202',
                    'region_name' => 'Niederlande',
                    'country_code' => '',
                    'type' => 1,
                ),
            306 =>
                array (
                    'id' => 3117,
                    'region_code' => 'region.100115,region.100256,region.204,region.1050',
                    'region_name' => 'Irland',
                    'country_code' => '',
                    'type' => 1,
                ),
            307 =>
                array (
                    'id' => 3118,
                    'region_code' => 'region.100121,region.761,region.100120,region.760,region.100119,region.758,region.100117,region.100118',
                    'region_name' => 'Finnland',
                    'country_code' => '',
                    'type' => 1,
                ),
            308 =>
                array (
                    'id' => 3119,
                    'region_code' => 'region.100129,region.100126,region.100123,region.100372,region.100127,region.774,region.100298,region.100122,region.100125,region.100124,region.100128,region.773',
                    'region_name' => 'Schweden',
                    'country_code' => '',
                    'type' => 1,
                ),
            309 =>
                array (
                    'id' => 3120,
                    'region_code' => 'region.100134,region.100284,region.100132,region.790,region.100130,region.100133,region.100403,region.789,region.100131',
                    'region_name' => 'Norwegen',
                    'country_code' => '',
                    'type' => 1,
                ),
            310 =>
                array (
                    'id' => 3121,
                    'region_code' => 'region.100136,region.100386,region.1113,region.657,region.114',
                    'region_name' => 'Rumänien',
                    'country_code' => '',
                    'type' => 1,
                ),
            311 =>
                array (
                    'id' => 3122,
                    'region_code' => 'region.100150,region.100283,region.100398',
                    'region_name' => 'weitere Angebote Kanada',
                    'country_code' => '',
                    'type' => 1,
                ),
            312 =>
                array (
                    'id' => 3123,
                    'region_code' => 'region.100158,region.100159,region.100396,region.100157,region.16',
                    'region_name' => 'Costa Rica',
                    'country_code' => '',
                    'type' => 1,
                ),
            313 =>
                array (
                    'id' => 3124,
                    'region_code' => 'region.100185,region.100186,region.100330,region.100184,region.100183,region.348',
                    'region_name' => 'Japan',
                    'country_code' => '',
                    'type' => 1,
                ),
            314 =>
                array (
                    'id' => 3125,
                    'region_code' => 'region.100191,region.100189,region.100394,region.100188,region.100190,region.74',
                    'region_name' => 'Israel',
                    'country_code' => '',
                    'type' => 1,
                ),
            315 =>
                array (
                    'id' => 3126,
                    'region_code' => 'region.100192,region.100193,region.100343,region.100194,region.87',
                    'region_name' => 'Jordanien',
                    'country_code' => '',
                    'type' => 1,
                ),
            316 =>
                array (
                    'id' => 3127,
                    'region_code' => 'region.100217,region.1026,region.100167',
                    'region_name' => 'Cancun - Riviera Maya - Yucatan',
                    'country_code' => '',
                    'type' => 1,
                ),
            317 =>
                array (
                    'id' => 3128,
                    'region_code' => 'region.100217,region.1026,region.100167',
                    'region_name' => 'Golf von Mexiko',
                    'country_code' => '',
                    'type' => 1,
                ),
            318 =>
                array (
                    'id' => 3129,
                    'region_code' => 'region.100242,region.1151,region.1152,region.100',
                    'region_name' => 'Malediven',
                    'country_code' => '',
                    'type' => 1,
                ),
            319 =>
                array (
                    'id' => 3130,
                    'region_code' => 'region.100258,region.100304,region.100280,region.100245,region.100215,region.100313,region.340,region.100216',
                    'region_name' => 'USA - Florida',
                    'country_code' => '',
                    'type' => 1,
                ),
            320 =>
                array (
                    'id' => 3131,
                    'region_code' => 'region.100258,region.100304,region.100280,region.100313,region.340',
                    'region_name' => 'Florida',
                    'country_code' => '',
                    'type' => 1,
                ),
            321 =>
                array (
                    'id' => 3133,
                    'region_code' => 'region.100267,region.100272,region.100274,region.100277',
                    'region_name' => 'Roulettes',
                    'country_code' => '',
                    'type' => 1,
                ),
            322 =>
                array (
                    'id' => 3134,
                    'region_code' => 'region.100271,region.913,region.100374,region.585',
                    'region_name' => 'Ukraine',
                    'country_code' => '',
                    'type' => 1,
                ),
            323 =>
                array (
                    'id' => 3135,
                    'region_code' => 'region.100291,region.100290,region.100292,region.100269,region.100293,region.100141,region.100328,region.232',
                    'region_name' => 'Tschechische Republik',
                    'country_code' => '',
                    'type' => 1,
                ),
            324 =>
                array (
                    'id' => 3140,
                    'region_code' => 'region.100328,region.100374,region.100397,region.100386,region.100254,region.100300,region.100348,region.100255,region.100256,region.100323,region.100312,region.100354,region.100405,region.100257,region.100299,region.100306,region.100398,region.100356,reg',
                    'region_name' => 'Rund & Kombireisen',
                    'country_code' => '',
                    'type' => 1,
                ),
            325 =>
                array (
                    'id' => 3144,
                    'region_code' => 'region.100350,region.100334,region.100254',
                    'region_name' => 'weitere Angebote Frankreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            326 =>
                array (
                    'id' => 3145,
                    'region_code' => 'region.100352,region.100181,region.100308,region.100182,region.1130',
                    'region_name' => 'Neuseeland',
                    'country_code' => '',
                    'type' => 1,
                ),
            327 =>
                array (
                    'id' => 3146,
                    'region_code' => 'region.100352,region.100308,region.1130',
                    'region_name' => 'weitere Angebote Neuseeland',
                    'country_code' => '',
                    'type' => 1,
                ),
            328 =>
                array (
                    'id' => 3147,
                    'region_code' => 'region.100357,region.100200,region.100317,region.318,region.100202',
                    'region_name' => 'Namibia',
                    'country_code' => '',
                    'type' => 1,
                ),
            329 =>
                array (
                    'id' => 3148,
                    'region_code' => 'region.100395,region.335,region.806,region.100155,region.100154',
                    'region_name' => 'Panama',
                    'country_code' => '',
                    'type' => 1,
                ),
            330 =>
                array (
                    'id' => 3149,
                    'region_code' => 'region.100408,region.100411,region.100409,region.100410,region.100369,region.100361,region.100365,region.100370,region.100363,region.100367,region.100368,region.100364,region.100362,region.100307,region.100325',
                    'region_name' => 'Deutschland Specials',
                    'country_code' => '',
                    'type' => 1,
                ),
            331 =>
                array (
                    'id' => 3150,
                    'region_code' => 'region.1034,region.1040,region.81',
                    'region_name' => 'Kalabrien',
                    'country_code' => '',
                    'type' => 1,
                ),
            332 =>
                array (
                    'id' => 3151,
                    'region_code' => 'region.1059,region.1062,region.1061',
                    'region_name' => 'St.Helena - Ascension - Tristan da Cunha',
                    'country_code' => '',
                    'type' => 1,
                ),
            333 =>
                array (
                    'id' => 3152,
                    'region_code' => 'region.1065,region.100377,region.1173,region.1102,region.454',
                    'region_name' => 'Argentinien',
                    'country_code' => '',
                    'type' => 1,
                ),
            334 =>
                array (
                    'id' => 3153,
                    'region_code' => 'region.1080,region.1086,region.1079,region.995,region.1081,region.1095,region.1087,region.100344,region.910,region.912,region.1085,region.1078,region.72',
                    'region_name' => 'Indonesien',
                    'country_code' => '',
                    'type' => 1,
                ),
            335 =>
                array (
                    'id' => 3154,
                    'region_code' => 'region.1164,region.100333,region.12',
                    'region_name' => 'Brasilien',
                    'country_code' => '',
                    'type' => 1,
                ),
            336 =>
                array (
                    'id' => 3155,
                    'region_code' => 'region.1180,region.100289,region.1168,region.1169,region.100199,region.100263,region.100198,region.1179,region.1170,region.1171,region.179,region.1172',
                    'region_name' => 'China',
                    'country_code' => '',
                    'type' => 1,
                ),
            337 =>
                array (
                    'id' => 3156,
                    'region_code' => 'region.119,region.100000,region.851',
                    'region_name' => 'Spanien',
                    'country_code' => '',
                    'type' => 1,
                ),
            338 =>
                array (
                    'id' => 3157,
                    'region_code' => 'region.1192,region.100143,region.1188,region.1191,region.1190,region.222,region.1189,region.1187',
                    'region_name' => 'Russische Föderation',
                    'country_code' => '',
                    'type' => 1,
                ),
            339 =>
                array (
                    'id' => 3158,
                    'region_code' => 'region.296,region.100257,region.100392',
                    'region_name' => 'Island',
                    'country_code' => '',
                    'type' => 1,
                ),
            340 =>
                array (
                    'id' => 3159,
                    'region_code' => 'region.314,region.100208,region.100207,region.100206',
                    'region_name' => 'Fidschi',
                    'country_code' => '',
                    'type' => 1,
                ),
            341 =>
                array (
                    'id' => 3160,
                    'region_code' => 'region.315,region.588,region.100210',
                    'region_name' => 'Französisch Polynesien',
                    'country_code' => '',
                    'type' => 1,
                ),
            342 =>
                array (
                    'id' => 3161,
                    'region_code' => 'region.411,region.100301,region.100324',
                    'region_name' => 'Alaska',
                    'country_code' => '',
                    'type' => 1,
                ),
            343 =>
                array (
                    'id' => 3162,
                    'region_code' => 'region.434,region.100366,region.100029',
                    'region_name' => 'Lombardei - Aostatal - Piemont',
                    'country_code' => '',
                    'type' => 1,
                ),
            344 =>
                array (
                    'id' => 3163,
                    'region_code' => 'region.452,region.100378,region.100382',
                    'region_name' => 'Chile',
                    'country_code' => '',
                    'type' => 1,
                ),
            345 =>
                array (
                    'id' => 3164,
                    'region_code' => 'region.604,region.160,region.100235,region.100279',
                    'region_name' => 'Dubai',
                    'country_code' => '',
                    'type' => 1,
                ),
            346 =>
                array (
                    'id' => 3165,
                    'region_code' => 'region.607,region.100260,region.608,region.609,region.160,region.100235,region.100279,region.100260,region.604',
                    'region_name' => 'V.A. Emirate',
                    'country_code' => '',
                    'type' => 1,
                ),
            347 =>
                array (
                    'id' => 3166,
                    'region_code' => 'region.613,region.100376,region.100351',
                    'region_name' => 'weitere Angebote Australien',
                    'country_code' => '',
                    'type' => 1,
                ),
            348 =>
                array (
                    'id' => 3167,
                    'region_code' => 'region.638,region.100305,region.640',
                    'region_name' => 'Kenia - Inland',
                    'country_code' => '',
                    'type' => 1,
                ),
            349 =>
                array (
                    'id' => 3168,
                    'region_code' => 'region.638,region.100305,region.640,region.269',
                    'region_name' => 'Kenia',
                    'country_code' => '',
                    'type' => 1,
                ),
            350 =>
                array (
                    'id' => 3169,
                    'region_code' => 'region.641,region.643,region.100379',
                    'region_name' => 'Tansania',
                    'country_code' => '',
                    'type' => 1,
                ),
            351 =>
                array (
                    'id' => 3170,
                    'region_code' => 'region.647,region.100197,region.100196,region.100311,region.644,region.645,region.100302,region.1100,region.297,region.646',
                    'region_name' => 'Südafrika',
                    'country_code' => '',
                    'type' => 1,
                ),
            352 =>
                array (
                    'id' => 3171,
                    'region_code' => 'region.659,region.100226,region.698,region.821,region.946,region.1108,region.1109,region.100336,region.90',
                    'region_name' => 'Kroatien',
                    'country_code' => '',
                    'type' => 1,
                ),
            353 =>
                array (
                    'id' => 3172,
                    'region_code' => 'region.662,region.675,region.667,region.669,region.668,region.100399,region.671,region.672,region.677',
                    'region_name' => 'Malaysia',
                    'country_code' => '',
                    'type' => 1,
                ),
            354 =>
                array (
                    'id' => 3173,
                    'region_code' => 'region.676,region.18,region.19,region.20',
                    'region_name' => 'Dominikanische Republik',
                    'country_code' => '',
                    'type' => 1,
                ),
            355 =>
                array (
                    'id' => 3174,
                    'region_code' => 'region.698,region.821,region.946',
                    'region_name' => 'Krk & Norddalmatische Inseln',
                    'country_code' => '',
                    'type' => 1,
                ),
            356 =>
                array (
                    'id' => 3175,
                    'region_code' => 'region.722,region.837,region.481',
                    'region_name' => 'Slowakei',
                    'country_code' => '',
                    'type' => 1,
                ),
            357 =>
                array (
                    'id' => 3176,
                    'region_code' => 'region.752,region.940,region.574',
                    'region_name' => 'Südostfrankreich',
                    'country_code' => '',
                    'type' => 1,
                ),
            358 =>
                array (
                    'id' => 3177,
                    'region_code' => 'region.812,region.100332,region.161',
                    'region_name' => 'Venezuela',
                    'country_code' => '',
                    'type' => 1,
                ),
            359 =>
                array (
                    'id' => 3178,
                    'region_code' => 'region.86,region.100241,region.100347',
                    'region_name' => 'Jamaika',
                    'country_code' => '',
                    'type' => 1,
                ),
            360 =>
                array (
                    'id' => 3179,
                    'region_code' => 'region.875,region.100174,region.1077',
                    'region_name' => 'Bangladesh',
                    'country_code' => '',
                    'type' => 1,
                ),
            361 =>
                array (
                    'id' => 3180,
                    'region_code' => 'region.92,region.1126,region.1129,region.1128,region.1127,region.100211',
                    'region_name' => 'Kuba',
                    'country_code' => '',
                    'type' => 1,
                ),
            362 =>
                array (
                    'id' => 3181,
                    'region_code' => 'region.991,region.992,region.882,region.986,region.100323,region.973,region.317',
                    'region_name' => 'Indien',
                    'country_code' => '',
                    'type' => 1,
                ),
            363 =>
                array (
                    'id' => 3182,
                    'region_code' => 'region.100509',
                    'region_name' => 'China - Hong Kong & Macau',
                    'country_code' => '',
                    'type' => 1,
                ),
            364 =>
                array (
                    'id' => 3183,
                    'region_code' => 'region.100014',
                    'region_name' => 'Naher Osten - Vorderer Orient',
                    'country_code' => '',
                    'type' => 1,
                ),
            365 =>
                array (
                    'id' => 3184,
                    'region_code' => 'region.100069',
                    'region_name' => 'Frankenwald & Fichtelgebirge',
                    'country_code' => '',
                    'type' => 1,
                ),
            366 =>
                array (
                    'id' => 3185,
                    'region_code' => 'region.637',
                    'region_name' => 'Zypern Nord',
                    'country_code' => '',
                    'type' => 1,
                ),
            367 =>
                array (
                    'id' => 3186,
                    'region_code' => 'region.149',
                    'region_name' => 'Side & Alanya',
                    'country_code' => '',
                    'type' => 1,
                ),
            368 =>
                array (
                    'id' => 3187,
                    'region_code' => 'region.149',
                    'region_name' => 'Antalya & Belek',
                    'country_code' => '',
                    'type' => 1,
                ),
            369 =>
                array (
                    'id' => 3188,
                    'region_code' => 'region.100051',
                    'region_name' => 'Atlantikküste: Agadir - Safi - Tiznit',
                    'country_code' => '',
                    'type' => 1,
                ),
            370 =>
                array (
                    'id' => 3189,
                    'region_code' => 'region.100085',
                    'region_name' => 'München',
                    'country_code' => '',
                    'type' => 1,
                ),
            371 =>
                array (
                    'id' => 3190,
                    'region_code' => 'region.144',
                    'region_name' => 'Ayvalik & Cesme & Izmir',
                    'country_code' => '',
                    'type' => 1,
                ),
            372 =>
                array (
                    'id' => 3191,
                    'region_code' => 'region.100084',
                    'region_name' => 'Düsseldorf und Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            373 =>
                array (
                    'id' => 3193,
                    'region_code' => 'region.100514',
                    'region_name' => 'St. Martin',
                    'country_code' => '',
                    'type' => 1,
                ),
            374 =>
                array (
                    'id' => 3194,
                    'region_code' => 'region.88',
                    'region_name' => 'Kap Verden weitere Angebote',
                    'country_code' => '',
                    'type' => 1,
                ),
            375 =>
                array (
                    'id' => 3195,
                    'region_code' => 'region.316',
                    'region_name' => 'Philippinen',
                    'country_code' => '',
                    'type' => 1,
                ),
            376 =>
                array (
                    'id' => 3196,
                    'region_code' => 'region.574',
                    'region_name' => 'Franz. Alpen',
                    'country_code' => '',
                    'type' => 1,
                ),
            377 =>
                array (
                    'id' => 3197,
                    'region_code' => 'region.491',
                    'region_name' => 'Vorarlberg',
                    'country_code' => '',
                    'type' => 1,
                ),
            378 =>
                array (
                    'id' => 3198,
                    'region_code' => 'region.100447',
                    'region_name' => 'Sylt',
                    'country_code' => '',
                    'type' => 1,
                ),
            379 =>
                array (
                    'id' => 3199,
                    'region_code' => 'region.494',
                    'region_name' => 'Steiermark',
                    'country_code' => '',
                    'type' => 1,
                ),
            380 =>
                array (
                    'id' => 3200,
                    'region_code' => 'region.250',
                    'region_name' => 'Zentralschweiz',
                    'country_code' => '',
                    'type' => 1,
                ),
            381 =>
                array (
                    'id' => 3201,
                    'region_code' => 'region.100072',
                    'region_name' => 'Bodensee und Umgebung',
                    'country_code' => '',
                    'type' => 1,
                ),
            382 =>
                array (
                    'id' => 3202,
                    'region_code' => 'region.100068',
                    'region_name' => 'Bayerischer Wald und Oberpfälzer Wald',
                    'country_code' => '',
                    'type' => 1,
                ),
        ));
    }
}
