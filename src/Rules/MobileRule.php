<?php

namespace JobMetric\Authio\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use JobMetric\Location\Models\LocationCountry;

class MobileRule implements ValidationRule
{
    protected string $prefixField;

    /**
     * Constructor.
     *
     * @param string $prefixField
     */
    public function __construct(string $prefixField = 'mobile_prefix')
    {
        $this->prefixField = $prefixField;
    }

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
        // Get the mobile prefix field dynamically
        $mobilePrefix = trim(request()->input($this->prefixField), '+');

        if (!$mobilePrefix) {
            $fail(trans('authio::base.rules.mobile.mobile_prefix_missing', ['field' => $this->prefixField]));

            return;
        }

        // Query the database to get the country and its validation regex
        $country = LocationCountry::query()
            ->where('mobile_prefix', $mobilePrefix)
            ->first();

        if (!$country) {
            $fail(trans('authio::base.rules.mobile.mobile_prefix_not_found', ['prefix' => $mobilePrefix]));

            return;
        }

        // Check if the validation regex is empty
        if (empty($country->validation)) {
            $fail(trans('authio::base.rules.mobile.validation_regex_missing', ['country' => $country->name]));

            return;
        }

        // Iterate over all regex rules and check if any match
        foreach ($country->validation as $regex) {
            if (preg_match($regex, $value)) {
                return; // Exit the loop if a match is found
            }
        }

        // Check if the full mobile number matches the regex
        $fail(trans('authio::base.rules.mobile.invalid_mobile_format', [
            'prefix' => $mobilePrefix,
            'country' => $country->name,
        ]));
    }
}
