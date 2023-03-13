<?php

namespace App\Http\Controllers;

// use App\Traits\GeneralTrait;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Controller;
// use Illuminate\Http\JsonResponse;
// use Tymon\JWTAuth\Claims\JwtId;
// use Tymon\JWTAuth\Exceptions\JWTException;
// use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
// use Tymon\JWTAuth\Exceptions\TokenInvalidException;
// use Tymon\JWTAuth\Facades\JWTAuth;

// class AuthController extends Controller
// {
//     use GeneralTrait;
//     /**
//      * Create a new AuthController instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('auth:api', ['except' => ['login']]);
//     }

//     /**
//      * Get a JWT via given credentials.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function login()
//     {
//         $credentials = request(['email', 'password']);

//         if (! $token = auth()->attempt($credentials)) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }
//         $apitoken = Auth::guard('api')->attempt($credentials);

//         return $this->respondWithToken($token,$apitoken);
//         // return  $user;
//     }

//     /**
//      * Get the authenticated User.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function me()
//     {
//         // return response()->json(Auth::guard('api')->user());
//         return response()->json(auth()->user());
//     }

//     /**
//      * Log the user out (Invalidate the token).
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     // public function logout(Request $request)
//     // {
//     //     // $auth_token =  Request->header('Authorization');
        
//     //     auth()->logout();

//     //     return response()->json(['message' => 'Successfully logged out']);
//     // }
//     public function logout(Request $request)
   
//     {
//         $auth_token =  substr($request->header('Authorization'),7);
        
//          if($auth_token){
//             try {
//            JWTAuth::setToken($auth_token)->invalidate(); 
//                 // JWTAuth->setToken($auth_token)->validate();
                
//             } catch (TokenInvalidException $th) {
                
//                 return $this->returnValidationError(500,'Invalid Token');
//             }catch (TokenExpiredException $th) {
//                 return $this->returnValidationError(500,'Invalid Token');
                
//             }catch(TokenBlacklistedException $th) {
//                 return $this->returnValidationError(500,'Invalid Token');

//             }
//             return  $this->returnSuccessMessage('success logout');
//          }

//         return response()->json(['message' => 'Successfully logged out']);
//     }

//     /**
//      * Refresh a token.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function refresh()
//     {
//         return $this->respondWithToken(auth()->refresh(true,true));
//     }

//     /**
//      * Get the token array structure.
//      *
//      * @param  string $token
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     protected function respondWithToken($token,$apiokent)
//     {
//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'bearer',
//             'expires_in' => auth('api')->factory()->getTTL() * 60,
//             'token' => $apiokent,
//         ]);
//     }
// }

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
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
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // $token = Auth::attempt($credentials);

        $token = auth('api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
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

}