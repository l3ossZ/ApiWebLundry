<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // public function register(Request $request){
    //     $fields=$request->validate([
    //         'name'=>'required|string',
    //         'email'=>'required|string|unique:users,email',
    //         'password'=>'required|string|confirmed',
    //         'role'=>'required|string',
    //         'phone'=>'required|string|unique:users,phone',
    //         'realrole'=>'reqired|string'

    //     ]);

    //     if($fields['realrole']=='employee'){
    //         $employee=new Employee();
    //         $employee->name=$fields['name'];
    //         $employee->email=$fields['email'];
    //         $employee->password=$fields['password'];
    //         $employee->role=$fields['role'];
    //         $employee->phone=$fields['phone'];

    //     }

    //     $user=User::create([
    //         'name'=>$fields['name'],
    //         'email'=>$fields['email'],
    //         'password'=>bcrypt($fields['password']),
    //         'role'=>$fields['role'],
    //         'phone'=>$fields['phone'],
    //         'realrole'=>$fields['realrole']
    //     ]);

    //     $token=$user->createToken('mylaundry')->plainTextToken;
    //     $response=[
    //         'user'=>$user,
    //         'token'=>$token
    //     ];

    //     return response($response,201);
    // }
//     /**
    //  * Create a new AuthController instance.
    //  *
    //  * @return void
    //  */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY); // 422
        }

        if (! $token = JWTAuth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED); // 401
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     *
     */
    public function me()
    {
        return auth()->user();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
//            'user' => new UserResource(auth()->user())
        ]);
    }

    public function register(Request $request){
        $user=User::create([
            'name'=>$request->get('name'),
            'phone'=>$request->get('phone'),
            'email'=>$request->get('email'),
            'password'=>Hash::make($request->get('password')),
            'role'=>$request->get('role'),
            'realrole'=>$request->get('realrole')
        ]);

        if($request->get('realrole')=='employee'){
            $employee=new Employee();
            $employee->name=$request->get('name');
            $employee->phone=$request->get('phone');
            $employee->email=$request->get('email');
            $employee->password=Hash::make($request->get('password'));
            $employee->role=$request->get('role');
        }

        $response=[
                    'user'=>$user
                ];

        return response($response,201);
    }

}
