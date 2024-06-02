<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    public function passes($attribute, $value)
    {
        return preg_match('/[!@#$%^&*(),.?":{}|<>]/', $value);
    }

    public function message()
    {
        return 'The :attribute must contain at least one special character.';
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', new StrongPassword],
        ]);
    }
}
