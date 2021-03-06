<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

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
        return $this->responseSuccess('GET users', $users, 200);
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        // var_dump($request->password); die;

        if ($user && Hash::check($request->password, $user->password)) {

            $token = Str::random(40);

            $user->update(['api_token' => $token]);

            return response()->json(['message' => 'GET', 'data' => $user, 'token' => $token]);
        }

        return response()->json(['error' => 'erros']);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'identity_id' => 'required',
            'gender' =>  'required',
            'address' =>  'required',
            // 'photo' =>  'required',
            'email' =>  'required',
            'password' =>  'required',
            'phone_number' => 'required',
            // 'api_token' => 'test', //BAGIAN INI HARUSNYA KOSONG KARENA AKAN TERISI JIKA USER LOGIN
            'role' => 'required',
            'status' =>  'required',
        ]);

        $filename = null;

        if ($request->hasFile('photo')) {
            //MAKA GENERATE NAMA UNTUK FILE TERSEBUT DENGAN FORMAT STRING RANDOM + EMAIL
            $filename = Str::random(5) . $request->email . '.jpg';
            $file = $request->file('photo');

            // var_dump($filename); die;
            $file->move(base_path('public/images'), $filename); //SIMPAN FILE TERSEBUT KE DALAM FOLDER PUBLIC/IMAGES
        }

        $users = User::create([
            'name' => $request->name,
            'identity_id' => $request->identity_id,
            'gender' => $request->gender,
            'address' => $request->address,
            'photo' => $filename, //UNTUK FOTO KITA GUNAKAN VALUE DARI VARIABLE FILENAME
            'email' => $request->email,
            'password' => app('hash')->make($request->password), //PASSWORDNYA KITA ENCRYPT
            'phone_number' => $request->phone_number,
            // 'api_token' => 'test', //BAGIAN INI HARUSNYA KOSONG KARENA AKAN TERISI JIKA USER LOGIN
            'role' => $request->role,
            'status' => $request->status
        ]);
        return $this->responseSuccess($users, 'POST users', 200);
    }


    public function edit($id)
    {
        $request = request();
        $users = User::findOrFail($id);

        try {
            return $this->responseSuccess('GET BY ID', $users, 200);
        } catch (\Throwable $th) {
            //throw $th;
            return $this->responseError('errors', $th->getMessage(), 401);
        }
    }

    public function update(Request $request, $id)
    {

        $user = User::find($id);

        $password = $request->password != '' ? app('hash')->make($request->password) : $user->password;

        $filename = $user->photo;

        // var_dump($filename); die;

        if ($request->hasFile('photo')) {
            //MAKA KITA GENERATE NAMA DAN SIMPAN FILE BARU TERSEBUT
            $filename = Str::random(5) . $user->email . '.jpg';
            $file = $request->file('photo');
            $file->move(base_path('public/images'), $filename); //
            //HAPUS FILE LAMA
            unlink(base_path('public/images/' . $user->photo));
        }

        $users = $user->update([
            'name' => $request->name,
            'identity_id' => $request->identity_id,
            'gender' => $request->gender,
            'address' => $request->address,
            // 'photo' => $filename, //UNTUK FOTO KITA GUNAKAN VALUE DARI VARIABLE FILENAME
            'email' => $request->email,
            'password' =>  $password, //PASSWORDNYA KITA ENCRYPT
            'phone_number' => $request->phone_number,
            // 'api_token' => 'test', //BAGIAN INI HARUSNYA KOSONG KARENA AKAN TERISI JIKA USER LOGIN
            'role' => $request->role,
            'status' => $request->status
        ]);

        return $this->responseSuccess('PUT', $users, 200);
    }

    public function bearerToken()
    {
        $header = $this->header('Authorization', '');
        if (Str::startsWith($header, 'Bearer ')) {
            return Str::substr($header, 7);
        }
    }

    public function show($id)
    {
        $users = User::find($id);
        $token = request()->bearerToken();

        try {

            if ($users->api_token == $token) {
                return $this->responseSuccess('GET BY ID', $users, 200);
            } else {
                return response()->json(['erros'  => 'Cannot Get Another User'], 401);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->responseError($th->getMessage(), 'Erros', 401);
        } catch (\Illuminate\Database\QueryException $ex) {
            return $this->responseError($ex->getMessage(), 'Erros', 401);
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 'Erros', 401);
        } catch (\PDOException $e) {
            return $this->responseError($e->getMessage(), 'Erros', 401);
        }
    }

    public function destroy($id)
    {
        $user = User::find($id);

        unlink(base_path('public/images' . $user->photo));

        if ($user->delete()) {
            return $this->responseSuccess('DELETE', $user, 200);
        }
    }

    public function sendResetToken(Request $request)
    {

        // $this->validate($request, [
        //     'email' => 'required|email|exists:users'
        // ]);

        $user = User::where('email', $request->email)->first();

        // dd($user);

        $user->update(['reset_token' => Str::random(40)]);

        Mail::to('ilyas@mewahniagajaya.com')->send(new ResetPasswordMail($user));

        echo "send email using gmail smtp";
    }

    public function verifyResetPassword(Request $request, $token)
    {

        $user = User::where('reset_token', $token)->first();

        if ($user) {
            $user->update(['password' => app('hash')->make($request->password)]);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    public function getUserLogin(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->update(['api_token' => NULL]);

        return response()->json(['status' => 'success'], 200);
    }


    public function search(Request $request)
    {

        $user = User::orderBy('created_at', 'desc')->when($request->q, function ($user) use ($request) {
            $user = $user->where('name', 'LIKE', '%' . $request->q . '%');
        })
            ->when($request->id, function ($user) use ($request) {
                $user = $user->where('id', '=', $request->id);
            })->paginate(5);


        return response()->json([
            'status' => 'success',
            'data' => $user,
        ]);
    }



    public function select2_user()
    {
        $user = User::Select2User();

        return response()->json($user, 200);
    }
}
