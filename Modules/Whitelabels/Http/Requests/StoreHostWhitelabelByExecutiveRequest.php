<?php

namespace Modules\Whitelabels\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHostWhitelabelByExecutiveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'host' => 'required|url|unique:whitelabel_hosts,host',
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
