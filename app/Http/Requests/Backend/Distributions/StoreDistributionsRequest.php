<?php

namespace App\Http\Requests\Backend\Distributions;

use App\Http\Requests\Request;

/**
 * Class StoreDistributionsRequest.
 */
class StoreDistributionsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-distribution');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                 => 'required|max:191',
            'display_name'         => 'required|max:191',
            'description'          => 'required',
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
            'name.required'         => 'Please insert Distribution Name',
            'name.max'              => 'Distribution Name may not be greater than 191 characters.',
            'display_name.required' => 'Please insert Distribution Display Name',
            'display_name.max'      => 'Distribution Display Name may not be greater than 191 characters.',
            'description.required'  => 'Please insert Distribution Description',
        ];
    }
}
