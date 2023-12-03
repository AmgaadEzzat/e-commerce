<?php

namespace App\Http\Controllers\DashBoard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function editShippingMethod($type)
    {
        if($type == 'free') {
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
        }

        elseif($type == 'Internal') {
            $shippingMethod = Setting::where('key', 'local_label')->first();
        }

        elseif($type == 'External') {
            $shippingMethod = Setting::where('key', 'outer_label')->first();
        }

        return view('admin.setting.editShippingMethod', compact('shippingMethod'));
    }

    public function updateShippingMethod()
    {

    }
}
