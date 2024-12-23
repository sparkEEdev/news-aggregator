<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SearchQueryRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // only letters, numbers, spaces and dots
        if (!preg_match('/^[a-zA-Z0-9\s.]+$/', $value)) {
            $fail("The $attribute field must contain only letters, numbers and spaces.");
        }
    }
}
