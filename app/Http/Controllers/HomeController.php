<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 18:33
 */

namespace App\Http\Controllers;

use App\Gateways\PublicIPGateway;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct(PublicIPGateway $gateway)
    {
        $this->middleware('auth');
        $this->setGateway($gateway);
    }


    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        $public_ip = $this->getGateway()->getLastRecord();
        return view('v200.pages.dashboard')->with('public_ip', $public_ip);
    }
}
