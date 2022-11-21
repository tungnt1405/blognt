<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnerRequest extends FormRequest
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
            'name_owner' => 'required|max:255',
            'thumbnail' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name_owner.required' => 'Mày không có tên thằng lol😠',
            'name_owner.max' => 'Tên đéo gì dài thế ngắn thôi😡',
            'thumbnail.required' => 'Mặt mày đâu thằng lol này🤬'
        ];
    }
}