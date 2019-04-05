<?php

namespace Modules\LanguageLines\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageLineRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                                 => 'required|int|min:1',
            'locale'                             => 'required|string|min:2|max:2',
            'description'                        => 'string|min:3|max:255',
            'group'                              => 'required|string|min:3|max:255',
            'key'                                => 'required|string|min:3|max:255',
            'text'                               => 'required|string|min:3|max:255',
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