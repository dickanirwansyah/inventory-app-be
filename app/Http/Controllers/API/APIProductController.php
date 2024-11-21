<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Price;
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

    public function destroy(Request $request){
        
        $validationData = $request->validate([
            'id' => 'required'
        ]);

        //check product is exist or no
        $product = Product::find($request->id);

        if (!$product){
            return response()->json([
                'message' => 'Data with id not found',
                'status' => 404
            ],404);
        }

        //todo check validation foreign key

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully !',
            'data' => $product,
        ], 200);
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

    public function searchProductPriceDetail(Request $request){

        $request->validate([
            'name' => 'nullable|string|max:150',
            'product_category' => 'nullable|string|max:150',
            'tier' => 'nullable|string|max:100'
        ]);

        //build query
        $query = Product::query();

        if ($request->has('name') && $request->name){
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('product_category') && $request->product_category){
            $query->where('product_category', 'like', '%' . $request->product_category . '%');
        }

        if ($request->has('tier') && $request->tier){
            $query->whereHas('prices.priceDetails', function($q) use ($request) {
                $q->where('tier', 'like', '%' . $request->tier . '%');
            });
        }

        $products = $query->with([
            'prices' => function ($q) {
                $q->with('priceDetails');
            },
        ])->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Product details and price details is successfully !',
            'data' => $products,
        ], 200);
    }
}

