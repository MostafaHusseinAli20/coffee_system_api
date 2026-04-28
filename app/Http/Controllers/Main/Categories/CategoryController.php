<?php

namespace App\Http\Controllers\Main\Categories;

use App\Http\Controllers\Controller;
use App\Http\Resources\Main\CategoryResource;
use App\Models\Category;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role == 'developer') {
            $categories = Category::latest()->paginate(PAGINATION_COUNT);
        } else {
            $categories = Category::where('coffee_id', auth()->user()->coffee_id)
                ->latest()
                ->paginate(PAGINATION_COUNT);
        }
        if ($categories->isEmpty()) {
            return $this->errorResponse('No categories found', 404);
        }
        $response = CategoryResource::collection($categories);
        return $this->successResponse(
            $response,
            'Categories retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'coffee_id' => 'required|exists:coffees,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $slug = Str::slug($request->name);
            if(auth()->user()->role == 'developer') {
                $category = Category::create([
                    'name' => $request->name,
                    'slug' => $slug,
                    'coffee_id' => $request->coffee_id,
                    'description' => $request->description,
                    'is_active' => $request->is_active,
                    'added_by' => auth()->user()->id
                    ]);
            } else {
                $category = Category::create([
                    'name' => $request->name,
                    'slug' => $slug,
                    'coffee_id' => auth()->user()->coffee_id,
                    'description' => $request->description,
                    'is_active' => $request->is_active,
                    'added_by' => auth()->user()->id
                ]);
            }

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/categories'), $imageName);
                $category->image = 'uploads/categories/' . $imageName;
                $category->save();
            }

            DB::commit();
            return $this->successResponse(
                new CategoryResource($category),
                'Category created successfully'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create category', 500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(auth()->user()->role == 'developer') {
            $category = Category::find($id);
        } else {
            $category = Category::where('coffee_id', auth()->user()->coffee_id)
                ->where('id', $id)
                ->first();
        }
        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }
        return $this->successResponse(
            new CategoryResource($category),
            'Category retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $id,
            'coffee_id' => 'required|exists:coffees,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $slug = Str::slug($request->name);
            if(auth()->user()->role == 'developer') {
                $category = Category::find($id);
                $category->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'coffee_id' => $request->coffee_id,
                    'description' => $request->description,
                    'is_active' => $request->is_active,
                    'updated_by' => auth()->user()->id
                ]);
            } else {
                $category = Category::where('coffee_id', auth()->user()->coffee_id)
                    ->where('id', $id)
                    ->first();

                $category->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'coffee_id' => auth()->user()->coffee_id,
                    'description' => $request->description,
                    'is_active' => $request->is_active,
                    'updated_by' => auth()->user()->id
                ]);
            }
            if (!$category) {
                return $this->errorResponse('Category not found', 404);
            }

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/categories'), $imageName);
                $category->image = 'uploads/categories/' . $imageName;
                $category->save();
            }

            DB::commit();
            return $this->successResponse(
                new CategoryResource($category),
                'Category updated successfully'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to update category', 500, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->user()->role == 'developer') {
            $category = Category::find($id);
        } else {
            $category = Category::where('coffee_id', auth()->user()->coffee_id)
                ->where('id', $id)
                ->first();
        }
        if (!$category) {
            return $this->errorResponse('Category not found', 404);
        }
        $category->delete();
        return $this->successResponse(
            null,
            'Category deleted successfully'
        );
    }
}
