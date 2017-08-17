<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  \Auth::user()->canDo('UPDATE_EVENTS');
    }

    /**
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('alias', 'required|unique:organizers,alias|max:255|alpha_dash', function ($input) {
            if ($this->route()->hasParameter('organizer') && $this->isMethod('post')) {
                $model = $this->route()->parameter('organizer');
                if (null === $model) return true;

                return (($model->alias !== $input->alias)  && !empty($input->alias));
            }

            return !empty($input->alias);
        });

        $validator->sometimes('organizer', 'unique:organizers,name', function ($input) {
            if ($this->route()->hasParameter('organizer') && $this->isMethod('post')) {
                $model = $this->route()->parameter('organizer');

                if (null === $model) return true;
                return (($model->name !== $input->organizers)  && !empty($input->organizers));
            }

            return !empty($input->organizers);
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
                'organizer' => ['required', 'between:5, 255', 'string'],
                'parent' => ['nullable', 'numeric', 'max:4294967295'],
            ];
            return $rules;
        }

        return [
            //
        ];
    }
}
