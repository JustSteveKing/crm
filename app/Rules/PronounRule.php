<?php

declare(strict_types=1);

namespace App\Rules;

use Domains\Contacts\Enums\Pronouns;
use Illuminate\Contracts\Validation\Rule;

class PronounRule implements Rule
{

    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array(
            needle: $value,
            haystack: Pronouns::all(),
        );
    }

    /**
     * @return string
     */
    public function message()
    {
        return 'The pronoun selected is not valid.';
    }
}
