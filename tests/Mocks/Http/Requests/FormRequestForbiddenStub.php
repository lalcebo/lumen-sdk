<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 9/9/21 10:17 AM.
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Tests\Mocks\Http\Requests;

use Lalcebo\Lumen\Http\FormRequest;

class FormRequestForbiddenStub extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }
}
