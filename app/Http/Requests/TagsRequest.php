<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  \Auth::user()->canDo('UPDATE_TAGS');
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'required|unique:tags,alias|max:255|alpha_dash', function ($input) {
            if ($this->route()->hasParameter('tag') && $this->isMethod('post')) {
                $model = $this->route()->parameter('tag');
                if (null === $model) return true;

                return (($model->alias !== $input->alias)  && !empty($input->alias));
            }

            return !empty($input->alias);
        });

        $validator->sometimes('tag', 'unique:tags,name', function ($input) {
            if ($this->route()->hasParameter('tag') && $this->isMethod('post')) {
                $model = $this->route()->parameter('tag');
                if (null === $model) return true;
                return (($model->name !== $input->tag)  && !empty($input->tag));
            }

            return !empty($input->tag);
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
                'tag' => ['required', 'between:5, 32', 'regex:#^[а-яА-ЯёЁ\s-]+$#u'],
            ];
            return $rules;
        }

        return [
            //
        ];
    }
}
