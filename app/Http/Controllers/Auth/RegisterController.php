<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
        ]);
        $request['password'] = bcrypt($request->password);
        $user = User::create($request->all());
        $token = $user->createToken($user);
        return (new UserResource($user))->additional([
            'Token' => $token->plainTextToken,
            'Selamat Datang' => $user->name,
        ]);
    }
}
