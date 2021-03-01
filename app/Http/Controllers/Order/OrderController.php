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
    }

    public function index()
    {
        $order = Order::with(['customer', 'category', 'user'])->get();

        return response()->json($order);
    }

    public function store(Request $request)
    {
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
