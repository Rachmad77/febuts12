<?php

namespace App\Http\Requests\Adm;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BlogCategoryRequest extends FormRequest
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
                Rule::unique('blog_categories', 'name')->ignore($id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama Kategori Blog wajib diisi.',
            'name.unique'   => 'Data Kategori Blog sudah ada.',
            'name.max'      => 'Nama Kategori Blog maksimal 255 karakter.',
        ];
    }
}
