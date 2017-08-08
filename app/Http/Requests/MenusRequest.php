<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('UPDATE_MENUS');
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
                'cats' => 'array',
                'docs_cats' => 'array',
            ];

            if ($this->request->has('cats')) {
                foreach($this->request->get('cats') as $key => $val)
                {
                    $rules['cats.'.$key] = ['numeric', 'nullable'];
                }

            }

            if ($this->request->has('docs_cats')) {
                foreach($this->request->get('docs_cats') as $key => $val)
                {
                    $rules['docs_cats.'.$key] = ['numeric', 'nullable'];
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
            'cats.*.*' => 'Недопустимые символы в поле Категории пациентов',
            'docs_cats.*.*' => 'Недопустимые символы в поле Категории врачей',
        ];
    }
}
