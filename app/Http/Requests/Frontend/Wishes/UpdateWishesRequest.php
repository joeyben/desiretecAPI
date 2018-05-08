<?php

namespace App\Http\Requests\Frontend\Wishes;

use App\Http\Requests\Request;

/**
 * Class UpdateWishesRequest.
 */
class UpdateWishesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('edit-wish');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'       => 'required|max:200',
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
            'name.required' => 'Please insert Wish Title',
            'name.max'      => 'Wish Title may not be greater than 200 characters.',
        ];
    }
}
