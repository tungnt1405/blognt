<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Cấm xoá tên thằng lol. Tao vẫn giữ tên nên cập nhật thôi cấm xoá 😒',
            'name.max' => 'Tên đéo gì dài thế ngắn thôi 😡',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))->errorBag($this->errorBag);
    }
}
