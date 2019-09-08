<?php

namespace Modules\Rules\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRuleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->request->get('type') === 'mix') {
            $rule = [
                'type' => 'in:manuel,auto,mix',
                'budget' => 'required|int',
                'whitelabel_id' => 'required|int',
            ];
        } else {
            $rule = [
                'type' => 'in:manuel,auto,mix',
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
