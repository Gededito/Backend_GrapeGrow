<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSebaranVarietas extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required|string',
            'jumlah_tanaman' => 'required|string',
            'menjual_bibit' => 'required|boolean',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ];
    }

    public function message()
    {
        return [
            'nama.unique' => 'Nama Varietas sudah ada',
            'gambar.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
        ];
    }
}
