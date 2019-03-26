<?php
/**
 * Created by PhpStorm.
 * User: sineverba
 * Date: 25/03/2019
 * Time: 18:33
 */

namespace App\Http\Controllers;

class HomeController extends Controller
{


    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function dashboard()
    {
        return view('v200.pages.dashboard');
    }
}
