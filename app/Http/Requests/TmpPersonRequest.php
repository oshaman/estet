<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Input;

class TmpPersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->id;
    }

    /*protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        return $validator;
    }*/

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {
            $rules =  [
                'name' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-Zа-яА-ЯёЁ\-\s]+$#u'],
                'lastname' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-Zа-яА-ЯёЁ\-\s]+$#u'],
                'phone' => ['required', 'between:4,255', 'regex:#^[0-9()\,\-\s\+]+$#'],
                'specialty' => ['required', 'between:4,255', 'regex:#^[a-zA-Zа-яА-ЯёЁ0-9\,\-\s\;]+$#u'],
                'category' => ['between:4,255', 'regex:#^[a-zA-Zа-яА-ЯёЁ0-9\,\-\s\;\.]+$#u', 'nullable'],
                'job' => ['between:4,255', 'regex:#^[a-zA-Zа-яА-ЯёЁ0-9()№\,\-\s\;\\\/\.\"]+$#u', 'nullable'],
                'address' => ['between:4,255', 'regex:#^[a-zA-Zа-яА-ЯёЁ0-9№_\,\-\s\;\\\/\.]+$#u', 'nullable'],
                'shedule' => ['between:4,255', 'regex:#^[a-zA-Zа-яА-ЯёЁ0-9:\,\-\s\;\\\/\.]+$#u', 'nullable'],
//                'services' => ['regex:#^[a-zA-zа-яА-ЯёЁ0-9():№_\,\-\s\;\\\/\.]+$#u', 'nullable'],
                'site' => 'string|max:255|nullable',
                'content' => 'string|nullable',
                'img' => 'mimes:jpg,bmp,png,jpeg|max:5120|nullable',
                'month'=>'regex:#^[0-9]{1,2}$#',
                'year'=>'regex:#^[0-9]{4}$#',

            ];
            foreach($this->request->get('services') as $key => $val)
            {
                $rules['services.'.$key] = ['regex:#^[a-zA-zа-яА-ЯёЁ0-9():№_\,\-\s\;\\\/\.]+$#u', 'nullable'];
            }
            return $rules;
        }
        return [
            //
        ];
    }
}
