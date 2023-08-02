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

        return view('DataGetPass.datagetpass', compact('data'));
    }
}
