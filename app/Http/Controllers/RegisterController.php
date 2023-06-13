<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\GradeClass;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterStoreRequest;
use App\Mail\RegisterMail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index(){
        $class = GradeClass::with('department')->get();

        return view('auth.register.index',[
            'title' => "Pendaftaran",
            'class' => $class
        ]);
    }

    public function register(RegisterStoreRequest $request){
        $request_validated = $request->validated();

        if(strlen($request_validated['identity_number']) == 10){
            try{
                $verification_code = Str::random(10);
                $user = User::create([
                    'email' => $request_validated['email'],
                    'password' => Hash::make($request_validated['password']),
                    'role' => "STUDENT",
                    'code_verification' => $verification_code
                ]);
    
                
                Student::create([
                    'name' => $request_validated['name'],
                    'nisn' => $request_validated['identity_number'],
                    'user_id' => $user->id,
                    'grade_class_id' => $request->class,
                ]);

                Mail::to($request_validated['email'])->send(new RegisterMail(
                    "Siswa", 
                    $request_validated['name'],
                    $request_validated['identity_number'],
                    $verification_code
                ));
            }catch(Exception $e){
                dd($e);
                return redirect(Route('register'))->with('error', 'Gagal Mendaftar Akun, Silahkan Coba Lagi!');
            }

            return redirect(Route('login'))->with('success', 'Sukses Mendaftar Akun, Silahkan Verifikasi AKun Melalui Email!');
        }else if(strlen($request_validated['identity_number']) == 18){
            try{
                $verification_code = Str::random(10);
                $user = User::create([
                    'email' => $request_validated['email'],
                    'password' => Hash::make($request_validated['password']),
                    'role' => "TEACHER",
                    'code_verification' => $verification_code
                ]);

                Teacher::create([
                    'name' => $request_validated['name'],
                    'nip' => $request_validated['identity_number'],
                    'user_id' => $user->id,
                    'position' => $request->position,
                    'grade_class_id' => $request->class
                ]);

                Mail::to($request_validated['email'])->send(new RegisterMail(
                    "Guru", 
                    $request_validated['name'],
                    $request_validated['identity_number'],
                    $verification_code
                ));
            }catch(Exception $e){
                return redirect(Route('register'))->with('error', 'Gagal Mendaftar Akun, Silahkan Verifikasi AKun Melalui Email!');
            }

            return redirect(Route('login'))->with('success', 'Sukses Mendaftar Akun, Silahkan Login!');
        }
    }
}
