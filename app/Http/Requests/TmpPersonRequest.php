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
            return [
                'name' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ\-\s]+$#u'],
                'lastname' => ['required', 'string', 'between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ\-\s]+$#u'],
                'phone' => ['required', 'between:4,255', 'regex:#^[0-9()\,\-\s\+]+$#'],
                'specialty' => ['required', 'between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\,\-\s\;]+$#u'],
                'category' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\,\-\s\;\.]+$#u', 'nullable'],
                'job' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9()№\,\-\s\;\\\/\.]+$#u', 'nullable'],
                'address' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9№_\,\-\s\;\\\/\.]+$#u', 'nullable'],
                'expirience' => ['max:255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9\,\-\s\;]+$#u', 'nullable'],
                'shedule' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9:\,\-\s\;\\\/\.]+$#u', 'nullable'],
                'services' => ['between:4,255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9():№_\,\-\s\;\\\/\.]+$#u', 'nullable'],
                'site' => 'string|max:255|nullable',
                'content' => 'string|nullable',
                'img' => 'mimes:jpg,bmp,png,jpeg,gif,svg|max:5120|nullable',

            ];
        }
        return [
            //
        ];
    }
}
