<?php

namespace App\Http\Controllers;

use App\Catalogue;
use App\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogueController extends Controller
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

    function storeCatalogue(Request $request)
    {
        if($request->isJson())
        {
            $data = $request->json()->all();

            $catalogues = DB::table('catalogues')
                            ->where([
                                        ['customer_id', '=', $data['customer_id']],
                                        ['product_id', '=', $data['product_id']],
                                    ])
                            ->get();

            $isRegister = count($catalogues);

            if ($isRegister == 0) 
            {
                $catalogue = Catalogue::create([
                    'customer_id' => $data['customer_id'],
                    'product_id'  => $data['product_id'],
                    'quantity'    => $data['quantity'],
                    'isEmpty'     => 0
                ]);

                if ($catalogue) 
                {
                    return response()->json([
                        'customer id'  => $catalogue['customer_id'],
                        'product id'   => $catalogue['product_id'],
                        'quantity'     => $catalogue['quantity'],
                    ], 201);
                }
                else
                {
                    return response()->json(['Error' => 'Register not saved.'], 401);
                }
            }
            else
            {
                return response()->json(['Error' => 'The record exists.'], 401);
            }
        }
        
        return response()->json(['Error' => 'Unauthorized'], 401);
    }

    function AddStock(Request $request)
    {
        if($request->isJson())
        {
            $data = $request->json()->all();

            $catalogues = DB::table('catalogues')
                            ->where([
                                        ['customer_id', '=', $data['customer_id']],
                                        ['product_id', '=', $data['product_id']],
                                    ])
                            ->get();

            $isRegister = count($catalogues);

            // selected of param 'isEmpty' 
            $isEmpty = DB::table('catalogues')
                ->select('isEmpty')
                ->where([
                         ['customer_id', '=', $data['customer_id']],
                         ['product_id', '=', $data['product_id']],
                        ])
                ->get();


            $product = DB::table('products')
                            ->select('name')
                            ->where('id', '=', $data['product_id'])
                            ->get();

            if ($isRegister != 0) 
            {
                if ($isEmpty[0]->isEmpty == 0) 
                {
                    $stock = DB::table('catalogues')
                            ->where([
                                     ['customer_id', '=', $data['customer_id']],
                                     ['product_id', '=', $data['product_id']],
                                    ])
                            ->increment('quantity', $data['quantity']);

                    return response()->json([
                                'Description' => 'Stock was added in the product '.$product[0]->name,
                                'Notify status' => "It isn't necessary to send notification.",
                            ], 201);
                }
                else
                {
                    // TODO: enviar notificación
                    $stock = DB::table('catalogues')
                            ->where([
                                     ['customer_id', '=', $data['customer_id']],
                                     ['product_id', '=', $data['product_id']],
                                    ])
                            ->increment('quantity', $data['quantity']);

                    if ($stock) 
                    {
                        $updated_catalogue = DB::table('catalogues')
                                                ->where([
                                                         ['customer_id', '=', $data['customer_id']],
                                                         ['product_id', '=', $data['product_id']],
                                                        ])
                                                ->update(['isEmpty' => 0]);

                        $id_integrator = DB::table('customers')
                                        ->select('isClientTo')
                                        ->where('id_user', '=', $data['customer_id'])
                                        ->get();

                        $notify = Notify::create([
                            'description' => 'The product '.$product[0]->name.' has become available again.',
                            'id_integrator'  => $id_integrator[0]->isClientTo
                        ]);

                        if ($notify) 
                        {
                            return response()->json([
                                'Description' => 'The product '.$product[0]->name.' has replenished its stock.',
                                'Notify status' => 'Notification was sent.',
                            ], 201);   
                        }
                        else
                        {
                            return response()->json([
                                'Description' => 'The product '.$product[0]->name.' has replenished its stock.',
                                'Notify status' => 'Notification was not sent.',
                            ], 201);
                        }                     
                    }
                }
            }
            else
            {
                return response()->json(['Error' => "The record don't exists."], 401);
            }
        }
        
        return response()->json(['error' => 'Unauthorized'], 401);       
    }

    function takeDown(Request $request)
    {
        if($request->isJson())
        {
            $data = $request->json()->all();

            $quantity = DB::table('catalogues')
                ->select('quantity')
                ->where('id', '=', $data['catalogue_id'])
                ->get();
            $count = count($quantity);

            if ($count) 
            {
                $quantity_old = (int)$quantity[0]->quantity;

                if ($quantity_old > (int)$data['quantity']) 
                {
                    $stock = DB::table('catalogues')
                            ->where('id', '=', $data['catalogue_id'])
                            ->decrement('quantity', (int)$data['quantity']);

                    return response()->json([
                                'Description' => 'The product was buy succefully.',
                                'Operation status' => 'Completed.',
                            ], 201);
                }
                elseif ($quantity_old == (int)$data['quantity']) 
                {
                    $stock = DB::table('catalogues')
                            ->where('id', '=', $data['catalogue_id'])
                            ->decrement('quantity', (int)$data['quantity']);

                    $isEmpty = DB::table('catalogues')
                                ->where('id', $data['catalogue_id'])
                                ->update(['isEmpty' => 1]);

                    return response()->json([
                                'Description' => 'The product was buy succefully.',
                                'Operation status' => 'Completed.',
                            ], 201);
                }
                else
                {
                    return response()->json([
                        'Error' => 'Stock of the product is less than requested.',
                        'Stock available' => $quantity[0]->quantity
                    ], 401);
                }
            }
            else
            {
                return response()->json(['Error' => 'Record no found.'], 401);
            }
            
        }
        
        return response()->json(['Error' => 'Unauthorized'], 401);        
    }

    function getCataloguesByCustomer(Request $request)
    {
        if($request->isJson())
        {
            $data = $request->json()->all();

            $users = DB::table('catalogues')
                    ->where('customers.isClientTo', '=', $data['id_integrator'])
                    ->join('customers', 'catalogues.customer_id', '=', 'customers.id_user')
                    ->join('products', 'catalogues.product_id', '=', 'products.id')
                    ->select('customers.name as customer_name', 'products.name as product_name', 'catalogues.quantity')
                    ->get();

            $count = count($users);

            if ($count) 
            {
                return response()->json($users, 200);
            }
            return response()->json(['Error' => 'No Found tuples.'], 400);
        }

        return response()->json(['Error' => 'Unauthorized'], 401);
    }

    function getCatalogueCustomer(Request $request)
    {
        if($request->isJson())
        {
            $data = $request->json()->all();

            $users = DB::table('catalogues')
                    ->where([
                             ['customers.isClientTo', '=', $data['id_integrator']],
                             ['catalogues.customer_id', '=', $data['id_customer']],
                            ])
                    ->join('customers', 'catalogues.customer_id', '=', 'customers.id_user')
                    ->join('products', 'catalogues.product_id', '=', 'products.id')
                    ->select('customers.name as customer_name', 'products.name as product_name', 'catalogues.quantity')
                    ->get();

            $count = count($users);

            if ($count) 
            {
                return response()->json($users, 200);
            }
            return response()->json(['Error' => 'No Found tuples.'], 400);
        }

        return response()->json(['Error' => 'Unauthorized'], 401);
    }
}