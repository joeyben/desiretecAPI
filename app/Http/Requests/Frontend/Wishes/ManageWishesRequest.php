<?php

namespace App\Http\Requests\Frontend\Wishes;

use App\Http\Requests\Request;

/**
 * Class ManageWishesRequest.
 */
class ManageWishesRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('view-wish-frontend');
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
