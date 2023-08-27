<?php

namespace App\Http\Requests\admin\Posts;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'thumbnail_posts' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'public_date' => 'required',
            'category_id' => 'required',
            'title' => 'required|max:1000',
            'slug' => 'required',
            'description' => 'max:3000',
            'content' => 'required'
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
            'thumbnail_posts.image' => 'Hãy upload ảnh thì bot mới đọc để SEO chứ.',
            'thumbnail_posts.mimes' => 'Upload bọn này: jpeg,png,jpg,gif,svg',
            'thumbnail_posts.max' => 'Dung lượng thấp thôi upload cao tốn tiền (size < 2mb).',
            'public_date' => 'Thiếu ngày phát hành',
            'category_id' => 'Thiếu chủ đề của bài viết',
            'title.required' => 'Tiêu đề bài viết thiếu',
            'title.max' => 'Tiêu đề nhỏ hơn 1000 từ',
            'slug' => 'Thiếu tiêu đề không dấu để hiển thị trên URL',
            'description' => 'Mô tả ngắn gọn 3000 từ',
            'content.required' => 'Thiếu nội dung bài viết',
        ];
    }
}
