<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        if (!Hash::check($password, $user->password)) {
            return response()->json(['message' => 'Invalid password'], 401);
        }
        Auth::loginUsingId($user->id);
        $token = csrf_token();
        return redirect()->route('dashboard');
    }

    public function register(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $name = $request->name;

        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json(['message' => 'User already exists'], 400);
        }
        $user = new User();
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->name = $name;
        $user->save();
        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function loginPage()
    {
        // if (Auth::user() != null) {
        //     return redirect(route('dashboard'), 302, ['name' => Auth::user()->name]);
        // }
        return view('login');
    }
}
