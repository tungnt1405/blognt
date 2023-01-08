<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountriesRequest extends FormRequest
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
            'language' => 'required',
            'symbol' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     * 
     * @return array<string, mixed>
     */
    public function message()
    {
        return [
            'language.required' => trans('validation.setting.countries.language_required'),
            'symbol.required' => trans('validation.setting.countries.symbol_required'),
        ];
    }
}
