<?php

namespace Modules\Variants\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVariantRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|int|min:1',
            'name' => 'required|string',
            'privacy' => 'required|string',
            'active' => 'required|boolean',
            'color' => 'required|string',
            'headline' => 'required|string',
            'headline_success' => 'required|string',
            'subheadline' => 'required|string',
            'whitelabel_host_id' => 'required|int',
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
