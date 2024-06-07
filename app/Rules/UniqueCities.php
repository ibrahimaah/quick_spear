<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueCities implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $cities = array_column($value, 'city');
        return count($cities) === count(array_unique($cities));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'يجب أن يكون لكل مندوب مدينة فريدة';
    }
}
