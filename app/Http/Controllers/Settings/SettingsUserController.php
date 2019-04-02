<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 29/03/2019
 * Time: 10:21
 */

namespace App\Http\Controllers\Settings;

use App\Gateways\Settings\SettingsUserGateway;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsUserController extends Controller
{

    /**
     * SettingsUserController constructor.
     * @param \App\Gateways\Settings\SettingsUserGateway $gateway
     */
    public function __construct(SettingsUserGateway $gateway)
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
        return view('v200.pages.settings-user')->with('settings_user', $settings);
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
            return redirect(Route('settings_user'))
                ->with('success', trans('common.operation_completed_successfully'));
        } else {
            return redirect(Route('settings_user'))
                ->with('error', trans('common.operation_failed'));
        }
    }
}
