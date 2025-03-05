<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Expert\Models\Expert;

class DashboardController extends Controller
{
    public function dashboardEcommerce()
    {
        return Expert::query()->get();
        $pageConfigs = ['pageHeader' => false];

        return view('/content/dashboard/dashboards-crm', ['pageConfigs' => $pageConfigs]);
    }
}
