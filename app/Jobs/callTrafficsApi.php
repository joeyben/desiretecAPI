<?php

namespace App\Jobs;

use App\Models\Wishes\Wish;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Autooffers\Repositories\AutooffersRepository;
use Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository;

class callTrafficsApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $wishId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($wishId)
    {
        $this->wishId = $wishId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EloquentAutooffersRepository $rules, AutooffersRepository $autooffers)
    {
        $wish = Wish::where('id',$this->wishId)->first();
        $_rules = $rules->getSettingsForWhitelabel(intval(getCurrentWhiteLabelId()));
        //dd(getRegionCode($wish->airport, 0));
        $autooffers->saveWishData($wish);
        $response = $autooffers->getTrafficsData();
        $autooffers->storeMany($response, $wish->id, $_rules);
    }
}
