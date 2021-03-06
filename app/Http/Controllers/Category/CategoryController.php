<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Traits\ApiResponser;


class CategoryController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::CategoryGet();
        // var_dump($categories); die;
        // $response = $this->responseSuccess('POST', $categories, 200);
        $response = response()->json($categories, 200);
        // try {
        //     // $response = $this->responseSuccess('GET', $customer, 200);
        //     $response = response()->json($categories, 200);
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     // $response = $this->responseError($th->getMessage(), 401);
        //     $response = response()->json($th->getMessage(), 200);
        // }

        return $response;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $categoryFields = [
            'name' => $request->name,
            'description' => $request->description
        ];

        // dd($categoryFields);

        $categories = new Category();

        $categories->name   = $categoryFields['name'];
        $categories->description   = $categoryFields['description'];

        try {
            $categories->save();
            $response = $this->responseSuccess('POST', $categories, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response = $this->responseSuccess($th->getMessage(), 401);
        }

        return $response;

    }

    public function update(Request $request, $id)
    {

        $categoryFields = [
            'name' => $request->name,
            'description' => $request->description
        ];

        $categories = Category::find($id);

        $categories->name   = $categoryFields['name'];
        $categories->description   = $categoryFields['description'];

        try {
            $categories->save();
            $response = $this->responseSuccess('PUT', $categories, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response = $this->responseSuccess($th->getMessage(), 401);
        }

        return $response;

    }

    public function show($id)
    {
         $categories = Category::find($id);

         try {
            $response = $this->responseSuccess('GET BY ID', $categories, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response = $this->responseSuccess($th->getMessage(), 401);
        }

        return $response;
    }

    public function destroy($id)
    {

        $categories = Category::find($id);

         try {
            $response = $this->responseSuccess('DELETE', $categories, 200);
        } catch (\Throwable $th) {
            //throw $th;
            $response = $this->responseSuccess($th->getMessage(), 401);
        }

        return $response;
    }

    public function select2_category() {

        $categories = Category::Select2Category();

        return response()->json($categories);
    }
}
