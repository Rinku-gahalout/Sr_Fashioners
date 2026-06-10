<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function AddCategory(){
        return view('wl-admin.category.addcategory');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/categories'), $imageName);
        }

        Category::create([
            'name'        => $request->name,
            'slug'        => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'image'       => $imageName,
            'status'      => $request->status,
            'sort_order'  => 0,
        ]);

        return redirect()
                ->route('list.category')
                ->with('success', 'Category created successfully.');
    }

    public function listCategory(){
        $categories = Category::latest()->paginate(10);
        return view('wl-admin.category.list', compact('categories'));
    }

    public function editCategory($categoryid)
    {
        $category = Category::findOrFail($categoryid);
        return view('wl-admin.category.edit', compact('category'));
    }

    public function updateCategory(Request $request, $categoryid)
    {
        $category = Category::findOrFail($categoryid);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        $imageName = $category->image;

        if ($request->hasFile('image')) {

            if (
                $category->image &&
                file_exists(public_path('uploads/categories/' . $category->image))
            ) {
                unlink(public_path('uploads/categories/' . $category->image));
            }

            // Upload new image
            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('uploads/categories'), $imageName);
        }

        $category->update([
            'name'        => $request->name,
            'slug'        => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'image'       => $imageName,
            'status'      => $request->status,
        ]);

        return redirect()
                ->route('list.category')
                ->with('success', 'Category updated successfully.');
    }

    public function deleteCategory($categoryid)
    {
        $category = Category::findOrFail($categoryid);

        // Delete image if exists
        if (
            $category->image &&
            file_exists(public_path('uploads/categories/' . $category->image))
        ) {
            unlink(public_path('uploads/categories/' . $category->image));
        }

        $category->delete();

        return redirect()
                ->route('list.category')
                ->with('success', 'Category deleted successfully.');
    }


    public function addsubcategory()
    {
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('wl-admin.subcategory.addsubcategory',compact('categories')
        );
    }

    public function storesubcategory(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:sub_categories,slug',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|boolean',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/subcategories'),
                $imageName
            );
        }

        SubCategory::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'image'       => $imageName,
            'status'      => $request->status,
            'sort_order'  => 0,
        ]);

        return redirect()
                ->route('list.subcategory')
                ->with('success', 'Sub Category created successfully.');
    }

    public function listsubcategory()
    {
        $subcategories = SubCategory::with('category')
                            ->latest()
                            ->paginate(10);

        return view(
            'wl-admin.subcategory.list',
            compact('subcategories')
        );
    }


    public function editsubcategory($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = Category::where('status', 1)
                        ->orderBy('name', 'ASC')
                        ->get();

        return view(
            'wl-admin.subcategory.editsubcategory',
            compact('subcategory', 'categories')
        );
    }

    public function updatesubcategory(Request $request, $id)
    {
        $subcategory = SubCategory::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:sub_categories,slug,' . $subcategory->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'required|boolean',
        ]);

        $imageName = $subcategory->image;

        if ($request->hasFile('image')) {

            // Delete old image
            if (
                $subcategory->image &&
                file_exists(public_path('uploads/subcategories/' . $subcategory->image))
            ) {
                unlink(public_path('uploads/subcategories/' . $subcategory->image));
            }

            // Upload new image
            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/subcategories'),
                $imageName
            );
        }

        $subcategory->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'slug'        => $request->slug ?: Str::slug($request->name),
            'description' => $request->description,
            'image'       => $imageName,
            'status'      => $request->status,
        ]);

        return redirect()
                ->route('list.subcategory')
                ->with('success', 'Sub Category updated successfully.');
    }

    public function deletesubcategory($id)
    {
        $subcategory = SubCategory::findOrFail($id);

        // Delete image if exists
        if (
            $subcategory->image &&
            file_exists(public_path('uploads/subcategories/' . $subcategory->image))
        ) {
            unlink(public_path('uploads/subcategories/' . $subcategory->image));
        }

        $subcategory->delete();

        return redirect()
                ->route('list.subcategory')
                ->with('success', 'Sub Category deleted successfully.');
    }
}
