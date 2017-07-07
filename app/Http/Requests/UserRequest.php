<?php

namespace Fresh\Estet\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->canDo('ADMIN_USERS');
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->sometimes('password', 'required|min:6|confirmed', function($input)
        {

            if(!empty($input->password) || ((empty($input->password) && $this->route()->getName() !== 'user_update'))) {
                return TRUE;
            }

            return FALSE;
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
        /*$id = (isset($this->route()->parameter('user_id')->id)) ? $this->route()->parameter('user_id')->id . ',id' : '';
        if ($this->isMethod('post')) {
            return [
                'role_id' => 'required|array',
                'email' => 'required|email|max:255|unique:users,email,'.$id
            ];
        }*/
        return [];
    }
}
