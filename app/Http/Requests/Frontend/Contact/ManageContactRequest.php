<?php

namespace App\Http\Requests\Frontend\Contact;

use App\Http\Requests\Request;

/**
 * Class ManageContactRequest.
 */
class ManageContactRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('view-contact-frontend');
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
