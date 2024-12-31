<?php

namespace JobMetric\Authio\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'type' => 'string|in:mobile,email',

            'mobile_prefix' => 'required_if:type,==,mobile',
            'mobile' => 'required_if:type,==,mobile',

            'email' => 'required_if:type,==,email',
        ];
    }
}
