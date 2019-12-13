<?php

namespace App\Exceptions;

use App\ErrorCodes;
use App\Services\Flag\Src\Flag;
use Illuminate\Support\Facades\Lang;

/**
 * Class AttachmentException.
 */
class WhitelabelException extends BaseException
{
    public static function mismatchException(): self
    {
        return static::create(
            Lang::get('exceptions.whitelabel_mismatch'),
            ErrorCodes::ERROR_MISMATCH_WHITELABEL_USER,
            Flag::STATUS_CODE_ERROR
        );
    }
}
