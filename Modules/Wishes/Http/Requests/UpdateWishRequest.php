<?php

namespace Modules\Wishes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWishRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'                       => 'required|int|min:1',
            'title'                    => 'required|string|min:3|max:255',
            'description'              => 'nullable|string|min:6',
            'airport'                  => 'required|string|min:3',
            'destination'              => 'required|string|min:3',
            'earliest_start'           => 'required|date',
            'latest_return'            => 'required|date',
            'budget'                   => 'required|int|min:0',
            'adults'                   => 'required|int|min:1',
            'kids'                     => 'required|int|min:0',
            'duration'                 => 'required|string|min:1',
            'status'                   => 'required|boolean',
            'created_by'               => 'required|int|min:1',
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
