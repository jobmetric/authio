<?php

namespace JobMetric\Authio\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use JobMetric\Authio\Enums\LoginTypeEnum;
use JobMetric\Authio\Rules\MobileRule;

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
        $user_table = config('authio.tables.user');
        return [
            'type' => [
                'required',
                'string',
                'in:' . implode(',', LoginTypeEnum::values())
            ],

            'mobile_prefix' => [
                'nullable',
                'required_if:type,==,' . LoginTypeEnum::MOBILE(),
                'string',
                'max:20'
            ],
            'mobile' => [
                'nullable',
                'required_if:type,==,' . LoginTypeEnum::MOBILE(),
                'string',
                'max:20',
                new MobileRule('mobile_prefix')
            ],

            'email' => [
                'nullable',
                'required_if:type,==,' . LoginTypeEnum::EMAIL(), 'email',
                'max:255',
                'unique:' . $user_table . ',email'
            ],

            'hash' => [
                'nullable',
                'string',
                'max:255'
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $type = $this->input('type');

        if ($type == LoginTypeEnum::MOBILE()) {
            $this->merge([
                'email' => null
            ]);
        } elseif ($type == LoginTypeEnum::EMAIL()) {
            $this->merge([
                'mobile_prefix' => null,
                'mobile' => null
            ]);
        }
    }
}
