<?php

namespace App\Jobs;

use App\Models\Wishes\Wish;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Autooffers\Repositories\AutooffersTTRepository;
use Modules\Autooffers\Repositories\Eloquent\EloquentAutooffersRepository;

class callTTApi implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $wishId;

    public function __construct($wishId)
    {
        $this->wishId = $wishId;
    }

    /**
     * Execute the job.
     */
    public function handle(EloquentAutooffersRepository $rules, AutooffersTTRepository $TTautooffers)
    {
        $wish = Wish::where('id', $this->wishId)->first();
        $_rules = $rules->getSettingsForWhitelabel((int) (getCurrentWhiteLabelId()));
        $TTautooffers->saveWishData($wish);
        $TTautooffers->getToken();
        $response = $TTautooffers->getTTData();
        $TTautooffers->storeMany($wish->id, $_rules);
    }
}
