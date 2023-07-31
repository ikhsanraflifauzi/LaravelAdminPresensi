<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;
use Carbon\Carbon;



class PresensiController extends Controller
{
    public function readPresensi() {

        $employeeRef = app('firebase.firestore')->database()->collection('Employee');

        $documents = $employeeRef->documents();


        $presensiData = [];


        foreach ($documents as $document) {

            $docID = $document->id();


            $presensiRef = $employeeRef->document($docID)->collection('presensi');


            $presensiDocuments = $presensiRef->documents();


            foreach ($presensiDocuments as $presensiDocument) {

                $presensiData[] = $presensiDocument->data();
            }
        }



        return $presensiData;
    }
    public function showPresensi()
    {
        // Panggil fungsi readPresensi() untuk mendapatkan data presensi
        $presensiData = $this->readPresensi();

        // Tampilkan view presensi.blade.php dan kirimkan data presensi ke dalam view
        return view('DataPresensi.datapresensi',compact('presensiData'));
    }
}
