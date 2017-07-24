<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('UPDATE_BLOG');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            $rules = [
                'title' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:]+$#u'],
                'cats' => ['digits_between:1,4', 'nullable'],
                'tags' => 'array',
                'img' => 'mimes:jpg,bmp,png,jpeg|max:5120|nullable',
                'content' => 'string|nullable',
                'alias' => 'unique:blogs,alias|max:255|alpha_dash',
                'seo_title' => 'string|nullable',
                'seo_keywords' => 'string|nullable',
                'seo_description' => 'string|nullable',
                'seo_text' => 'string|nullable',
                'og_image' => 'string|nullable',
                'og_title' => 'string|nullable',
                'og_description' => 'string|nullable',
                'confirmed' => 'boolean|nullable',
            ];

            if ($this->request->has('tags')) {
                foreach ($this->request->get('tags') as $key => $val) {
                    $rules['tags.' . $key] = ['digits_between:1,10', 'nullable'];
                }
            }
            return $rules;
        }

        return [
            //
        ];
    }

    public function messages()
    {
        return [
            'tags.*.*' => 'Недопустимые символы в поле Теги',
        ];
    }
}
