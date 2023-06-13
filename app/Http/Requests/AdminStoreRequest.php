<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminStoreRequest extends FormRequest
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
            'email' => 'required|unique:users,email',
            'password' => 'required|min:7',
            'confirmation_password' => 'required|same:password',
        ];
    }

    public function messages(){
        return [
            'name.required' => "Nama Pemegang Akun Tidak Boleh Kosong!",
            'email.required' => 'Email Tidak Boleh Kosong!',
            'email.unique' => 'Email Sudah Pernah Terdaftar!',
            'password.required' => "Password Tidak Boleh Kosong!",
            'password.min' => "Password Harus Memiliki Paling Tidak 7 Karakter!",
            'confirmation_password.required' => "Konfirmasi Password Tidak Boleh Kosong!",
            'confirmation_password.same' => "Konfirmasi Password Tidak Sama Dengan Password!",
        ];
    }
}
