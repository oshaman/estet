<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Article extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('ADD_ARTICLES');
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', ['required', 'unique:articles,alias', 'max:255', 'regex:#^[\w-]#'], function ($input) {
//  bind article in RouteServiceProvider
            if ($this->route()->hasParameter('article') && $this->isMethod('post')) {
                $model = $this->route()->parameter('article');
                if (null === $model) return true;
                return ($model->alias !== $input->alias)  && !empty($input->alias);
            }

            return !empty($input->alias);
        });

        $validator->sometimes('img', 'mimes:jpg,bmp,png,jpeg|max:5120|required', function ($input) {
//  bind article in RouteServiceProvider
            if ($this->route()->named('create_article') && $this->isMethod('post')) {
                return true;
            }

            return false;
        });

        return $validator;
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
                'title' => ['required', 'string', 'between:4,255'],
                'cats' => ['digits_between:1,4', 'nullable', 'required'],
                'tags' => 'array',
                'img' => 'mimes:jpg,bmp,png,jpeg|max:5120',
                'imgalt' => ['string', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:\?\!]+$#u', 'nullable'],
                'imgtitle' => ['string', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:\?\!]+$#u', 'nullable'],
                'content' => 'string|nullable',
                'seo_title' => 'string|nullable',
                'seo_keywords' => 'string|nullable',
                'seo_description' => 'string|nullable',
                'seo_text' => 'string|nullable',
                'og_image' => 'string|nullable',
                'og_title' => 'string|nullable',
                'og_description' => 'string|nullable',
                'confirmed' => 'boolean|nullable',
                'own' => ['boolean', 'nullable', 'required'],
                'outputtime' => 'date_format:"Y-m-d H:i"|nullable',
            ];

            if ($this->request->has('tags')) {
                foreach ($this->request->get('tags') as $key => $val) {
                    $rules['tags.' . $key] = ['digits_between:1,10', 'nullable'];
                }
            }
            return $rules;

        } else {
            $rules = [
                'value' => ['nullable', 'string', 'between:1,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:\?\!\.]+$#u'],
                'param' => 'nullable|digits:1',
            ];
            return $rules;
        }
    }

    public function messages()
    {
        return [
            'tags.*.*' => 'Недопустимые символы в поле Теги',
        ];
    }
}
