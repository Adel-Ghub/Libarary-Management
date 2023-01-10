<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index()
{
    $users = User::all();
    return response()->json($users);
}
public function store(Request $request)
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

}
