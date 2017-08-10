<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstablishmentsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('UPDATE_ESTABLISHMENT');
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', ['required', 'unique:establishments,alias', 'max:255', 'alpha_dash'], function ($input) {
            if ($this->route()->hasParameter('establishment') && $this->isMethod('post')) {
                $model = $this->route()->parameter('establishment');
                if (null === $model) return true;
                return ($model->alias !== $input->alias)  && !empty($input->alias);
            }
            return !empty($input->alias);
        });

        $validator->sometimes('logo', 'image|mimes:bmp,png,jpeg|max:5120|required', function ($input) {
            if ($this->route()->named('create_establishments') && $this->isMethod('post')) {
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
                'title' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9№\-\s\,\:\!\.\"]+$#u'],
                'logo' => 'mimes:bmp,png,jpeg|max:5120|nullable',
                'phones' => ['required', 'max:64', 'regex:#^[\d\-\s\,\(\)\+]+$#'],
                'category' => 'digits_between:1,2|required',
                'services' => 'array|nullable',
                'extra' => 'array|nullable',
                'parent' => 'digits_between:1,5|nullable',
                'address' => 'string|required',
                'site' => 'url|max:255|required',
                'spec' => 'string|nullable',
                'about' => 'required|string',
            ];

            if ($this->request->has('extra') && ($this->request->get('extra') != null)) {
                foreach ($this->request->get('extra') as $key => $val) {
                    $rules['extra.' . $key] = ['array', 'nullable'];
                    foreach ($val as $k => $v) {
                        $rules['extra.' . $key . $k] = ['string', 'nullable', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\-\s\,\:\!\.]+$#u'];
                    }
                }
            }
            if ($this->request->has('services')  && ($this->request->get('extra') != null)) {
                foreach ($this->request->get('services') as $key => $val) {
                    $rules['services.' . $key] = ['string', 'nullable'];
                }
            }
            return $rules;

        } else {
            $rules = [
                'value' => ['nullable', 'string', 'between:1,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9№\-\s\,\:\?\!\.]+$#u'],
                'param' => 'nullable|digits:1',
            ];
            return $rules;
        }

        return [
            //
        ];
    }

    public function messages()
    {
        return [
            'extra.*.*.*' => 'Недопустимые символы в поле Дополнительно',
            'services.*.*' => 'Недопустимые символы в поле Услуги',
        ];
    }
}
