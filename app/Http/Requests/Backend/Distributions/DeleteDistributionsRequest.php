<?php

namespace App\Http\Requests\Backend\Distributions;

use App\Http\Requests\Request;

/**
 * Class DeleteDistributionsRequest.
 */
class DeleteDistributionsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('delete-distribution');
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
