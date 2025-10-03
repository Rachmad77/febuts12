<?php

namespace App\Http\Requests\Adm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProgramStudiRequest extends FormRequest
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
        $id = $this->id ?? null; // ambil ID dari hidden input atau route parameter

        return [
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('program_studi', 'code')->ignore($id),
            ],
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
            'code.required' => 'Kode program studi wajib diisi.',
            'code.unique'   => 'Kode program studi sudah ada.',
            'code.max'      => 'Kode program studi maksimal 10 karakter.',

            'name.required' => 'Nama program studi wajib diisi.',
            'name.unique'   => 'Nama program studi sudah ada.',
            'name.max'      => 'Nama program studi maksimal 255 karakter.',
        ];
    }
}
