<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;


class PresensiController extends Controller
{
    public function readPresensi() {
        // Ambil referensi ke koleksi "Employee" pada Firestore
        $employeeRef = app('firebase.firestore')->database()->collection('Employee');

        // Dapatkan semua dokumen ID dari koleksi "Employee"
        $documents = $employeeRef->documents();

        // Inisialisasi array untuk menyimpan data hasil dari subcollection "presensi"
        $presensiData = [];

        // Loop melalui setiap dokumen untuk mengambil data dari subcollection "presensi"
        foreach ($documents as $document) {
            // Ambil ID dari dokumen saat ini
            $docID = $document->id();

            // Ambil referensi ke subcollection "presensi" untuk dokumen saat ini
            $presensiRef = $employeeRef->document($docID)->collection('presensi');

            // Dapatkan data dari subcollection "presensi" untuk dokumen saat ini
            $presensiDocuments = $presensiRef->documents();

            // Loop melalui setiap dokumen dalam subcollection "presensi"
            foreach ($presensiDocuments as $presensiDocument) {
                // Dapatkan data dari dokumen saat ini dan simpan ke dalam array
                $presensiData[] = $presensiDocument->data();
            }
        }

        // Sekarang $presensiData berisi data dari semua dokumen dalam subcollection "presensi" dari koleksi "Employee"
        // Lakukan apa pun yang Anda butuhkan dengan data ini

        // Contoh: Kembalikan data yang diambil
        return view('Dashboard.homeContent',['presensi'=> $presensiDocument]);
    }
}
