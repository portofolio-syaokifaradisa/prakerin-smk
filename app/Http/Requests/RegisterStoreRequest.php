<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStoreRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'password' => 'required|min:7',
            'confirmation_password' => 'required|same:password',
            'email' => 'required|email|unique:users,email',
            'identity_number' => 'required'
        ];

        return $rules;
    }

    public function messages(){
        $messages = [
            'name.required' => "Nama Lengkap Tidak Boleh Kosong!",
            'email.required' => "Email Tidak Boleh Kosong!",
            'password.required' => "Password Tidak Boleh Kosong!",
            'confirmation_password.required' => "Konfirmasi Password Tidak Boleh Kosong!",
            'identity_number.required' => "Nomor Identitas Tidak Boleh Kosong",
            'password.min' => "Password Harus Memiliki Paling Tidak 7 Karakter!",
            'email.email' => "Mohon Masukkan Format Email yang Benar!",
            'email.unique' => "Email Sudah Pernah Digunakan Sebelumnya!",
            'confirmation_password.same' => "Konfirmasi Password Tidak Sama Dengan Password!",
        ];

        return $messages;
    }
}
