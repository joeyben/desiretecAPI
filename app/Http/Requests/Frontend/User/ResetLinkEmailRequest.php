<?php

namespace App\Http\Requests\Frontend\User;

use App\Http\Requests\Request;

/**
 * Class ChangePasswordRequest.
 */
class ResetLinkEmailRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|max:255|exists:users,email',
            'host'  => 'required|string'
        ];
    }
}
