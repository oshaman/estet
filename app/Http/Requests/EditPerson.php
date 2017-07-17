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
                    'specialty'=> 'required',
                    /*
                    'category' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\,\-\s\;\.]+$#u', 'nullable'],
                    'job' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9()№\,\-\s\;\\\/\.\"]+$#u', 'nullable'],
                    'address' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9№_\,\-\s\;\\\/\.]+$#u', 'nullable'],
                    'site' => 'url|max:255|nullable',
                    'img' => 'mimes:jpg,bmp,png,jpeg|max:5120|nullable',
                    'month'=>'regex:#^[0-9]{1,2}$#',
                    'year'=>'regex:#^[0-9]{4}$#',
                    'shedule' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9:\,\-\s\;\\\/\.]+$#u', 'nullable'],
                    'content' => 'string|nullable',
                    'services' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9():№_\,\-\s\;\\\/\.]+$#u', 'nullable'],*/
                ];

//                foreach($this->request->get('specialty') as $key => $val)
//                {
//                    $rules['specialty.'.$key] = ['digits:2', 'nullable'];
//                }

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
}
