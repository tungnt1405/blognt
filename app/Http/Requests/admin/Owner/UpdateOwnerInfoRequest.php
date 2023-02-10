<?php

namespace App\Http\Requests\admin\Owner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOwnerInfoRequest extends FormRequest
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
            'experience' => 'required',
            'project' => 'required',
            'career_goals' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'experience.required' => 'Hãy viết kinh nghiệm đi!',
            'project.required' => 'Kể dự án mày làm đi chứ',
            'career_goals.required' => 'Mục tiêu của mày là gì',
        ];
    }
}
