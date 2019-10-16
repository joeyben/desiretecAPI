<?php

namespace App\Jobs;

use App\Models\Wishes\Wish;
use App\Repositories\Frontend\Wishes\WishesRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository;
use Modules\Autooffers\Repositories\AutooffersTTRepository;

class callTTApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $wishId;

    public function __construct($wishId)
    {
        $this->wishId = $wishId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(EloquentAutooffersRepository $rules, AutooffersTTRepository $TTautooffers)
    {
        $wish = Wish::where('id',$this->wishId)->first();
        $_rules = $rules->getSettingsForWhitelabel(intval(getCurrentWhiteLabelId()));
        $TTautooffers->saveWishData($wish);
        $TTautooffers->getToken();
        $response = $TTautooffers->getTTData();
        $TTautooffers->storeMany($wish->id, $_rules);
    }
}
