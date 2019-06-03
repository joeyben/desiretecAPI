<?php

namespace Modules\LanguageLines\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CloneLanguageLinesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from' => 'required|string|min:2|max:2|exists:languages,locale',
            'to'   => 'required|string|min:2|max:2|exists:languages,locale',
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
