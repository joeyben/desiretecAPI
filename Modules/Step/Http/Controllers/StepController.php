<?php

namespace Modules\Step\Http\Controllers;

use App\Services\Flag\Src\Flag;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\Controller;

class StepController extends Controller
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function step(int $step)
    {
        $whitelabel = $this->auth->user()->whitelabels()->first();
        $quote = ($whitelabel->state * 100) / Flag::MAX_STEP;
        $quote = number_format($quote, 2, '.', '');

        return view('step::index', compact(['quote']));
    }
}
