<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 27/03/2019
 * Time: 09:10
 */

namespace App\Http\Controllers\Settings;

use App\Gateways\PasswordGateway;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * PasswordController constructor.
     * @param \App\Gateways\PasswordGateway $gateway
     */
    public function __construct(PasswordGateway $gateway)
    {
        $this->middleware('auth');
        $this->setGateway($gateway);
    }

    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('v200.pages.change-password');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function update(Request $request)
    {
        $user_id = Auth::id();

        $status = $this->getGateway()->updatePassword($request->all(), $user_id);
        if ($status === true) {
            return redirect(Route('password_show'))
                ->with('success', trans('common.operation_completed_successfully'));
        } else {
            if (is_array($status)) {
                return redirect(Route('password_show'))
                    ->withErrors($status);
            } else {
                return redirect(Route('password_show'))
                    ->with('error', trans('common.old_password_doesnt_match'));
            }
        }
    }
}
