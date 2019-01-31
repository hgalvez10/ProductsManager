<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    function index(Request $request)
    {
        if($request->isJson())
        {
            $product = Product::all();
            $count = count($product);

            if ($count) 
            {
                return response()->json($product, 200);
            }
            return response()->json(['Error' => 'No Found tuples.'], 400);
        }
        
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    function storeProduct(Request $request)
    {
        if($request->isJson())
        {
            // TODO: CREATE the user in the DB
            $data = $request->json()->all();
            
            $product = Product::create([
                'name' => $data['name'],
            ]);

            return response()->json([
                'name' => $product['name'],
            ], 201);
        }
        
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}