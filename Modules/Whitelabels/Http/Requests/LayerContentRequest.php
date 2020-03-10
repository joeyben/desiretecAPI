<?php

namespace Modules\Whitelabels\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LayerContentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                  => 'required|int|min:1',
            'whitelabel_id'       => 'required|int|min:1',
            'headline'            => 'required|string|min:2|max:50',
            'subheadline'         => 'required|string|min:2|max:125',
            'headline_success'    => 'required|string|min:2|max:255',
            'subheadline_success' => 'required|string|min:2|max:255',
            'privacy'             => 'required|string|min:2|max:255',
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
