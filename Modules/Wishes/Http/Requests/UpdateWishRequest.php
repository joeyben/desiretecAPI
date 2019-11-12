<?php

namespace Modules\Wishes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWishRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                       => 'required|int|min:1',
            'status'                   => 'required|boolean',
            'alert_email'              => 'required|boolean'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
