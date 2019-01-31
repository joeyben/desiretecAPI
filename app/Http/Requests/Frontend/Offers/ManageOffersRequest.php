<?php

namespace App\Http\Requests\Frontend\Offers;

use App\Http\Requests\Request;

/**
 * Class ManageOffersRequest.
 */
class ManageOffersRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-offer');
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
