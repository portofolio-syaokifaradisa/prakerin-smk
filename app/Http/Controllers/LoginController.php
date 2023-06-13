<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('auth.login.index',[
            'title' => "Login"
        ]);
    }

    public function login(LoginRequest $request){
        $validated_request = $request->validated();

        $user = User::where('email', $validated_request['email'])->get();
        if(!$user[0]->is_verified){
            return redirect(Route('login'))->with('error', 'login gagal, Silahkan Verifikasi Akun Melalui Email Terlebih Dahulu!');
        }

        if (Auth::attempt(['email' => $validated_request['email'], 'password' => $validated_request['password']])) {
            return redirect(Route('home'));
        }else{
            return redirect(Route('login'))->with('error', 'login gagal, Silahkan Coba Lagi!');
        }
    }
}
