<?php

namespace JobMetric\Authio\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JobMetric\Authio\Rules\SecretExistRules;

/**
 * @property mixed secret
 * @property mixed otp
 */
class LoginOtpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'secret' => [
                'required',
                new SecretExistRules
            ],
            'otp' => [
                'required',
                'numeric'
            ],
        ];
    }
}
