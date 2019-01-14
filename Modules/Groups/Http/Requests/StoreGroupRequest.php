<?php

namespace Modules\Groups\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                               => 'required|string|min:3|max:255',
            'display_name'                       => 'required|string|min:3|max:255',
            'description'                        => 'nullable|string|min:6',
            'users'                              => 'required|array|min:1',
            'status'                             => 'required|boolean'
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
