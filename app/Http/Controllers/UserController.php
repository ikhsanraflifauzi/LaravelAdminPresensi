<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Firestore\FieldPath;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Google\Cloud\Firestore\FirestoreClient;
use Carbon\Carbon;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Kreait\Firebase\Exception\Auth\EmailExists as EmailExistsException;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Support\Facades\Facade;


class UserController extends Controller
{
    public function readuser(){
        $data = app('firebase.firestore')->database()->collection('Employee')->documents();
        return view('DataUser.datauser', [
            'Users'=>$data
        ]);

    }

    protected $auth;
    public function __construct(FirebaseAuth $auth) {
        $this->auth = $auth;
     }
     public function processAddEmployee(Request $request)
     {
         $roles = [
             'Admin',
             'Dosen',
             'Employee',

         ];

         $prodi = [
            '-',
             'Manufaktur',
             'Mekatronika',
             'Teknik Elektro',
             'Teknologi Rekayasa Perangkat Lunak',


         ];

         try {

             $userCredential = $this->auth->createUserWithEmailAndPassword($request->input('email'), '12345678');
             $user = $userCredential;

             if ($user) {
                 $uid = $user->uid;


                 $employeeCollection = app('firebase.firestore')->database()->collection('Employee');
                 $employeeCollection->document($uid)->set([
                     "NIP" => $request->input('nip'),
                     "Name" => $request->input('name'),
                     "email" => $request->input('email'),
                     "role" => $request->input('role'),
                     "jabatan" => $request->input('jabatan'),
                     "prodi" => $request->input('prodi'),
                     "createdAt" => now()->toIso8601String(),
                     "Uid" => $uid,
                 ]);


                 return redirect('/datauser');
             }
         } catch (AuthException $e) {
             return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 400);
         }
     }

        public function deleteEmployee(Request $request)
        {
            $employeeRef = app('firebase.firestore')->database()->collection('Employee')->document()->delete();



             return redirect('/datauser');
        }
        public function addUserView(){
            $roles = [
                'Admin',
                'Dosen',
                'Employee',

            ];

            $prodi = [
                '-',
                'Manufaktur',
                'Mekatronika',
                'Teknik Elektro',
                'Teknologi Rekayasa Perangkat Lunak',


            ];
            return view('DataUser.tambahuser', compact('roles'), compact('prodi'));
        }

        public function editUser($e) {

            $roles = [
                'Admin',
                'Dosen',
                'Employee',

            ];

            $prodi = [
                '-',
                'Manufaktur',
                'Mekatronika',
                'Teknik Elektro',
                'Teknologi Rekayasa Perangkat Lunak',


            ];
            $data = app('firebase.firestore')
                ->database()
                ->collection('Employee')
                ->where('Uid', '=', $e)
                ->documents();


            $userData = [];
            foreach ($data as $document) {
                $userData[] = $document->data();
            }


            return view('DataUser.updateuser', ['up'=>$userData],compact( 'roles', 'prodi'));
        }

        public function updateUser(Request $request)
        {
            $firestore = app('firebase.firestore');
            $mainCollection = $firestore->database()->collection('Employee');
            $documents = $mainCollection->documents();

            $data = [];
            $docid = null;
            foreach($documents as $doc){
                $documentData = $doc->data();
                $docid = $doc->id();

            }
            $userRef = $mainCollection->document($docid);
            $userRef->update([
                ['path' => 'NIP', 'value' => $request->nip],
                ['path' => 'Name', 'value' => $request->name],
                ['path' => 'email', 'value' => $request->email],
                ['path' => 'role', 'value' => $request->role],
                ['path' => 'jabatan', 'value' => $request->jabatan],
                ['path' => 'prodi', 'value' => $request->prodi],
            ]);








                return redirect('/datauser')->with('success', 'User data updated successfully');

        }
        public function deleteUser(Request $request)
        {
            $firestore = app('firebase.firestore');
            $mainCollection = $firestore->database()->collection('Employee');
            $documents = $mainCollection->documents();

            $data = [];
            $docid = null;
            foreach($documents as $doc){
                $documentData = $doc->data();
                $docid = $doc->id();

            }
            $userRef = $mainCollection->document($docid);
            $userRef->delete();
                return redirect('/datauser')->with('success', 'User data Deleted successfully');

        }

    }
























