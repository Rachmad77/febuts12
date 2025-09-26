<?php

namespace App\Http\Requests\Adm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

Class ProgramStudiRequest extends FormRequest
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
         $id = $this->id ?? null; // ambil ID dari input hidden di form
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('program_studi', 'name')->ignore($id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama program studi wajib diisi.',
            'name.unique'   => 'Data program studi sudah ada.',
            'name.max'      => 'Nama program studi maksimal 255 karakter.',
        ];
    }
}