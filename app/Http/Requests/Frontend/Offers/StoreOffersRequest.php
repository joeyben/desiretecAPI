<?php

namespace App\Http\Requests\Frontend\Offers;

use App\Http\Requests\Request;

/**
 * Class StoreOffersRequest.
 */
class StoreOffersRequest extends Request
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
            'title'           => 'required|max:191',
            'description'     => 'required',
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
            'title.required'       => 'Please insert Offer Title',
            'title.max'            => 'Offer Title may not be greater than 200 characters.',
            'description.required' => 'Please insert Offer Description',
        ];
    }
}
