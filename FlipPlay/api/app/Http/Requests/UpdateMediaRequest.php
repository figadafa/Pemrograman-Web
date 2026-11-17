<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMediaRequest extends FormRequest
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
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('media', 'title')->ignore($this->route('media')),
            ],
            'category' => 'sometimes|required|string|in:Anime,Drama,Manga,Light Novel',
            'creator' => 'sometimes|required|string|max:255',
            'year' => 'sometimes|required|integer|min:1900|max:2100',
            'studio' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'genre' => 'nullable|string|max:255',
            'total_volumes' => 'nullable|integer|min:0',
            'duration_minutes' => 'nullable|integer|min:0',
            'total_chapters' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Judul media wajib diisi',
            'title.unique' => 'Judul media sudah ada',
            'category.in' => 'Kategori harus salah satu dari: Anime, Drama, Manga, Light Novel',
            'creator.required' => 'Nama creator wajib diisi',
            'year.required' => 'Tahun wajib diisi',
        ];
    }
}
