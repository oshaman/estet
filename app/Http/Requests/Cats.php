<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Cats extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  \Auth::user()->canDo('UPDATE_CATS');
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'required|unique:categories,alias|max:255|alpha_dash', function ($input) {
            if ($this->route()->hasParameter('cat') && $this->isMethod('post')) {
                $model = $this->route()->parameter('cat');
                if (null === $model) return true;

                return (($model->alias !== $input->alias)  && !empty($input->alias));
            }

            return !empty($input->alias);
        });

        $validator->sometimes('cat', 'unique:categories,name', function ($input) {
            if ($this->route()->hasParameter('cat') && $this->isMethod('post')) {
                $model = $this->route()->parameter('cat');

                if (null === $model) return true;
                return (($model->name !== $input->cat)  && !empty($input->cat));
            }

            return !empty($input->cat);
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
                'cat' => ['required', 'between:5, 32', 'regex:#^[а-яА-ЯёЁ\s-]+$#u'],
            ];
            return $rules;
        }

        return [
            //
        ];
    }
}
