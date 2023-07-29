<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\FirebaseException;
use Google\Cloud\Firestore\FieldPath;

use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      // FirebaseAuth.getInstance().getCurrentUser();
      try {
        $uid = Session::get('uid');
        $user = app('firebase.auth')->getUser($uid);
        return view('Dashboard.homeContent');
      } catch (\Exception $e) {
        return $e;
      }

    }

    public function readuser(){
        $data = app('firebase.firestore')->database()->collection('Employee')->documents();
        return view('Dashboard.homeContent', [
            'Users'=>$data
        ]);

    }





    public function customer()
    {
      $userid = Session::get('uid');
      return view('customers',compact('userid'));
    }
}
