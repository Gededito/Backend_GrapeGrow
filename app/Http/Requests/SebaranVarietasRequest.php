<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SebaranVarietasRequest extends FormRequest
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
            'deskripsi' => 'required|string',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'jumlah_tanaman' => 'required|numeric',
            'menjual_bibit' => 'required|boolean',
        ];
    }
}
