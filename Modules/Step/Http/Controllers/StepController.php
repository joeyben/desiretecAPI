<?php

namespace Modules\Step\Http\Controllers;

use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;
use Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository;

class StepController extends Controller
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;
    /**
     * @var \Modules\Whitelabels\Repositories\Contracts\WhitelabelsRepository
     */
    private $whitelabels;

    public function __construct(AuthManager $auth, WhitelabelsRepository $whitelabels)
    {
        $this->auth = $auth;
        $this->whitelabels = $whitelabels;
    }

    public function step(int $step)
    {
        $whitelabel = $this->auth->user()->whitelabels()->first();
        $result = ($whitelabel->state * 100) / (Flag::MAX_STEP - 1);
        $quote = number_format($result, 2, '.', '');

        if ($this->auth->guard('web')->user()->hasRole(Flag::EXECUTIVE_ROLE) && !$this->auth->guard('web')->user()->hasRole(Flag::ADMINISTRATOR_ROLE)) {
            $whitelabel = $this->auth->guard('web')->user()->whitelabels()->first();

            if ((int) $whitelabel->state === 11) {
                $this->whitelabels->update(
                    $this->auth->guard('web')->user()->whitelabels()->first()->id,
                    ['state' => 12]
                );
            }
        }

        return view('step::index', compact(['quote']));
    }
}
