<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSebaranPenyakit extends FormRequest
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
            'nama' => 'string',
            'gejala' => 'string',
            'solusi' => 'string',
            'gambar' => 'image|mimes:jpeg,png,jpg,gif',
            'lat' => 'numeric',
            'lon' => 'numeric'
        ];
    }
}
