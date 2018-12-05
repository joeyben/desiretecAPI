<?php

namespace App\Http\Requests\Backend\Whitelabels;

use App\Http\Requests\Request;

/**
 * Class StoreWhitelabelsRequest.
 */
class StoreWhitelabelsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-whitelabel');
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
            'name.required'         => 'Please insert Whitelabel Name',
            'name.max'              => 'Whitelabel Name may not be greater than 200 characters.',
            'display_name.required' => 'Please insert Whitelabel Display Name',
            'display_name.max'      => 'Whitelabel Display Name may not be greater than 200 characters.',
        ];
    }
}
