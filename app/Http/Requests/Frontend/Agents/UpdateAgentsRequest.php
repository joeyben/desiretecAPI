<?php

namespace App\Http\Requests\Frontend\Agents;

use App\Http\Requests\Request;

/**
 * Class UpdateAgentsRequest.
 */
class UpdateAgentsRequest extends Request
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
            'name'      => 'required|string|max:64',
            'email'     => 'required|email|max:255',
            'telephone' => 'required|regex:#^[0\+]{1}[0-9-]{6,20}#'
        ];
    }

    /**
     * Get the validation message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Please insert Agent Title',
            'name.max'      => 'Agent Title may not be greater than 200 characters.',
        ];
    }
}
