<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Traits\ApiResponser;


class OrderController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        // $order = Order::with(['customer', 'category', 'user'])->get();
        $order = Order::all();

        try {
            $response = $this->responseSuccess('GET', $order, 200);
            // $response = response()->json($order, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response = $this->responseError($th->getMessage(), 401);
        }

        return $response;
    }

    public function store(Request $request)
    {
        $order = new Order($request->all());

        // var_dump($request->all()); die;

        $order->save();

        return response()->json($order, 200);
    }

    public function update(Request $request, $id)
    {
    }

    public function show($id)
    {
    }

    public function destroy($id)
    {
    }
}
