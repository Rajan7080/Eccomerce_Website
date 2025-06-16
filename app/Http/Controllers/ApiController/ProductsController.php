<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Console\Migrations\StatusCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelIgnition\Http\Requests\UpdateConfigRequest;
use App\Services\ImageUploadService;

class ProductsController extends Controller
{
    protected $imageService;

    public function __construct(ImageUploadService $imageService)
    {
        $this->imageService = $imageService;
    }
    public function index()
    {
        $data = Products::with('categories:id,name')->get();
        return response()->json([
            'status' => true,
            'message' => "document get all",
            'data' => $data
        ], 200);
    }
    public function show($id)
    {
        $data = Products::find($id);
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => "document get all",
            'data' => $data
        ], 200);
    }
    public function store(Request $request)
    {
        $validateData = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validateData->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validateData->errors()->all(),
            ], 422);
        }
        $fullPath = $this->imageService->upload($request->file('image'), 'uploads/products');



        $product = Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $fullPath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => $product,
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'stock' => 'nullable|integer',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Products::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
            ], 404);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->imageService->upload($request->file('image'), 'products');
        }

        $product->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully!',
            'data' => $product,
        ], 200);
    }








    public function destroy($id)
    {

        $product = Products::find($id);
        $product->delete();
        if (!$product) {
            return response()->json([
                'Status' => true,
                'message' => 'data deleted'
            ]);
        }
    }
}
