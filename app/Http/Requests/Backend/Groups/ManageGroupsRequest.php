<?php

namespace App\Http\Requests\Backend\Groups;

use App\Http\Requests\Request;

/**
 * Class ManageGroupsRequest.
 */
class ManageGroupsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('view-group');
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
