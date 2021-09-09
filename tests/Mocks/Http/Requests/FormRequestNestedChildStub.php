<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 9/9/21 10:15 AM.
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Tests\Mocks\Http\Requests;

use Lalcebo\Lumen\Http\FormRequest;

class FormRequestNestedChildStub extends FormRequest
{
    public function rules(): array
    {
        return ['nested.foo' => 'required'];
    }

    public function authorize(): bool
    {
        return true;
    }
}
