<?php

namespace Modules\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSellerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'       => 'required|string',
            'email'            => 'required|email|unique:users,email',
            'groups'           => 'nullable|array',
            'status'           => 'required|boolean',
            'confirmed'        => 'required|boolean',
            'password_confirm' => 'required|min:6|required_with:password',
            'password'         => 'required|sometimes|required_with:password_confirm|same:password_confirm|min:6',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
