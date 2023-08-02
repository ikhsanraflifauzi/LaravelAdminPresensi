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
                        "role" => $request->input('role'),
                        "jabatan"=> $request->input('jabatan'),
                        "prodi" => $request->input('prodi'),
                        "createdAt" => now()->toIso8601String(),
                        "Uid" => $uid,
                    ]);

                    // Send Email Verification
                   /*  $user->sendEmailVerification(); */

                    // Logout Admin
                    /* $auth->signOut();
 */
                    // Login Admin Again (Optional, depending on your use case)
                    $auth->signInWithEmailAndPassword($emailAdmin, $passwordAdmin);

                    // Return response or redirect
                    return response()->json(['success' => true, 'message' => 'Akun user telah ditambahkan.'], 200);
                }
            } catch (EmailExistsException $e) {
                return response()->json(['success' => false, 'message' => 'Email yang anda gunakan telah terdaftar.'], 400);
            } catch (AuthException $e) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan.'], 400);
            }
        }
        public function addEmployee(Request $request)
        {

            // Get the request data
            $nip = $request->input('nip');
            $name = $request->input('name');
            $email = $request->input('email');
            $role = $request->input('role');
            $jabatan = $request->input('jabatan');
            $prodi = $request->input('prodi');
           /*  if (empty($nip) || empty($name) || empty($email) || empty($role) || empty($prodi) || empty($jabatan)) {

                return redirect()->back()->withInput()->withErrors('All fields are required.');
            } */

            $employeeRef = app('firebase.firestore')->database()->collection('Employee')->newDocument();
            $employeeRef->set([
                "NIP" => $nip,
                "Name" => $name,
                "email" => $email,
                "role" => $role,
                "jabatan"=> $jabatan,
                "prodi" => $prodi,
                "createAT" => now()->toIso8601String(),
                "Uid" => $employeeRef->id(),
            ]);

            // Your success/failure handling logic goes here

            // Return a response
             return redirect('/datauser');
        }
        public function addUserView(){
            return view('DataUser.tambahuser');
        }
    }
























