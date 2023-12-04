<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            'title' => 'required|max:100|min:3',
            'text' => 'required|min:5',
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Devi inserire il titolo',
            'title.max' => 'Non puoi inserire più di :max caratteri',
            'title.min' => 'Devi inserire almeno :min caratteri',
            'text.required' => 'Devi inserire una descrizione del progetto',
            'text.min' => 'Devi inserire almeno :min caratteri',
        ];
    }
}
