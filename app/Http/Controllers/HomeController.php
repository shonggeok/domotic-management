<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 18:33
 */

namespace App\Http\Controllers;

use App\Gateways\PublicIPGateway;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct(PublicIPGateway $gateway)
    {
        $this->middleware('auth');
        $this->middleware('user-settings');
        $this->setGateway($gateway);
    }


    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        $user_settings = $request->get('user_settings');
        $public_ip = $this->getGateway()->getLastRecord();
        return view('v200.pages.dashboard')->with('public_ip', $public_ip)->with('user_settings', $user_settings);
    }
}
