<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;
use Carbon\Carbon;


class UserController extends Controller
{
    public function readuser(){
        $data = app('firebase.firestore')->database()->collection('Employee')->documents();
        return view('DataUser.datauser', [
            'Users'=>$data
        ]);

    }
}
