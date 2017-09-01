<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TmpblogRequest extends FormRequest
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
            if (!$this->has('param')) {
                $rules = [
                    'img' => 'mimes:jpg,bmp,png,jpeg|max:5120|nullable',
                    'title' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:\?\+\"\.]+$#u'],
                    'cats' => ['digits_between:1,4', 'nullable'],
                    'moder' => 'boolean|nullable',
                    'content' => 'string|nullable',
                ];

                return $rules;
            } else {
                $rules = [
                    'value' => ['nullable', 'string', 'between:1,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:]+$#u'],
                    'param' => 'nullable|digits:1',
                ];
                return $rules;
            }
        } else {
            $rules = [
                'value' => ['nullable', 'string', 'between:1,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:]+$#u'],
                'param' => 'nullable|digits:1',
            ];
            return $rules;
        }
    }
}
