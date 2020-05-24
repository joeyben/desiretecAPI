<?php

namespace App\Http\Requests\Frontend\Agents;

use App\Http\Requests\Request;

/**
 * Class CreateAgentsRequest.
 */
class CreateAgentsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-agent');
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
            'telephone' => 'required'
        ];
    }
}
