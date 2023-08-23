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
    $prodi = [
        '-',
         'Manufaktur',
         'Mekatronika',
         'Teknik Elektro',
         'Teknologi Rekayasa Perangkat Lunak',


     ];

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

    return view('DataPresensi.datapresensi', compact('data', 'prodi'));
}

public function filterPresensi(Request $request) {
    $mainCollectionName = 'Employee';
    $subCollectionName = 'presensi';

    $startDate = $request->input('sdate');
    $endDate = $request->input('edate');
    $selectedProdi = $request->input('prodi');

    $prodi = [
        '-',
        'Manufaktur',
        'Mekatronika',
        'Teknik Elektro',
        'Teknologi Rekayasa Perangkat Lunak',
    ];
    $mainCollection = app('firebase.firestore')->database()->collection($mainCollectionName);
    $query1 = $mainCollection->where('prodi', "=", $selectedProdi)->orderBy('prodi');
    $docs = $query1->documents();
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



    return view('DataPresensi.datapresensi', compact('data', 'prodi', 'selectedProdi'));
}

public function prodiFilter(Request $request) {
    $mainCollectionName = 'Employee';
    $subCollectionName = 'presensi';
    $prodi = [
        '-',
        'Manufaktur',
        'Mekatronika',
        'Teknik Elektro',
        'Teknologi Rekayasa Perangkat Lunak',
    ];

    $selectedProdi = $request->input('prodi');

    $mainCollection = app('firebase.firestore')->database()->collection($mainCollectionName);
    $query = $mainCollection->where('prodi', "=", $selectedProdi)->orderBy('prodi');
    $documents = $query->documents();

    $data = [];

    foreach ($documents as $document) {
        $documentData = $document->data();
        $documentId = $document->id();

        $subCollection = $mainCollection->document($documentId)->collection($subCollectionName);
        $subDocuments = $subCollection->documents();

        $presensiData = [];

        foreach ($subDocuments as $subDocument) {
            $presensiData[] = $subDocument->data();
        }

        $documentData['presensi'] = $presensiData;
        $data[] = $documentData;
    }

    return view('DataPresensi.datapresensi', compact('data', 'prodi', 'selectedProdi'));
}

public function roleFilter(Request $request) {
    $mainCollectionName = 'Employee';
    $subCollectionName = 'presensi';
    $prodi = [
        '-',
        'Manufaktur',
        'Mekatronika',
        'Teknik Elektro',
        'Teknologi Rekayasa Perangkat Lunak',
    ];

    $selectedProdi = $request->input('prodi');

    $mainCollection = app('firebase.firestore')->database()->collection($mainCollectionName);
    $query = $mainCollection->where('prodi', "=", $selectedProdi)->orderBy('prodi');
    $documents = $query->documents();

    $data = [];

    foreach ($documents as $document) {
        $documentData = $document->data();
        $documentId = $document->id();

        $subCollection = $mainCollection->document($documentId)->collection($subCollectionName);
        $subDocuments = $subCollection->documents();

        $presensiData = [];

        foreach ($subDocuments as $subDocument) {
            $presensiData[] = $subDocument->data();
        }

        $documentData['presensi'] = $presensiData;
        $data[] = $documentData;
    }

    return view('DataPresensi.datapresensi', compact('data', 'prodi', 'selectedProdi'));
}









public function exportPresensi()
{
    $mainCollectionName = 'Employee';
    $subCollectionName = 'presensi';

    $firestore = app('firebase.firestore');
    $mainCollection = $firestore->database()->collection($mainCollectionName);
    $documents = $mainCollection->documents();

    $data = [];

    foreach ($documents as $document) {
        $documentData = $document->data();
        $documentId = $document->id();

        $subCollection = $mainCollection->document($documentId)->collection($subCollectionName);
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
        'NIP', 'Nama', 'Jabatan', 'Prodi', 'Tanggal', 'Check in', 'Status', 'Check out'
    ];
    $column = 1;
    foreach ($header as $item) {
        $sheet->setCellValueByColumnAndRow($column++, 1, $item);
    }

    $row = 2;

    foreach ($data as $documentData) {
        foreach ($documentData['presensi'] as $presensi) {

            $sheet->setCellValueByColumnAndRow(1, $row, $documentData['NIP']);
            $sheet->setCellValueByColumnAndRow(2, $row, $documentData['Name']);
            $sheet->setCellValueByColumnAndRow(3, $row, $documentData['jabatan']);
            $sheet->setCellValueByColumnAndRow(4, $row, $documentData['prodi']);
            $sheet->setCellValueByColumnAndRow(5, $row, \Carbon\Carbon::parse($presensi['tanggal'])->format('Y m d'));
            $sheet->setCellValueByColumnAndRow(6, $row, \Carbon\Carbon::parse($presensi['check in']['tanggal'])->format('H:i:s'));
            $sheet->setCellValueByColumnAndRow(7, $row, $presensi['check in']['status']);
            $sheet->setCellValueByColumnAndRow(8, $row, isset($presensi['check out']['tanggal']) ? \Carbon\Carbon::parse($presensi['check out']['tanggal'])->format('H:i:s') : '');

            $row++;
        }
    }

    // Simpan file Excel
    $filename = 'data_presensi.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);

    // Anda mungkin ingin mengembalikan berkas Excel untuk diunduh
    return response()->download($filename)->deleteFileAfterSend(true);
}




}
