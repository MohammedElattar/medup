<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function dashboardEcommerce()
    {
        $pageConfigs = ['pageHeader' => false];

        return redirect()->route('experts.index');
        return view('/content/dashboard/dashboards-crm', ['pageConfigs' => $pageConfigs]);
    }
}
