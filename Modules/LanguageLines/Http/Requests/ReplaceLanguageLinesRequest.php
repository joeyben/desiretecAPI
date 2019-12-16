<?php

namespace Modules\LanguageLines\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplaceLanguageLinesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'whitelabels' => 'required|array|min:1',
            'checked'     => 'required|array|min:1'
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
