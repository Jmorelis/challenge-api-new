<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255|unique:articles,title',
            'content'      => 'required|string',
            'status'       => 'nullable|in:draft,published',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.unique'   => 'Ya existe un artículo con este título.',
            'category_ids.required' => 'Debes asignar al menos una categoría.',
            'category_ids.*.exists' => 'Una de las categorías seleccionadas no es válida.',
        ];
    }
}