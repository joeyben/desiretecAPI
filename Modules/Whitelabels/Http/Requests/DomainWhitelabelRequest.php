<?php

namespace Modules\Whitelabels\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DomainWhitelabelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'        => 'required|int|min:1',
            'domain'    => 'required|string|min:2|max:255|unique:whitelabels,domain',
            'email'     => 'required|string|email|max:255',
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
