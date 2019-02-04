<?php

namespace Modules\Whitelabels\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveWhitelabelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                 => 'required|int|min:1',
            'name'               => 'required|string|min:2|max:255',
            'display_name'       => 'required|string|min:2|max:255',
            'domain'             => 'required|string|min:2|max:255',
            'distribution_id'    => 'required|int|min:1',
            'status'             => 'required|boolean',
            'background'         => 'required|array|min:1',
            'logo'               => 'required|array|min:1',
            'favicon'            => 'required|array|min:1',
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
