<?php

namespace App\Http\Requests\Backend\Distributions;

use App\Http\Requests\Request;

/**
 * Class EditDistributionsRequest.
 */
class EditDistributionsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('edit-distribution');
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
