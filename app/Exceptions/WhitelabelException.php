<?php

namespace App\Exceptions;

use App\ErrorCodes;
use App\Services\Flag\Src\Flag;

/**
 * Class AttachmentException.
 */
class WhitelabelException extends BaseException
{
    public static function mismatchException(): self
    {
        return static::create(
            'Mismatch Whitelabel User',
            ErrorCodes::ERROR_MISMATCH_WHITELABEL_USER,
            Flag::STATUS_CODE_ERROR
        );
    }
}
