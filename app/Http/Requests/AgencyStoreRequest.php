<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgencyStoreRequest extends FormRequest
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
            'name' => 'required|unique:agencies,name',
            'address' => 'required',
            'phone' => 'required|numeric',
            'leader' => 'required',
            'characteristic' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required' => "Nama Industri Tidak Boleh Kosong!",
            'name.unique' => "Nama Industri Sudah Pernah Terdaftar!",
            'address.required' => "Alamat Tidak Boleh Kosong!",
            'phone.required' => "Nomor Telepon Tidak Boleh Kosong!",
            'phone.numeric' => "Isikan Nomor Telepon Hanya Dengan Angka!",
            'leader.required' => "Pimpinan Industri Tidak Boleh Kosong!",
            'characteristic.required' => 'Karakteristik Industri Tidak Boleh Kosong!'
        ];
    }
}
