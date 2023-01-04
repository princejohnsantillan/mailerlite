<?php

namespace App\Rules;

use App\Models\Enums\FieldType;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidFieldType implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (FieldType::tryFrom($value) === null) {
            $fail('Invalid field type.');
        }
    }
}
