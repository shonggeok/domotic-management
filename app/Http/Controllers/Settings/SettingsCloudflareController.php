<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 10:21
 */

namespace App\Http\Controllers\Settings;

use App\Gateways\Settings\SettingsCloudflareGateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsCloudflareController extends Controller
{
    /**
     * SettingsCloudflareController constructor.
     * @param \App\Gateways\Settings\SettingsCloudflareGateway $gateway
     */
    public function __construct(SettingsCloudflareGateway $gateway)
    {
        $this->middleware('auth');
        $this->setGateway($gateway);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        $user_id = Auth::id();
        $settings = $this->getGateway()->getAllRecordsForAuthenticatedUser($user_id);
        return view('v200.pages.settings-cloudflare')->with('settings_cloudflare', $settings);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $user_id = Auth::id();
        $update = $this->getGateway()->createOrUpdate($request->all(), $user_id);
        if ($update === true) {
            return redirect(Route('settings_cloudflare'))
                ->with('success', trans('common.operation_completed_successfully'));
        } else {
            return redirect(Route('settings_cloudflare'))
                ->with('errors', $update);
        }
    }
}
