<?php

namespace App\Helpers;

class ToastHelper
{
  public static function successToast(string $message = null, string $key = 'toast')
  {
      $message = is_null($message) ? translate_ui('operation_done') : $message;
      session()->flash($key, $message);
  }
}
