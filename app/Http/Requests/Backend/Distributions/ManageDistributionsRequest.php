<?php

namespace App\Http\Requests\Backend\Distributions;

use App\Http\Requests\Request;

/**
 * Class ManageDistributionsRequest.
 */
class ManageDistributionsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('view-distribution');
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
