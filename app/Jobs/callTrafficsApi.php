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
    protected $userId;
    /**
     * Create a new job instance.
     */
    public function __construct($wishId, $whitelabelId, $userId)
    {
        $this->wishId = $wishId;
        $this->whitelabelId = $whitelabelId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(EloquentAutooffersRepository $rules, AutooffersRepository $autooffers)
    {
        $autooffers->setAuth($this->whitelabelId);
        $wish = Wish::where('id', $this->wishId)->first();
        $_rules = $rules->getSettingsForWhitelabel($this->whitelabelId);
        $autooffers->saveWishData($wish);
        $response = $autooffers->getTrafficsData();
        $autooffers->storeMany($response, $wish->id, $_rules, $this->userId);
    }
}
