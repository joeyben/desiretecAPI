<?php

namespace App\Jobs;

use App\Models\Wishes\Wish;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Autooffers\Repositories\AutooffersRepository;
use Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository;

class callTrafficsApi implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $wishId;
    protected $whitelabelId;
    /**
     * Create a new job instance.
     */
    public function __construct($wishId, $whitelabelId)
    {
        $this->wishId = $wishId;
        $this->whitelabelId = $whitelabelId;
    }

    /**
     * Execute the job.
     */
    public function handle(EloquentAutooffersRepository $rules, AutooffersRepository $autooffers)
    {
        $wish = Wish::where('id', $this->wishId)->first();
        $_rules = $rules->getSettingsForWhitelabel($this->whitelabelId);
        //dd(getRegionCode($wish->airport, 0));
        $autooffers->saveWishData($wish);
        $response = $autooffers->getTrafficsData();
        $autooffers->storeMany($response, $wish->id, $_rules);
    }
}
