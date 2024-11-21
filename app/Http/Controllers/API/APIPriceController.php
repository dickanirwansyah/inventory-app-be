<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class APIPriceController extends Controller {

    public function store(Request $request){
        try{
            $validationData = $request->validate([
                'product_id' => 'required|integer|exists:products,id',
                'unit' => 'required|string|max:100'
            ]);
    
            $price = Price::create([
                'product_id' => $validationData['product_id'],
                'unit' => $validationData['unit']
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'price created successfully !',
                'data' => $price,
            ], 201);

        }catch(ValidationException $ex){
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $ex->errors()
            ],422);
        }
    }

    public function update(Request $request){
        try{
            $validationData = $request->validate([
                'id' => 'required|integer',
                'product_id' => 'required|integer|exists:products,id',
                'unit' => 'required|string|max:100'            
            ]);
    
    
            $price = Price::find($request->id);
            if (!$price){
                return response()->json([
                    'message' => 'Data with id not found',
                    'status' => 404
                ],404);
            }
    
            $price->unit = $request->unit;
            $price->product_id = $request->product_id;
    
            $price->save();
    
            return response()->json([
                'success' => true,
                'message' => 'price update successfully !',
                'data' => $price,
            ], 201);

        }catch(ValidationException $ex){
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $ex->errors()
            ],422);
        }
    }
}