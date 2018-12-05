<?php

namespace App\Http\Requests\Backend\Whitelabels;

use App\Http\Requests\Request;

/**
 * Class EditWhitelabelsRequest.
 */
class EditWhitelabelsRequest extends Request
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
        ];
    }
}
