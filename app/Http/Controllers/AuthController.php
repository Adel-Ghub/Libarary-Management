<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return response()->json(['user' => $user], 201);
    }
    
public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email',
        'password' => 'required|string'
    ]);
    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }
    $credentials = $request->only(['email', 'password']);
    if (!Auth::attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    $user = auth()->user();
    $token = $user->createToken('API Token')->accessToken;
    return response()->json(['user' => $user, 'token' => $token], 200);
}

public function logout(Request $request)
{
    $request->user()->token()->revoke();
    return response()->json(['message' => 'Successfully logged out'], 200);
}

}
