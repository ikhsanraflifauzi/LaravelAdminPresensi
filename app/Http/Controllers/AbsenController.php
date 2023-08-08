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
        $mainCollectionName = 'Employee';
        $subCollectionName = 'Absen';

        $mainCollection = app('firebase.firestore')->database()->collection($mainCollectionName);
        $documents = $mainCollection->documents();

        $data = [];

        foreach ($documents as $document) {
            $documentData = $document->data();
            $documentId = $document->id();

            $subCollection = app('firebase.firestore')->database()->collection($mainCollectionName)->document($documentId)->collection($subCollectionName);
            $subDocuments = $subCollection->documents();

            $documentData['Absen'] = [];

            foreach ($subDocuments as $subDocument) {
                $documentData['Absen'][] = $subDocument->data();
            }

            $data[] = $documentData;
        }

        return view('DataAbsen.dataabsen', compact('data'));

    }
    public function filterAbsen(Request $request) {
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
            $query = $subCollection->where('Tanggal', '>=', $startDate)->where('Tanggal', '<=', $endDate)->orderBy('Tanggal');
            $subDocuments = $query->documents();

            $documentData['Absen'] = [];

            foreach ($subDocuments as $subDocument) {
                $documentData['Absen'][] = $subDocument->data();
            }

            $data[] = $documentData;
        }

        return view('DataAbsen.dataabsen', compact('data'));
    }
}
