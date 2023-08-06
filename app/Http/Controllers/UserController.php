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
             // Add other roles if needed
         ];

         $prodi = [
             'Manufaktur',
             'Mekatronika',
             'Teknik Elektro',
             'Teknologi Rekayasa Perangkat Lunak',
             // Add other prodi options if needed
         ];

         try {
             // Create Employee Account
             $userCredential = $this->auth->createUserWithEmailAndPassword($request->input('email'), '12345678');
             $user = $userCredential;

             if ($user) {
                 $uid = $user->uid;

                 // Store Employee Data
                 $employeeCollection = app('firebase.firestore')->database()->collection('Employee');
                 $employeeCollection->document($uid)->set([
                     "NIP" => $request->input('nip'),
                     "Name" => $request->input('name'),
                     "email" => $request->input('email'),
                     "role" => $request->input('role'), // Assuming 'role' is a string value representing the selected role from the request
                     "jabatan" => $request->input('jabatan'),
                     "prodi" => $request->input('prodi'), // Assuming 'prodi' is a string value representing the selected prodi from the request
                     "createdAt" => now()->toIso8601String(),
                     "Uid" => $uid,
                 ]);

                 // Return response or redirect
                 return redirect('/datauser');
             }
         } catch (AuthException $e) {
             return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 400);
         }
     }

        public function deleteEmployee(Request $request)
        {
            $employeeRef = app('firebase.firestore')->database()->collection('Employee')->document()->delete();


            // Your success/failure handling logic goes here

            // Return a response
             return redirect('/datauser');
        }
        public function addUserView(){
            $roles = [
                'Admin',
                'Dosen',
                'Employee',
                // Add other roles if needed
            ];

            $prodi = [
                ' ',
                'Manufaktur',
                'Mekatronika',
                'Teknik Elektro',
                'Teknologi Rekayasa Perangkat Lunak',
                // Add other prodi options if needed
            ];
            return view('DataUser.tambahuser', compact('roles'), compact('prodi'));
        }

        public function editUser($e) {
            // Assuming that $e is the 'Uid' of the user you want to edit

            // Import the Firestore facade if not already done


            // Retrieve the data from Firestore using the facade
            $roles = [
                'Admin',
                'Dosen',
                'Employee',
                // Add other roles if needed
            ];

            $prodi = [
                'Manufaktur',
                'Mekatronika',
                'Teknik Elektro',
                'Teknologi Rekayasa Perangkat Lunak',
                // Add other prodi options if needed
            ];
            $data = app('firebase.firestore')
                ->database()
                ->collection('Employee')
                ->where('Uid', '=', $e)
                ->documents();

            // Convert the retrieved data to an array
            $userData = [];
            foreach ($data as $document) {
                $userData[] = $document->data();
            }

            // Pass the user data to the view for updating the user
            return view('DataUser.updateuser', ['up'=>$userData],compact( 'roles', 'prodi'));
        }

        public function updateUser(Request $request)
        {
            $roles = [
                'Admin',
                'Dosen',
                'Employee',
                // Add other roles if needed
            ];

            $prodi = [
                'Manufaktur',
                'Mekatronika',
                'Teknik Elektro',
                'Teknologi Rekayasa Perangkat Lunak',
                // Add other prodi options if needed
            ];

            // Check if the provided role and prodi values are valid
            if (!in_array($request->role, $roles) || !in_array($request->prodi, $prodi)) {
                return redirect('/datauser')->with('error', 'Invalid role or prodi value');
            }

            $updateData = [
                ['path' => 'NIP', 'value' => $request->nip],
                ['path' => 'Name', 'value' => $request->name],
                ['path' => 'email', 'value' => $request->email],
                ['path' => 'role', 'value' => $request->role],
                ['path' => 'jabatan', 'value' => $request->jabatan],
                ['path' => 'prodi', 'value' => $request->prodi]
            ];

            $documentId = $request->uid; // Assuming uid contains the specific document ID
            app('firebase.firestore')->database()->collection('Employee')->document($documentId)->update($updateData);

            return redirect('/datauser')->with('success', 'User data updated successfully');
        }




    }
























