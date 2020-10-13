<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        //$xml = simplexml_load_file("https://desiretec:uub8hai2HeeW6eel@export.bestfewo.com/desiretec/objects.xml") or die("Error: Cannot create object");

        $file = "https://desiretec:uub8hai2HeeW6eel@export.bestfewo.com/desiretec/objects.xml";
        $reader = new \XMLReader();
        $reader->open($file);
        DB::table('Bestfewo')->truncate();
        while( $reader->read() ) {
            if ($reader->nodeType == \XMLReader::ELEMENT) {
                switch ($reader->name) {
                    case "object" :
                        $node = new \SimpleXMLElement($reader->readOuterXML());
                        $attributes = $node->attributes();
                        $location = $node->location;
                        //$this->addObject($attributes, $location, $node);
                        $this->addRegion($location);
                        break;
                }
            }

        }
        $reader->close();

        /**/
    }
    
    public function addObject($attributes, $location, $node){
        //Log::info('Initializing Insert' );
        DB::table('Bestfewo')
            ->insert([
                'obj_id'            => $attributes->id,
                'link'              => $attributes->link,
                'max_guests'        => intval($attributes->max_guests),
                'max_adults'        => intval($attributes->max_adults),
                'max_children'      => intval($attributes->max_children),
                'max_children_age'  => intval($attributes->max_children_age),
                'size'              => intval($attributes->size),
                'bedrooms'          => intval($attributes->bedrooms),
                'type'              => $attributes->type,
                'city'              => $location->city,
                'zipcode'           => intval($location->zipcode),
                'region'            => $location->region,
                'country'           => $location->country,
                'latitude'          => $location->geo->latitude,
                'longitude'         => $location->geo->longitude,
                'data'              => addslashes(json_encode($node))
            ]);
    }

    public function addRegion($location){
        //Log::info('Initializing Insert' );
        if($this->checkRegion($location) === 0){
            DB::table('bf_regions')
                ->insert([
                    'city'              => $location->city,
                    'region'            => $location->region,
                    'country'           => $location->country,
                ]);
        }
    }

    public function checkRegion($location){
        return DB::table('bf_regions')
            ->where('city', $location->city)
            ->where('region', $location->region)
            ->where('country', $location->country)
            ->count();
    }
}
