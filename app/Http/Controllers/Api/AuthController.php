<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
        $this->middleware('auth:api', ['except' => ['login','register']]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone]',
            'password' => 'required|string|min:6',
            'role' => 'required',
            'realrole' => 'required'
        ]);


        $user = new User();
        $user->name=$request->get('name');
        $user->phone=$request->get('phone');
        $user->email=$request->get('email');
        $user->password=Hash::make($request->get('password'));
        $user->role=$request->get('role');
        $user->realrole=$request->get('realrole');
        $user->save();


        if($request->get('realrole')=='EMPLOYEE'){
            $employee=new Employee();
            $employee->name=$request->get('name');
            $employee->phone=$request->get('phone');
            $employee->email=$request->get('email');
            $employee->password=Hash::make($request->get('password'));
            $employee->role=$request->get('role');
            $employee->save();
        }

        else if($request->get('realrole')=='OWNER'){
            $employee=new Employee();
            $employee->name=$request->get('name');
            $employee->phone=$request->get('phone');
            $employee->email=$request->get('email');
            $employee->password=Hash::make($request->get('password'));
            $employee->role=$request->get('role');
            $employee->save();
        }

        else if($request->get('realrole')=='CUSTOMER'){
            $customer = new Customer();
            $customer->name=$request->get('name');
            $customer->phone=$request->get('phone');
            $customer->email=$request->get('email');
            $customer->pwd=Hash::make($request->get('password'));
            $customer->isMembership=false;
            $customer->memService=null;
            $customer->memCredit=0;
            $customer->save() ;
        }


        $response=[
                    'user'=>$user
                ];

        return response($response,201);
    }

//    public function register(Request $request) {
////        $validator = Validator::make($request->all(), [
////            'name' => 'required|string|between:2,100',
////            'email' => 'required|string|email|max:100',
////            'phone' => 'required|numeric|digits:10',
////            'password' => 'required|string|min:6',
////            'role' => 'required',
////            'realrole' => 'required'
////        ]);
////        if($validator->fails()){
////            return response()->json($validator->errors()->toJson(), 400);
////        }
//        $user = User::create(array_merge(
////            $validator->validated(),
//
////            'name'=>$request->get('name'),
////            'phone'=>$request->get('phone'),
////            'email'=>$request->get('email'),
////            'role'=>$request->get('role'),
////            'realrole'=>$request->get('realrole'),
////            'password' => bcrypt($request->password)]
//
//        ));
//        return response()->json([
//            'message' => 'User successfully registered',
//            'user' => $user
//        ], 201);
//    }

}
