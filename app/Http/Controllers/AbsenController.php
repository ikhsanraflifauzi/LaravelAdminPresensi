<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;
use Carbon\Carbon;

class AbsenController extends Controller
{
    public function readAbsen() {

        $employeeRef = app('firebase.firestore')->database()->collection('Employee');

        $documents = $employeeRef->documents();


        $absenData = [];


        foreach ($documents as $document) {

            $docID = $document->id();


            $absenRef = $employeeRef->document($docID)->collection('Absen');


            $absenDocuments = $absenRef->documents();


            foreach ($absenDocuments as $absenDocument) {

                $absenData[] = $absenDocument->data();
            }
        }



        return $absenData;
    }
    public function showAbsen()
    {
        // Panggil fungsi readPresensi() untuk mendapatkan data presensi
        $absenData = $this->readAbsen();

        // Tampilkan view presensi.blade.php dan kirimkan data presensi ke dalam view
        return view('DataAbsen.dataabsen', compact('absenData'));
    }
}
