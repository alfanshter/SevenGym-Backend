<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersController extends Controller
{
    public function register(Request $request)
    {
         $validator = Validator::make($request->all(),[
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'role' => 'required|string|max:255'
            ]);

        if($validator->fails()){
             $response = [
                'message' => 'pastikan data sudah benar',
                'error'=>$validator->errors(),
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);
        }

        $ceknik = DB::table('users')->where('username',$request->username)->first();
        if($ceknik==null){
           
        }else {
            $response = [
                'message' => 'username terdaftar',
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }


        $user = User::create([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'role' => $request->role,
                    'password' => Hash::make($request->password),
                ]);
                $token = $user->createToken('auth_token')->plainTextToken;
                            $response = [
                                            'message' => $user['username'],
                                            'data' => 1,
                                            'token' => $token,
                                            'id' => $user['id']
                                        ];   
                return response()->json($response,Response::HTTP_OK);  
    }

       //Proses Login
     public function login(Request $request)
    {
        if (!Auth::attempt($request->only('username', 'password')))
        {
             $response = [
                'message' => 'username atau password salah',
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }

        $user = User::where('username', $request['username'])->first();
        if ($user==null) {
            $response = [
                'message' => 'username atau password salah',
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);  
        }
        $token = $user->createToken('auth_token')->plainTextToken;
            $response = [
                'message' => $user->username,
                'token' => $token,
                'data' => 1,
                'role' => $user->role,
                'id' => $user->id
            ];        
            return response()->json($response,Response::HTTP_OK);  

    }
    //End Proses Login
}
