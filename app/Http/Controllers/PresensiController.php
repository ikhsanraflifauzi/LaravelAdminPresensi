<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;
use Carbon\Carbon;



class PresensiController extends Controller
{
    public function dataPresensiEmp()
{
    $mainCollectionName = 'Employee';
    $subCollectionName = 'presensi';

    $mainCollection = app('firebase.firestore')->database()->collection($mainCollectionName);
    $documents = $mainCollection->documents();

    $data = [];

    foreach ($documents as $document) {
        $documentData = $document->data();
        $documentId = $document->id();

        $subCollection = app('firebase.firestore')->database()->collection($mainCollectionName)->document($documentId)->collection($subCollectionName);
        $subDocuments = $subCollection->documents();

        $documentData['presensi'] = [];

        foreach ($subDocuments as $subDocument) {
            $documentData['presensi'][] = $subDocument->data();
        }

        $data[] = $documentData;
    }

    return view('DataPresensi.datapresensi', compact('data'));
}
public function filterPresensi($startDate, $endDate) {
    $mainCollectionName = 'Employee';
    $subCollectionName = 'presensi';

    $mainCollection = app('firebase.firestore')->database()->collection($mainCollectionName);
    $documents = $mainCollection->documents();

    $data = [];

    foreach ($documents as $document) {
        $documentData = $document->data();
        $documentId = $document->id();

        $subCollection = app('firebase.firestore')->database()->collection($mainCollectionName)->document($documentId)->collection($subCollectionName);
        $query = $subCollection->where('tanggal', '>=', $startDate)->where('tanggal', '<=', $endDate);
        $subDocuments = $query->documents();

        $documentData['presensi'] = [];

        foreach ($subDocuments as $subDocument) {
            $documentData['presensi'][] = $subDocument->data();
        }

        $data[] = $documentData;
    }

    return view('DataPresensi.datapresensi', compact('data'));
}

    /* public function view_pegawai(Request $request)
    {
        $keyword = $request->keyword;

        // Filtering data based on 'nama_jabatan' and 'nama_departemen'
        $datass = DB::table('pegawais')
            ->join('departemens', 'pegawais.id_departemen', '=', 'departemens.id')
            ->join('jabatans', 'pegawais.id_jabatan', '=', 'jabatans.id')
            ->when($request->nama_departemen, function ($query, $nama_departemen) {
                return $query->where('departemens.nama_departemen', $nama_departemen);
            })
            ->when($request->nama_jabatan, function ($query, $nama_jabatan) {
                return $query->where('jabatans.nama_jabatan', $nama_jabatan);
            })
            ->where('pegawais.nama_pegawai', 'LIKE', '%' . $keyword . '%')
            ->get();

        $jabatan = Jabatan::all();
        $departemen = Departemen::all();

        return view('data-master.view-pegawai', [
            'keyword' => $keyword,
            'datass' => $datass,
            'jabatan' => $jabatan,
            'departemen' => $departemen
        ]);
    } */
}
