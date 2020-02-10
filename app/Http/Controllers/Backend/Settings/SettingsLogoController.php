<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings\Setting;
use App\Repositories\Backend\Settings\SettingsRepository;
use Illuminate\Http\Request;

/**
 * Class SettingsLogoController.
 */
class SettingsLogoController extends Controller
{
    protected $settings;

    public function __construct(SettingsRepository $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Remove logo or favicon icon.
     *
     * @return mixed
     */
    public function destroy(Setting $setting, Request $request)
    {
        $this->settings->removeLogo($setting, $request->data);

        return json_encode([
            'status' => true,
        ]);
    }
}
