<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherStoreRequest extends FormRequest
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
            'nip' => 'required|unique:teachers,nip|digits:18|numeric',
            'position' => 'required',
            'class_id' => 'required'
        ];
    }

    public function messages(){
        $messages = [
            'name.required' => "Nama Lengkap Tidak Boleh Kosong!",
            'email.required' => "Email Tidak Boleh Kosong!",
            'password.required' => "Password Tidak Boleh Kosong!",
            'confirmation_password.required' => "Konfirmasi Password Tidak Boleh Kosong!",
            'nip.required' => "NIP Tidak Boleh Kosong",
            'nip.unique' => "NIP Sudah Pernah Terdaftar",
            'nip.digits' => "NIP Harus Memiliki 18 Digit Angka",
            'nip.numeric' => "NIP Harus Berisi Angka!",
            'password.min' => "Password Harus Memiliki Paling Tidak 7 Karakter!",
            'email.email' => "Mohon Masukkan Format Email yang Benar!",
            'email.unique' => "Email Sudah Pernah Digunakan Sebelumnya!",
            'confirmation_password.same' => "Konfirmasi Password Tidak Sama Dengan Password!",
            'position.required' => "Jabatan Tidak Boleh Kosong!",
            'class_id.required' => "Mohon Pilih kelas Terlebih Dahulu!"
        ];

        return $messages;
    }
}
