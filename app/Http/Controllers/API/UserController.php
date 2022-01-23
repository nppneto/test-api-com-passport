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
            return response()->json(['data' => $success], $this->statusList['success']);
        }

        return response()->json(['data' => 'Unauthorized'], $this->statusList['unauthorized']);
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
            return response()->json(['error' => $validator->errors()], 401);
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;

        return response()->json(['data' => $success], $this->statusList['success']);
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['data' => $user], $this->statusList['success']);
    }
}
