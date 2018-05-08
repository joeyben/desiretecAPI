<?php

namespace App\Http\Requests\Backend\Wishes;

use App\Http\Requests\Request;

/**
 * Class EditWishesRequest.
 */
class EditWishesRequest extends Request
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
            //
        ];
    }
}
