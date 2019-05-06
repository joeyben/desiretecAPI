<?php

namespace Modules\Novasol\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

/**
 * Class StoreWishesRequest.
 */
class StoreWishRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Determine if the form has failed validation.
     *
     * @return bool
     */
    public function failed()
    {
        return $this->getValidatorInstance()->fails();
    }

    /**
     * Determine if the form has failed validation.
     *
     * @return object
     */
    public function errors()
    {
        return $this->getValidatorInstance()->errors();
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return JsonResponse
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        return response()->json(['errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'destination'     => 'required',
            'earliest_start'  => 'required',
            'latest_return'   => 'required',
            'adults'          => 'required',
            'email'           => 'required|email',
            'terms'           => 'required',
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
            'email.required'            => trans('layer.email.required'),
            'email.email'               => trans('layer.email.email'),
            'adults.required'           => trans('layer.adults.required'),
            'destination.required'      => trans('layer.destination.required'),
            'terms.required'            => trans('layer.terms.required'),
            'earliest_start'            => trans('layer.earliest_start.required'),
            'latest_return'             => trans('layer.latest_return.required'),
        ];
    }
}
