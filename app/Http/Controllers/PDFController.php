<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class PDFController extends Controller
{


public function presensiPDF()
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
    view()->share('data', $data);

        $pdf = FacadePdf::loadview('DataPresensi.presensipdfview');
        return $pdf->download('data-presensi.pdf');

}
public function getPassPDF()
{
    $mainCollectionName = 'Employee';
    $subCollectionName = 'GetPass';

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
    view()->share('data', $data);

        $pdf = FacadePdf::loadview('DataGetPass.GetPasspdfview');
        return $pdf->download('data-getPass.pdf');

}


}
