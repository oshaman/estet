<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPerson extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('EDIT_USERS');
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias','unique:persons|max:246|alpha_dash', function ($input) {

            if ($this->route()->hasParameter('user')) {
                $model = $this->route()->parameter('user')->person;
                if (null === $model) return true;
                return (($model->alias !== $input->alias)  && !empty($input->alias));
            }

            return !empty($input->alias);

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
            if (!$this->has('param')) {
                $rules = [
                    'name' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ\-\s]+$#u'],
                    'lastname' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ\-\s]+$#u'],
                    'phone' => ['required', 'between:4,255', 'regex:#^[0-9()\,\-\s\+]+$#'],
                    'specialty' => 'required|array',
                    'services' => 'required|array',
                    'category' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\,\-\s\;\.]+$#u', 'nullable'],
                    'job' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9()№\,\-\s\;\\\/\.\"]+$#u', 'nullable'],
                    'address' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9№_\,\-\s\;\\\/\.]+$#u', 'nullable'],
                    'site' => 'url|max:255|nullable',
                    'img' => 'mimes:jpg,bmp,png,jpeg|max:5120|nullable',
                    'month'=>'regex:#^[0-9]{1,2}$#',
                    'year'=>'regex:#^[0-9]{4}$#',
                    'shedule' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9:\,\-\s\;\\\/\.]+$#u', 'nullable'],
                    'content' => 'string|nullable',
                ];

                if ($this->request->has('specialty')) {
                    foreach ($this->request->get('specialty') as $key => $val) {
                        $rules['specialty.' . $key] = ['digits_between:1,3', 'nullable'];
                    }
                }
                if ($this->request->has('services')) {
                    foreach($this->request->get('services') as $key => $val)
                    {
                        $rules['services.'.$key] = ['regex:#^[a-zA-zа-яА-ЯёЁ0-9():№_\,\-\s\;\\\/\.]+$#u', 'nullable'];
                    }

                }

                return $rules;

            } else {
                $rules = [
                    'value' => 'string|nullable|alpha_dash',
                    'param' => 'nullable|digits:1',
                ];
                return $rules;
            }
        }

        return [
            //
        ];
    }

    public function messages()
    {
        return [
            'specialty.*.*' => 'В поле Специальность должны быть от :min до :max цифр.',
            'services.*.*' => 'Недопустимые символы в поле Услуги',
        ];
    }
}
