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
            'name' => 'required|string',
            'subheadline' => 'required|string',
            'subheadline_success' => 'required|string',
            'whitelabel_host_id' => 'required|int',
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
