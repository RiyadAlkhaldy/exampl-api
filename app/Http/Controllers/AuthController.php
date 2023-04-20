<?php

namespace App\Http\Controllers;



use App\Traits\AuthVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
use AuthVerify;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        // $request->validate([
        //     'email' => 'required|string|email',
        //     'password' => 'required|string',
        // ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        //for me
        $user = User::where(
           
            'email' , $request->email,
            
        )->first();
        $token = auth('api')->login($user);

        $user = Auth::user();
        return response()->json([ 
                'status' => 'success',
                'message' => 'User login successfully',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function register(Request $request){
        
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6',
        // ]);
 $verifiedUser = $this->registerVerify($request);
//  return $verifiedUser->age === null?"null":"empty";
//  return $verifiedUser;
 if(isset($verifiedUser))
       {
         $colloge = $this->getColloge($verifiedUser);
         $section = $this->getSection($verifiedUser);
         if(!isset($colloge)){
            $this->setColloge($verifiedUser);
            $colloge = $this->getColloge($verifiedUser);
         }
         if(!isset($section)){
            $this->setSection($verifiedUser,$colloge->id);
            $section = $this->getSection($verifiedUser);
         }

        $user = User::create([
            'name' => $verifiedUser->name,
            'email' => $request->email,
            'colloge_id' => $colloge->id,
            'section_id' => $section->id,
            'university_id' => $verifiedUser->university_id,

            'id_number' => $verifiedUser->id_number ,
            'password' => Hash::make($verifiedUser->id_number),
            'type'=>$request->type,
        ]);
        // $token = Auth::attempt($credentials);

        $token = auth('api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user->find($user->id),
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
       }
       else {
        return 
        response()->json([
            'status' => 'faild',
            'message' => 'User not created  ',
            'user' => null,
            'authorisation' => [
                'token' => null,
                'type' => 'bearer',
            ]
        ]);
       }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function me()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    public function eexel()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
$reader->setReadDataOnly(true);

        $spreadsheet = $reader->load(public_path()."\app\public\student.xlsx" );
    $spreadsheet->getActiveSheet();
    //    $spreadsheet->getRibbonXMLData ();
        return  $spreadsheet->getRibbonXMLData ('A');
        // $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
// $reader->setReadDataOnly(true);
// $spreadsheet = $reader->load("05featuredemo.xlsx");
    }

}