<?php

namespace App\Http\Requests\Backend\Groups;

use App\Http\Requests\Request;

/**
 * Class UpdateGroupsRequest.
 */
class UpdateGroupsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('edit-group');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                => 'required|max:191',
            'whitelabel_id'       => 'required',
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
            'name.required'          => 'Please insert Group Name',
            'name.max'               => 'Group Name may not be greater than 191 characters.',
            'whitelabel_id.required' => 'Please add an associated Whitelabel',
        ];
    }
}
