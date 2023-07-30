<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;
use Carbon\Carbon;

class GetPassController extends Controller
{
    public function readGetPass() {

        $employeeRef = app('firebase.firestore')->database()->collection('Employee');

        $documents = $employeeRef->documents();


        $getpassData = [];


        foreach ($documents as $document) {

            $docID = $document->id();


            $getpassRef = $employeeRef->document($docID)->collection('GetPass');


            $getpassDocuments = $getpassRef->documents();


            foreach ($getpassDocuments as $getpassDocument) {

                $getpassData[] = $getpassDocument->data();
            }
        }



        return $getpassData;
    }
    public function showGetPass()
    {
        // Panggil fungsi readPresensi() untuk mendapatkan data presensi
        $getpassData = $this->readGetPass();

        // Tampilkan view presensi.blade.php dan kirimkan data presensi ke dalam view
        return view('Dashboard.homeContent', compact('getpassData'));
    }
}
