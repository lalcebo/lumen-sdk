<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 9/12/21 9:05 PM.
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Tests\Mocks\Http\Requests;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Validation\Validator;
use Lalcebo\Lumen\Http\FormRequest;

class FormRequestValidatorStub extends FormRequest
{
    public function validator(Factory $factory): Validator
    {
        return $factory->make($this->all(), ['name' => 'required'], [], []);
    }

    public function authorize(): bool
    {
        return true;
    }
}
