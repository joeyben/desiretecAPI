<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateBestFewo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bestfewo:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job for pulling Bestfewo objects';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $xml = simplexml_load_file("geotree.xml") or die("Error: Cannot create object");
        $objJsonDocument = json_encode($xml);
        $arrOutput = json_decode($objJsonDocument, TRUE);


        $items = $arrOutput["root"]["node"]["node"];
        echo count($items);
    }
}
