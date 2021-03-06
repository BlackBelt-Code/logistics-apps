<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    // use Traits/ApiResponser
    use ApiResponser;

    public function __construct()
    {
        // $this->middleware('auth');

    }

    public function bearerToken()
    {
        $header = $this->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }

    public function index() {

        $customer = Customer::CustomerGet();

        try {
            $response =  $this->responseSuccess('GET',
            $customer, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response = $this->responseError('erros', $th->getMessage());
        }
        return $response;
    }

    public function store(Request $request) {

        $this->validate($request, [
            'name'          => 'required',
            'phone_number'  => 'required',
            'address'       => 'required',
            'point'         => 'required',
            'deposit'       => 'required',
        ]);

        $customerRequest = [
            'name'          => $request->name,
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'point'         => $request->point,
            'deposit'       => $request->deposit,
        ];


        $customer = new Customer();

        $customer->name         = $customerRequest['name'];
        $customer->phone_number = $customerRequest['phone_number'];
        $customer->address      = $customerRequest['address'];
        $customer->point        = $customerRequest['point'];
        $customer->deposit      = $customerRequest['deposit'];

        try {

            $customer->save();

            $response = $this->responseSuccess('POST', $customer, 200);

        } catch (\Throwable $th) {
            //throw $th;
            $response = $this->responseError('Error', $th->getMessage());
        }

        return $response;

    }

    public function update(Request $request, $id) {

        $customerRequest = [
            'name'          => $request->name,
            'phone_number'  => $request->phone_number,
            'address'       => $request->address,
            'point'         => $request->point,
            'deposit'       => $request->deposit,
            // add this line to form-data = _method = PUT
        ];

        $customer = Customer::find($id);

        $customer->name         = $customerRequest['name'];
        $customer->phone_number = $customerRequest['phone_number'];
        $customer->address      = $customerRequest['address'];
        $customer->point        = $customerRequest['point'];
        $customer->deposit      = $customerRequest['deposit'];

        try {
            $customer->save();
            $response = $this->responseSuccess('PUT', $customer, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response = $this->responseError($th->getMessage(), 401);
        }

        return $response;
    }

    public function show($id) {

        $customer = Customer::find($id);

        try {
            $response =  $this->responseSuccess('GET', $customer, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response =  $this->responseError($th->getMessage(), 401);
        }

        return $response;
    }

    public function destroy($id) {
        $customer = Customer::find($id);

        try {
            $customer->delete();
            $response = $this->responseSuccess('DELETE', $customer, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response = $this->responseError($th->getMessage(), 401);
        }

        return $response;
    }

    public function select2_customer() {

        $customer = Customer::Select2Customer();

        return response()->json($customer, 200);
    }
}
