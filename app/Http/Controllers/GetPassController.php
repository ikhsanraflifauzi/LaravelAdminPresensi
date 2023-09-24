<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class GetPassController extends Controller
{
    public function readGetPass() {

        $mainCollectionName = 'Employee';
        $subCollectionName = 'GetPass';
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

            $documentData['GetPass'] = [];

            foreach ($subDocuments as $subDocument) {
                $documentData['GetPass'][] = $subDocument->data();
            }

            $data[] = $documentData;
        }

        return view('DataGetPass.datagetpass', compact('data', 'prodi'));
    }
    public function filterGetPass(Request $request) {
        $mainCollectionName = 'Employee';
        $subCollectionName = 'presensi';
        $prodi = [
            '-',
            'Manufaktur',
            'Mekatronika',
            'Teknik Elektro',
            'Teknologi Rekayasa Perangkat Lunak',
        ];

        $startDate = $request->input('sdate');
        $endDate = $request->input('edate');

        $mainCollection = app('firebase.firestore')->database()->collection($mainCollectionName);
        $documents = $mainCollection->documents();

        $data = [];

        foreach ($documents as $document) {
            $documentData = $document->data();
            $documentId = $document->id();

            $subCollection = $mainCollection->document($documentId)->collection($subCollectionName);
            $query = $subCollection->where('Tanggal', '>=', $startDate)->where('Tanggal', '<=', $endDate)->orderBy('Tanggal');
            $subDocuments = $query->documents();

            $documentData['GetPass'] = [];

            foreach ($subDocuments as $subDocument) {
                $documentData['GetPass'][] = $subDocument->data();
            }

            $data[] = $documentData;
        }

        return view('DataGetPass.datagetpass', compact('data', 'prodi'));
    }

    public function prodiFilterGetPass(Request $request) {
        $mainCollectionName = 'Employee';
        $subCollectionName = 'GetPass';
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

            $subCollection = app('firebase.firestore')->database()->collection($mainCollectionName)->document($documentId)->collection($subCollectionName);
            $subDocuments = $subCollection->documents();

            $documentData['GetPass'] = [];

            foreach ($subDocuments as $subDocument) {
                $documentData['GetPass'][] = $subDocument->data();
            }

            $data[] = $documentData;
        }



        return view('DataGetPass.datagetpass', compact('data', 'prodi', 'selectedProdi'));
    }

    public function exportGetPass()
{
    $mainCollectionName = 'Employee';
    $subCollectionName = 'GetPass';

    $firestore = app('firebase.firestore');
    $mainCollection = $firestore->database()->collection($mainCollectionName);
    $documents = $mainCollection->documents();

    $data = [];

    foreach ($documents as $document) {
        $documentData = $document->data();
        $documentId = $document->id();

        $subCollection = $mainCollection->document($documentId)->collection($subCollectionName);
        $subDocuments = $subCollection->documents();

        $documentData['GetPass'] = [];

        foreach ($subDocuments as $subDocument) {
            $documentData['GetPass'][] = $subDocument->data();
        }

        $data[] = $documentData;
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header kolom
    $header = [
        'NIP', 'Nama', 'Jabatan', 'Prodi', 'Tanggal', 'Perihal', 'Jam Keluar', 'Jam Kembali'
    ];
    $column = 1;
    foreach ($header as $item) {
        $sheet->setCellValueByColumnAndRow($column++, 1, $item);
    }

    $row = 2;

    foreach ($data as $documentData) {
        foreach ($documentData['GetPass'] as $getpass) {

            $sheet->setCellValueByColumnAndRow(1, $row, $documentData['NIP']);
            $sheet->setCellValueByColumnAndRow(2, $row, $documentData['Name']);
            $sheet->setCellValueByColumnAndRow(3, $row, $documentData['jabatan']);
            $sheet->setCellValueByColumnAndRow(4, $row, $documentData['prodi']);
            $sheet->setCellValueByColumnAndRow(5, $row, \Carbon\Carbon::parse($getpass['Tanggal'])->format('Y m d'));
            $sheet->setCellValueByColumnAndRow(6, $row,  $getpass['GetPass']['Alasan']);
            $sheet->setCellValueByColumnAndRow(7, $row, isset($getpass['GetPass']['Tanggal']) ? \Carbon\Carbon::parse($getpass['GetPass']['Tanggal'])->format('H:i:s') : '');
            $sheet->setCellValueByColumnAndRow(8, $row, isset($getpass['GetBack']['Tanggal']) ? \Carbon\Carbon::parse($getpass['GetBack']['Tanggal'])->format('H:i:s') : '');

            $row++;
        }
    }

    // Simpan file Excel
    $filename = 'data_getPass.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);


    return response()->download($filename)->deleteFileAfterSend(true);
}
}
