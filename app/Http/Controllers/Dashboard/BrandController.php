<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(PAGINATION_COUNT);

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
    {
        try {
            DB::beginTransaction();
            $request = checkRequest($request);
            $imageName = $this->getPhotoName($request);

            $brand = new Brand;
            $brand->is_active = $request->is_active;
            $brand->photo = $imageName;
            $brand->name = $request->name;
            $brand->save();
            DB::commit();

            return successMessage('Stored');
        } catch(\Exception $e) {

            return errorMessage();
        }
    }

    public function edit($id)
    {
        $brand = Brand::find($id);
        if(!$brand) {
            return redirect()->route('get.all.brands')
                ->with(['error' => __('admin/brand.This brand not found')]);
        }

        return view('admin.brands.edit', compact('brand'));
    }

    public function update(BrandRequest $request, $id)
    {
        try {
            $brand = Brand::find($id);
            if($brand) {
                DB::beginTransaction();
                $request = checkRequest($request);
                $this->deletePhoto($brand);
                $imageName = $this->getPhotoName($request);
                $brand->update(['is_active' => $request->is_active,
                    'photo' => $imageName]);
                $brand->name = $request->name;
                $brand->save();
                DB::commit();
            }

            return successMessage('Updated');
        } catch (\Exception $e) {

            return errorMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $brand = Brand::find($id);
            if($brand) {
                $this->deletePhoto($brand);
                $brand->delete();
            }

            return successMessage('Deleted');
        } catch (\Exception $e) {

            return errorMessage();
        }
    }

    public function getPhotoName($request)
    {
        $imageName= "";
        if ($request->has('photo')) {
            $imageName = uploadPhoto($request->photo, 'brands');
        }

        return $imageName;
    }

    public function deletePhoto($brand)
    {
        $photo =str_replace("http://e-commerce.test/",
            "", $brand->photo);
        $imagePath = public_path($photo);
        if(file_exists($imagePath)) {
            unlink($imagePath);
        }
    }
}
