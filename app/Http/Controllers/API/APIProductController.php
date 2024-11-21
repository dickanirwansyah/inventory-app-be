<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class APIProductController extends Controller {

    public function index(Request $request){

        $perPage = $request->get('per_page', 10);

        $products = Product::paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Products list successfully !',
            'data' => $products
        ]);
    }

    public function store(Request $request){
        
        $validationData = $request->validate([
            'name' => 'required|string|max:150',
            'product_category' => 'required|string|max:150',
            'description' => 'required|string|max:255',
        ]);

        $product = Product::create($validationData);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully !',
            'data' => $product,
        ], 201);
    }

    public function update(Request $request){
        
        $validationData = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:150',
            'product_category' => 'required|string|max:150',
            'description' => 'required|string|max:255'
        ]);

        //check product id is exist or no
        $product = Product::find($request->id);

        if (!$product){
            return response()->json([
                'message' => 'Data with id not found',
                'status' => 404
            ],404);
        }

        //if exist update data
        $product->name = $request->name;
        $product->product_category = $request->product_category;
        $product->description = $request->description;

        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully !',
            'data' => $product,
        ], 200);
    }
}

