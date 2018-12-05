<?php

namespace App\Http\Requests\Frontend\Comments;

use App\Http\Requests\Request;

/**
 * Class StoreCommentsRequest.
 */
class StoreCommentsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('create-comment');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment'         => 'required',
            'data_id'         => 'required',
            'type'            => 'required',
        ];
    }

    /**
     * Get the validation message that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'comment.required' => 'Please insert Comment Title',
        ];
    }
}
