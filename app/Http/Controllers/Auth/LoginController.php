<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validasi = $request->validate([
            "email" => 'required',
            "password" => 'required',
        ]);
        if (auth()->attempt($validasi)) {
            $user = auth()->user();
            $token = $user->createToken($user);
            return (new UserResource($user))->additional([
                'Token' => $token->plainTextToken,
                'Selamat Datang' => $user->name,
            ]);
        }
        return response()->json(['msg' => 'Silahkan Cek Kembali Email atau Password Anda, Terima Kasih']);
    }
}
