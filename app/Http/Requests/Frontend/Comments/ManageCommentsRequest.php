<?php

namespace App\Http\Requests\Frontend\Comments;

use App\Http\Requests\Request;

/**
 * Class ManageCommentsRequest.
 */
class ManageCommentsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->allow('view-comment-frontend');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
