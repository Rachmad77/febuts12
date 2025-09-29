<?php

namespace App\Http\Requests\Adm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageCategoryRequest extends FormRequest
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
                Rule::unique('page_categories', 'name')->ignore($id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Kategori Halaman wajib diisi.',
            'name.unique'   => 'Data Kategori Halaman sudah ada.',
            'name.max'      => 'Nama Kategori Halaman maksimal 255 karakter.',
        ];
    }
}
