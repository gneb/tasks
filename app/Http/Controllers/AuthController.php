<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Wishlist;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use HttpResponses;

    public function __construct(){}

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        
        if(!Auth::attempt($request->only('email', 'password'))){
            return $this->error('', 'wrong_credentials', 401);
        }
        return $this->getUserResponseByEmail($request->email);
    }


    public function register(RegisterUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole('User');

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Api Token of '. $user->username)->plainTextToken
        ]);
    }

    private function getUserResponseByEmail($email)
    {
        $user = User::where('email', $email)->first();
        if(is_null($user))
        {
            return $this->error('', 'please_register_first', 400);
        }

        $user->getPermissionsViaRoles();
        return $this->success([
            'user' => $user,
            'token' => $user->createToken('Api Token of '. $user->name)->plainTextToken,

        ]);
    }

    public function logout()
    {
        return 'logout';
    }

}