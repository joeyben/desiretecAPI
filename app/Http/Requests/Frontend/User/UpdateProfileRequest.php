<?php

namespace App\Http\Requests\Frontend\User;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends Request
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
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users')],
            'address'   => 'required|max:255',
            'country'   => 'required|max:255',
            'city'    => 'required|max:255',
            'zip_code'   => 'required|max:255',
        ];
    }
}
