<?php

namespace App\Http\Controllers;

use App\User;
use App\Integrator;
use App\Customer;
use Illuminate\Http\Request;

class UserController extends Controller
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

    //
    function index(Request $request)
    {
        if($request->isJson())
        {
            $user = User::all();
            return response()->json($user, 200);
        }
        
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    function storeIntegrator(Request $request)
    {
        if($request->isJson())
        {
            // TODO: CREATE the user in the DB
            $data = $request->json()->all();
            
            $user = User::create([
                'email'     => $data['email'],
                'type_user' => $data['type_user']
            ]);

            $integrator = Integrator::create([
                'id_integrator' => $user['id'],
                'name'          => $data['name']
            ]);

            return response()->json([
                'name'          => $integrator['name'],
                'email'         => $user['email'],
                'type user'     => $user['type_user'],
            ], 201);
        }
        
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    function storeCustomer(Request $request)
    {
        if($request->isJson())
        {
            // TODO: CREATE the user in the DB
            $data = $request->json()->all();

            $user = User::create([
                'email'     => $data['email'],
                'type_user' => $data['type_user']
            ]);

            $customer = Customer::create([
                'id_user'    => $user['id'],
                'name'       => $data['name'],
                'isClientTo' => $data['Integrator']
            ]);

            return response()->json([
                'name'          => $customer['name'],
                'email'         => $user['email'],
                'type user'     => $user['type_user'],
                'isClientTo'    => $customer['isClientTo'],
            ], 201);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}