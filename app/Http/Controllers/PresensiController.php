<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



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
public function filterPresensi(Request $request) {
    $mainCollectionName = 'Employee';
    $subCollectionName = 'presensi';

    $startDate = $request->input('sdate');
    $endDate = $request->input('edate');

    $mainCollection = app('firebase.firestore')->database()->collection($mainCollectionName);
    $documents = $mainCollection->documents();

    $data = [];

    foreach ($documents as $document) {
        $documentData = $document->data();
        $documentId = $document->id();

        $subCollection = $mainCollection->document($documentId)->collection($subCollectionName);
        $query = $subCollection->where('tanggal', '>=', $startDate)->where('tanggal', '<=', $endDate)->orderBy('tanggal');
        $subDocuments = $query->documents();

        $documentData['presensi'] = [];

        foreach ($subDocuments as $subDocument) {
            $documentData['presensi'][] = $subDocument->data();
        }

        $data[] = $documentData;
    }

    return view('DataPresensi.datapresensi', compact('data'));
}
public function exportPresensi()
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
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $header = [
        'Nama', 'Usia', 'Jabatan', 'Presensi 1', 'Presensi 2',
    ];
    $column = 1;
    foreach ($header as $item) {
        $sheet->setCellValueByColumnAndRow($column++, 1, $item);
    }

    $row = 2;

    foreach ($data as $documentData) {
        $sheet->setCellValueByColumnAndRow(1, $row, $documentData['nama']); // Ganti dengan nama kolom yang sesuai
        $sheet->setCellValueByColumnAndRow(2, $row, $documentData['usia']); // Ganti dengan nama kolom yang sesuai
        $sheet->setCellValueByColumnAndRow(3, $row, $documentData['jabatan']); // Ganti dengan nama kolom yang sesuai


        $presensiColumn = 4;
        foreach ($documentData['presensi'] as $presensi) {
            $sheet->setCellValueByColumnAndRow($presensiColumn++, $row, $presensi['data_presensi']); // Ganti dengan nama kolom yang sesuai
        }

        $row++;
    }

    // Simpan file Excel
    $filename = 'data_presensi.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);

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
