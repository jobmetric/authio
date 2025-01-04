<?php

namespace JobMetric\Authio\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use JobMetric\Authio\Models\UserOtp;

class SecretExistRules implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure(string): PotentiallyTranslatedString $fail
     *
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        global $user_otp;

        $user_otp = UserOtp::ofSecretNotUsed($value)->with('user')->first();
        if ($user_otp instanceof UserOtp) {
            return;
        }

        $fail(trans('authio::base.rules.secret_exist', ['attribute' => $attribute]));
    }
}
