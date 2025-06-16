<?php

namespace Modules\Setting\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Setting\Helpers\SettingCacheHelper;

class GlobalSettingSetterMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $item = SettingCacheHelper::get();

        config([
            'mail.from' => $item->mail_from,
            'mail.username' => $item->mail_username,
            'mail.password' => $item->mail_password,
            'mail.host' => $item->mail_host,
            'mail.port' => $item->mail_port,
            'mail.encryption' => $item->mail_encryption,
            'mail.protocol' => $item->mail_protocol,
            'services.stripe.key' => $item->stripe_secret_key,
        ]);

        return $next($request);
    }
}
