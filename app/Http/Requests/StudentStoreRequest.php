<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'password' => 'required|min:7',
            'confirmation_password' => 'required|same:password',
            'email' => 'required|email|unique:users,email',
            'nisn' => 'required|unique:students,nisn|digits:10|numeric'
        ];
    }

    public function messages(){
        $messages = [
            'name.required' => "Nama Lengkap Tidak Boleh Kosong!",
            'email.required' => "Email Tidak Boleh Kosong!",
            'password.required' => "Password Tidak Boleh Kosong!",
            'confirmation_password.required' => "Konfirmasi Password Tidak Boleh Kosong!",
            'nisn.required' => "NISN Tidak Boleh Kosong",
            'nisn.unique' => "NISN Sudah Pernah Terdaftar",
            'nisn.digits' => "NISN Harus Memiliki 10 Digit Angka",
            'nisn.numeric' => "NISN Harus Berisi Angka!",
            'password.min' => "Password Harus Memiliki Paling Tidak 7 Karakter!",
            'email.email' => "Mohon Masukkan Format Email yang Benar!",
            'email.unique' => "Email Sudah Pernah Digunakan Sebelumnya!",
            'confirmation_password.same' => "Konfirmasi Password Tidak Sama Dengan Password!",
        ];

        return $messages;
    }
}
