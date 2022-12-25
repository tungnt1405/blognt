<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class AddCountriesRequest extends FormRequest
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
            // 'countries.language_name.*' => 'required'
        ];
    }

    /**
     * Get the validation message that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            // 'required' => 'Hãy nhập ngôn ngữ để quản lý.'
        ];
    }
}
