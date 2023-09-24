<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;
use Carbon\Carbon;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\EmailExists as EmailExistsException;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Support\Facades\Facade;

class TimeController extends Controller
{

    public function addWaktumasuk(Request $request)
    {
        // Ambil waktu masuk dan waktu pulang dari permintaan
        $masukInput = trim($request->input('in'));
        $pulangInput = trim($request->input('out'));



        // Simpan dalam format waktu yang sesuai ke Firebase Firestore
        $timeCollection = app('firebase.firestore')->database()->collection('TimePic');
        $timeCollection->document('waktu_masuk')->set([
            "masuk" => $masukInput,
            "pulang"=> $pulangInput

        ]);

        return redirect('/TimeDate');
    }
    public function addWaktupulang(Request $request)
    {

        $pulangInput = trim($request->input('out'));





        $timeCollection = app('firebase.firestore')->database()->collection('TimePic');
        $timeCollection->document('waktu_pulang')->set([

            "pulang" => $pulangInput
        ]);

        return redirect('/TimeDate');
    }


    public function readTime(){
        $data = app('firebase.firestore')->database()->collection('TimePic')->documents();
        return view('timesettings.timeSet', compact('data'));

    }

}
