<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StoreSideBarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // return true;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'avatar' => 'required'
        ];

        // return [];
    }

    public function messages()
    {
        return [
            'name.required' => 'Mày không có tên thằng lol 😠',
            'name.max' => 'Tên đéo gì dài thế ngắn thôi 😡',
            'avatar.required' => 'Mặt mày đâu thằng lol này 🤬'
        ];
    }

    protected function failedValidation(ValidationValidator $validator)
    {
        throw (new ValidationException($validator))
            ->errorBag($this->errorBag);
    }
}