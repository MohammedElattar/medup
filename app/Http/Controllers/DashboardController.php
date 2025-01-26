<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function dashboardEcommerce()
    {
      $pageConfigs = ['pageHeader' => false];

      return view('/content/dashboard/dashboards-crm', ['pageConfigs' => $pageConfigs]);
    }
}
