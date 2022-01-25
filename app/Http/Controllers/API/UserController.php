<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public $statusList = [
        'success' => 200,
        'unauthorized' => 401,
        'not-found' => 404,
        'internal-error' => 500,
    ];

    public function login()
    {
        $credentials = [
            'email' => request('email'),
            'password' => request('password'),
        ];
         
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json([
                'data' => $success,
                'status' => getHttpStatusMessages(200),
            ], 200);
        }

        return response()->json([
            'data' => [],
            'status' => getHttpStatusMessages(401),
        ], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => getHttpStatusMessages(400),
            ], 400);
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json([
            'data' => $success,
            'status' => getHttpStatusMessages(200),
        ], 200);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json([
            'data' => $user,
            'status' => getHttpStatusMessages(200),
        ], 200);
    }
}
