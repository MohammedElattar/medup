<?php

namespace Modules\Expert\Helpers;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExpertHelper
{
    public static function getUserExpert($user = null)
    {
        $user = $user ?: auth()->user();
        $expert = $user->expert;

        if(! $expert) {
            throw new NotFoundHttpException('Expert not found');
        }

        return $expert;
    }
}
