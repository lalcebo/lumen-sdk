<?php

/**
 * Created by Jorge P. Hernandez Lalcebo
 * Mail: lalcebo2003@gmail.com
 * Date: 8/7/21 11:53 PM
 */

declare(strict_types=1);

namespace Lalcebo\Lumen\Contracts\Support;

use Spatie\DataTransferObject\DataTransferObject;

interface Transferable
{
    /**
     * Get the instance as an DataTransferObject.
     *
     * @return DataTransferObject
     */
    public function toDto(): DataTransferObject;
}
