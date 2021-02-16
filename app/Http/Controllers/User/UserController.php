<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{

    use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(5);
        return $this->responseSuccess('GET users',$users, 200);
    }

    public function store(Request $request) {

        $filename = null;
        // if($request->file('photo')) {
        //     $filename = Str::random(5) . $request->email . '.jpg';
        //     $file = $request->file('photo');

        //     $file->move(base_path('public/images'), $filename);
        // }

        if ($request->hasFile('photo')) {
            //MAKA GENERATE NAMA UNTUK FILE TERSEBUT DENGAN FORMAT STRING RANDOM + EMAIL
            $filename = Str::random(5) . $request->email . '.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images'), $filename); //SIMPAN FILE TERSEBUT KE DALAM FOLDER PUBLIC/IMAGES
        }

        User::create([
            'name' => $request->name,
            'identity_id' => $request->identity_id,
            'gender' => $request->gender,
            'address' => $request->address,
            'photo' => $request->photo, //UNTUK FOTO KITA GUNAKAN VALUE DARI VARIABLE FILENAME
            'email' => $request->email,
            'password' => app('hash')->make($request->password), //PASSWORDNYA KITA ENCRYPT
            'phone_number' => $request->phone_number,
            // 'api_token' => 'test', //BAGIAN INI HARUSNYA KOSONG KARENA AKAN TERISI JIKA USER LOGIN
            'role' => $request->role,
            'status' => $request->status
        ]);
        return response()->json(['status' => 'success']);
    }
}
