<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    public function addmember(Request $request)
    {
         $validator = Validator::make($request->all(),[
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'member' => 'required|string|max:255',
            'tanggalmulai' => 'required|max:255',
            'foto' => 'required|max:255',
            'nohp' => 'required|max:255',
            'tanggalberakhir' => 'required|max:255'
            ]);

        if($validator->fails()){
             $response = [
                'message' => 'pastikan data sudah benar',
                'error'=>$validator->errors(),
                'data' => 0
            ];        
            return response()->json($response,Response::HTTP_OK);
        }

          try {
            $produk = Member::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'nohp' => $request->nohp,
                'foto' => $request->foto,
                'kodemember' => $this->quickRandom(),
                'member' => $request->member,
                'tanggalmulai' => $request->tanggalmulai,
                'tanggalberakhir' => $request->tanggalberakhir
            ]);
              $response = [
                'message' => 'Input data berhasil',
                'data' => 1 ];   
        } catch (QueryException $th) {
              $response = [
                'message' => 'Input data gagal',
                'data' => $th->errorInfo ];   
        }

        return response()->json($response,Response::HTTP_OK);

    }

    public function getmember()
    {
         $getdata = DB::table('members')->orderBy('created_at','DESC')->get();
         $response = [
                'message' => 'getdata',
                'data' => $getdata
         ];        
            return response()->json($response,Response::HTTP_OK);
    }

    public function getmemberbulanan()
    {
         $getdata = DB::table('members')->where('member','bulanan')->orderBy('created_at','DESC')->get();
         $response = [
                'message' => 'getdata',
                'data' => $getdata
         ];        
            return response()->json($response,Response::HTTP_OK);
    }

    public function getmemberharian()
    {
         $getdata = DB::table('members')->where('member','harian')->orderBy('created_at','DESC')->get();
         $response = [
                'message' => 'getdata',
                'data' => $getdata
         ];        
            return response()->json($response,Response::HTTP_OK);
    }

    public function getmembertahuan()
    {
         $getdata = DB::table('members')->where('member','tahuan')->orderBy('created_at','DESC')->get();
         $response = [
                'message' => 'getdata',
                'data' => $getdata
         ];        
            return response()->json($response,Response::HTTP_OK);
    }

     public function getmembermingguan()
    {
         $getdata = DB::table('members')->where('member','mingguan')->orderBy('created_at','DESC')->get();
         $response = [
                'message' => 'getdata',
                'data' => $getdata
         ];        
            return response()->json($response,Response::HTTP_OK);
    }

    public function gettotalmember()
    {
        $totalmember = DB::table('members')->count();
        $response = [
                    'message' => 'data level',
                    'data' => $totalmember
                        ];     
        return response()->json($response,Response::HTTP_OK); 
    }
    public static function quickRandom($length = 15)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    public function habismasaberlaku(Request $request)
    {
           try {
            date_default_timezone_set('Asia/Jakarta');
            $hari = date('Y-m-d', time());
            $absen = DB::table('members')
            ->where('tanggalberakhir','<=',$hari)
            ->get();
            $response = [
                    'message' => 'member sudah habis',
                    'data' => $absen ];    
            return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $th) {
            $response = [
                    'message' => 'sudah absen hari ini',
                    'data' => $th->errorInfo ];    
            return response()->json($response,Response::HTTP_OK);
        }
    }

}
