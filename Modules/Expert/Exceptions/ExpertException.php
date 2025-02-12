<?php

namespace Modules\Expert\Exceptions;

use App\Exceptions\BaseExceptionClass;
use Symfony\Component\HttpFoundation\Response;

class ExpertException extends BaseExceptionClass
{
    public static function duplicateExperience()
    {
        throw new self(translate_word('duplicate_experience'), Response::HTTP_BAD_REQUEST);
    }
}
