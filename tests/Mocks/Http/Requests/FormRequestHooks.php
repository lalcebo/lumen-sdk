<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 9/9/21 10:18 AM.
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Tests\Mocks\Http\Requests;

use Lalcebo\Lumen\Http\FormRequest;

class FormRequestHooks extends FormRequest
{
    public function rules(): array
    {
        return ['name' => 'required'];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->replace(['name' => 'Taylor']);
    }

    public function passedValidation(): void
    {
        $this->replace(['name' => 'Adam']);
    }
}
