<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        /*$validator->sometimes('alias','unique:articles|max:246|alpha_dash', function ($input) {

            if ($this->route()->hasParameter('id')) {
                $model = $this->route()->parameter('id');
                if (null === $model) return true;
                return ($model->alias !== $input->alias)  && !empty($input->alias);
            }

            return !empty($input->alias);

        });*/

        /*$validator->sometimes('outputtime','date', function($input) {

            return !empty($input->outputtime);

        });

        $validator->sometimes('phone',array('required', 'between:4,255', 'regex:#^[0-9()\,\-\s]+$#'), function() {

            return true;

        });
        */
        $validator->sometimes('category',array('string', 'max:255', 'regex:#^[a-zA-zа-яА-ЯёЁ0-9_\,\-\s\;]+$#u'), function($input) {

            return !empty($input->category);

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
            return [
                'name' => 'required|string|alpha_dash|between:4,255',
                'lastname' => 'required|string|alpha_dash|between:4,255',
                'phone' => 'required|between:4,255|string',
                'specialty' => 'required|max:60|string|alpha_dash|between:4,255',
                'img' => 'image|max:5120|nullable',
            ];
        }
        return [
            //
        ];
    }
}
