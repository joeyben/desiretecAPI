<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                        => 'required|int',
            'first_name'                => 'required|string',
            'last_name'                 => 'nullable|string',
            'email'                     => 'required|email|unique:users,email',
            'password_confirm'          => 'required|min:6|required_with:password',
            'password'                  => 'required|sometimes|required_with:password_confirm|same:password_confirm|min:6',
            'status'                    => 'required|boolean',
            'confirmed'                 => 'required|boolean',
            'confirmation_email'        => 'required|boolean',
            'whitelabels'               => 'nullable|array',
            'roles'                     => 'required|array|min:1',
            'dashboards'                => 'nullable|array',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-user');
    }
}
