<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ImageUploadService;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{

    protected $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function index()
    {
        // Fetch only parent categories and eager load children
        $categories = Categories::whereNull('parent_id')

            ->with('children')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Category retrieved successfully',
            'data' => $categories
        ]);
    }



    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ];

        // Create validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }
        $fullPath = $this->imageService->upload($request->file('image'), 'uploads/categories');





        $category = Categories::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'image' => $fullPath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }


    /**
     * Display the specified category.
     */
    public function show($id)
    {
        $category = Categories::with('children')->find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Category retrieved successfully',
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'image' => $category->image,
                'parent_id' => $category->parent_id ?? null, // Ensure parent_id exists
            ],
        ]);
    }


    /**
     * Update the specified category.
     */
    public function update(Request $request, $id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json([
                'status' => false, // ✅ Changed to match frontend
                'message' => 'Category not found',
            ], 404);
        }

        $validateData = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
        ]);


        if ($validateData->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validateData->errors()->all(),
            ], 422);
        }

        $category->update([
            'name' => $request->name,
            'image' => $request->hasFile('image') ? $this->imageService->upload($request->file('image'), 'uploads/categories') : $category->image,
            'parent_id' => $request->parent_id,
        ]);

        return response()->json([
            'success' => true, // ✅ Changed to match frontend
            'message' => 'Category updated successfully',
            'data' => $category,
        ]);
    }


    /**
     * Remove the specified category.
     */
    public function destroy($id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ]);
    }
}
