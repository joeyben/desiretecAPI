<?php

namespace Modules\Variants\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVariantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'privacy' => 'required|string',
            'active' => 'required|boolean',
            'color' => 'required|string',
            'headline' => 'required|string',
            'headline_success' => 'required|string',
            'layer_url' => 'required|url',
            'subheadline' => 'required|string',
            'subheadline_success' => 'required|string',
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
