<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

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
        }else {
            $shippingMethod = Setting::where('key', 'free_shipping_label')->first();
        }

        return view('admin.setting.editShippingMethod', compact('shippingMethod'));
    }

    public function updateShippingMethod(ShippingRequest $request, $id)
    {
        $shippingMethod = Setting::find($id);
        try {
            DB::beginTransaction();
            $shippingMethod->update(['plain_value' => $request->plain_value]);
            $shippingMethod->value = $request->value;
            $shippingMethod->save();
            DB::commit();
            return redirect()->back()->with(['success' => 'Updated successfully']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Something went wrong']);
        }
    }
}
