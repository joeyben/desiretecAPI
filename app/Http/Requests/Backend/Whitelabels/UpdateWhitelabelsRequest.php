<?php

namespace App\Http\Requests\Backend\Whitelabels;

use App\Http\Requests\Request;

/**
 * Class UpdateWhitelabelsRequest.
 */
class UpdateWhitelabelsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('edit-whitelabel');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required|max:191',
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
            'name.required' => 'Please insert Whitelabel Name',
            'name.max'      => 'Whitelabel Title may not be greater than 191 characters.',
        ];
    }
}
