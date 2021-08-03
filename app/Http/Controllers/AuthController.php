<?php

namespace App\Http\Controllers;

use http\Client\Response;
use Illuminate\Http\Request;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;



class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'phone' => 'required|regex:/^0\d{9}$/|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Thông tin đăng nhập không chính xác !'], 401);
        }

        return $this->createNewToken($token);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $userId = \auth()->user()->id;
        $oldPass = \auth()->user()->password;

        if (password_verify($request->old_password, $oldPass)) {
            $user = User::where('id', $userId)->update(
                ['password' => bcrypt($request->new_password)]
            );
            return response()->json([
                'message' => 'Change password successfully !',
            ], 201);
        }
        return response()->json('Old password wrong!!', 400);

    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 600,
            'user' => auth()->user()
        ]);
    }
    public function addImage(Request $request){
        try{

            if ($request->hasFile('image')) {

                $userId = \auth()->user()->id;
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('/uploadedimages'), $imageName);
                $user = User::find($userId);
                $user->image = $imageName;
                $user->save();
                return response()->json([
                'user' => $user
                ]);;
            }
    }
    catch( Exception $e){
        return $e->getMessage();
    };
}
}
