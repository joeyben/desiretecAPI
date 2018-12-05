<?php

namespace App\Http\Requests\Frontend\Agents;

use App\Http\Requests\Request;

/**
 * Class StoreAgentsRequest.
 */
class StoreAgentsRequest extends Request
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
            'title'           => 'required|max:200',
            'airport'         => 'required|max:200',
            'destination'     => 'required|max:200',
            'earliest_start'  => 'required|max:200',
            'latest_return'   => 'required|max:200',
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
