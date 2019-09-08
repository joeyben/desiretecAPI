<?php

namespace Modules\Rules\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRuleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ('mix' === $this->request->get('type')) {
            $rule = [
                'id'            => 'required|int',
                'type'          => 'in:manuel,auto,mix',
                'budget'        => 'required|int',
                'whitelabel_id' => 'required|int',
            ];
        } else {
            $rule = [
                'id'            => 'required|int',
                'type'          => 'in:manuel,auto,mix',
                'whitelabel_id' => 'required|int',
            ];
        }

        return $rule;
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
