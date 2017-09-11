<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route()->named('events')) {
            return true;
        }
        return \Auth::user()->canDo('UPDATE_EVENTS');
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', ['required', 'unique:events,alias', 'max:255', 'regex:#^[\w-]#'], function ($input) {
            if ($this->route()->hasParameter('event') && $this->isMethod('post')) {
                $model = $this->route()->parameter('event');
                if (null === $model) return true;
                return ($model->alias !== $input->alias)  && !empty($input->alias);
            }

            return !empty($input->alias);
        });

        $validator->sometimes('img', 'mimes:jpg,bmp,png,jpeg|max:5120|required', function ($input) {
            if ($this->route()->named('create_event') && $this->isMethod('post')) {
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
                'cats' => ['digits_between:1,10', 'required', 'max:4294967295'],
                'organizer' => ['digits_between:1,10','required', 'max:4294967295'],
                'country' => ['digits_between:1,4','required', 'max:400'],
                'city' => ['digits_between:1,4','required', 'max:400'],
                'start' => 'date_format:"d-m-Y"|required',
                'stop' => 'date_format:"d-m-Y"|required',
                'img' => 'mimes:jpg,bmp,png,jpeg|max:5120',
                'imgalt' => ['string', 'nullable'],
                'imgtitle' => ['string', 'nullable'],
                'content' => 'string|nullable',
                'description' => 'string|nullable',
                'seo_title' => 'string|nullable',
                'seo_keywords' => 'string|nullable',
                'seo_description' => 'string|nullable',
                'seo_text' => 'string|nullable',
                'og_image' => 'string|nullable',
                'og_title' => 'string|nullable',
                'og_description' => 'string|nullable',
                'confirmed' => 'boolean|nullable',
                'slider' => 'array',
                'slider.*' => 'mimes:jpg,bmp,png,jpeg|max:5120',
            ];

            if ($this->request->has('slider')) {
                foreach ($this->request->get('slider') as $key=>$val) {
                    $rules['slider' . $key] = 'mimes:jpg,bmp,png,jpeg|max:5120';
                }
            }

            return $rules;

        } else {
            $rules = [
                'value' => ['nullable', 'string', 'between:1,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:\?\!\.]+$#u'],
                'param' => 'nullable|digits:1',
            ];
            if ($this->request->has('country')) {
                $rules['country'] = ['digits_between:1,4','nullable', 'max:400'];
            }
            if ($this->request->has('city')) {
                $rules['city'] = ['digits_between:1,4','nullable', 'max:400'];
            }
            if ($this->request->has('organizer')) {
                $rules['organizer'] = ['digits_between:1,10','nullable', 'max:4294967295'];
            }
            if ($this->request->has('cat')) {
                $rules['cat'] = ['digits_between:1,10', 'nullable', 'max:4294967295'];
            }
            return $rules;
        }
    }

    public function messages()
    {
        return [
            'slider.*.*' => 'В полях СЛАЙДЕРА должны быть файлы в формате "jpg,bmp,png,jpeg" не более 5120 байт',
            'country.*' => 'Ошибка получения данных поля country',
            'city.*' => 'Ошибка получения данных поля city',
            'organizer.*' => 'Ошибка получения данных поля organizer',
            'cat.*' => 'Ошибка получения данных поля cat',
        ];
    }
}
