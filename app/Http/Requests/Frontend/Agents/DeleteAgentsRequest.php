<?php

namespace App\Http\Requests\Frontend\Agents;

use App\Http\Requests\Request;

/**
 * Class DeleteAgentsRequest.
 */
class DeleteAgentsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('delete-agent');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }
}
