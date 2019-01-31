<?php

namespace App\Http\Controllers;

use App\Notify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IntegratorController extends Controller
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

    function getNotify(Request $request)
    {
        if($request->isJson())
        {
            $id_integrator = $request->json()->all();

            $notifies = DB::table('notifies')
                            ->select('description', 'created_at')
                            ->where('id_integrator', '=', $id_integrator['id_integrator'])
                            ->get();

            $count = count($notifies);

            if ($count) 
            {
                return response()->json($notifies, 200);
            }
            return response()->json(['Error' => 'No Found tuples.'], 400);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}