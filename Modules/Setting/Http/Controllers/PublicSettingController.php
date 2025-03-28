<?php

namespace Modules\Setting\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Routing\Controller;
use Modules\Setting\Helpers\SettingCacheHelper;

class PublicSettingController extends Controller
{
    use HttpResponse;

    public function show()
    {
        $price = SettingCacheHelper::getSubscriptionPrice();

        return $this->resourceResponse([
            'subscription_price' => $price,
        ]);
    }
}
