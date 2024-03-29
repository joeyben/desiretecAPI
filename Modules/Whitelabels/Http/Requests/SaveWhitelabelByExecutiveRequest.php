<?php

namespace Modules\Whitelabels\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveWhitelabelByExecutiveRequest extends FormRequest
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
            'display_name'       => 'required|string|min:2|max:255',
            'email'              => 'required|email|min:2|max:255',
            'color'              => 'required|string|min:4|max:10',
            'sub_domain'         => 'required|regex:/^([a-zA-Z\-]+)(\s[a-zA-Z]+)*$/',
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
