<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 9/9/21 10:16 AM.
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Tests\Mocks\Http\Requests;

use Illuminate\Validation\Validator;
use Lalcebo\Lumen\Http\FormRequest;

class FormRequestTwiceStub extends FormRequest
{
    public static $count = 0;

    public function rules(): array
    {
        return ['name' => 'required'];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function () {
            self::$count++;
        });
    }

    public function authorize(): bool
    {
        return true;
    }
}
