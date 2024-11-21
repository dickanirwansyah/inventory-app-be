<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\PriceDetail;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class APIPriceDetailController extends Controller{

    public function store(Request $request){

        try{
            $validateData = $request->validate([
                'price_id' => 'required|integer|exists:prices,id',
                'tier' => 'required|string|max:100',
                'price' => 'required'
            ]);
            
            $priceDetail = PriceDetail::create([
                'price_id' => $validateData['price_id'],
                'tier' => $validateData['tier'],
                'price' => $validateData['price']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'price detail successfully created',
                'data' => $priceDetail
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