<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Setting\Helpers\SettingCacheHelper;
use Modules\Setting\Http\Requests\SettingRequest;

class AdminSettingController extends Controller
{
    public function show()
    {
        $item = SettingCacheHelper::get();

        return view('setting::edit', compact('item'));
    }

    public function update(SettingRequest $request)
    {
        $item = SettingCacheHelper::get();
        $item->update($request->validated());

        SettingCacheHelper::set($item);
        return redirect()->route('settings.show');
    }
}
