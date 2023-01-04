<?php

namespace App\Rules;

use App\Models\Enums\SubscriberState;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidSubscriberState implements InvokableRule
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
        if (SubscriberState::tryFrom($value) === null) {
            $fail('Invalid subscriber state.');
        }
    }
}
