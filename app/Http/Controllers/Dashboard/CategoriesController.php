<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{

    public function index()
    {
        $categories = Category::mainCategories()->paginate(PAGINATION_COUNT);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        try {
            DB::beginTransaction();
            $request = checkRequest($request);
            $category = new Category;
            $category->slug = $request->slug;
            $category->is_active = $request->is_active;
            $category->name = $request->name;
            $category->save();
            DB::commit();

            return successMessage('Stored');
        } catch(\Exception $e) {

            return errorMessage();
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if(!$category) {
            return redirect()->route('get.all.categories')
                ->with(['error' => __('admin/category.This category not found')]);
        }

        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);
            if($category) {
                $request = checkRequest($request);
                $category->update(['slug' => $request->slug]);
                $category->name = $request->name;

                $category->save();
            }

            return successMessage('Updated');
        } catch (\Exception $e) {

            return errorMessage();
        }
    }

    public function delete($id)
    {
        try {
            $category = Category::find($id);
            if($category) {
                $category->delete();
            }

            return successMessage('Deleted');
        } catch (\Exception $e) {

            return errorMessage();
        }
    }
}
