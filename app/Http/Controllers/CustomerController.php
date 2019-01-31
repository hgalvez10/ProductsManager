<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
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

    function getCustomers(Request $request)
    {
        if($request->isJson())
        {
            $id_integrator = $request->json()->all();

            $customers = DB::table('customers')->where('isClientTo', '=', $id_integrator)->get();
            $count = count($customers);
            
            if ($count) 
            {
                return response()->json($customers, 200);
            }
            return response()->json(['Error' => 'No Found tuples.'], 400);
        }

        return response()->json(['Error' => 'Format request incorrect.'], 401);
    }
}