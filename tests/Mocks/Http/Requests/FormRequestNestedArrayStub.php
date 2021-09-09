<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 9/9/21 10:16 AM.
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Tests\Mocks\Http\Requests;

use Lalcebo\Lumen\Http\FormRequest;

class FormRequestNestedArrayStub extends FormRequest
{
    public function rules(): array
    {
        return ['nested.*.bar' => 'required'];
    }

    public function authorize(): bool
    {
        return true;
    }
}
