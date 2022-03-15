<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AbsenController extends Controller
{
    public function addabsent(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'kodemember' => 'required|string|max:255'
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
            date_default_timezone_set('Asia/Jakarta');
            $hari = date('Y-m-d', time());
            $jam = date('h:i:s', time());
            $getabsen = DB::table('absens')->where('kodemember',$request->kodemember)->where('tanggalabsen',$hari)->first();
            if ($getabsen!=null) {
                $response = [
                'message' => 'sudah absen hari ini',
                'data' => 2 ];    
                return response()->json($response,Response::HTTP_OK);
            }
            $absen = DB::table('absens')->insert([
                'kodemember'=> $request->kodemember,
                'tanggalabsen'=> $hari,
                'jamabsen'=> $jam,
            ]);
            $response = [
                'message' => 'absen berhasil',
                'data' => 1 ]; 
        } catch (QueryException $th) {
            $response = [
                'message' => $th->errorInfo,
                'data' => 0 ]; 

        }
           return response()->json($response,Response::HTTP_OK);

    }

    public function belumabsen(Request $request)
    {

        try {
            date_default_timezone_set('Asia/Jakarta');
            $hari = date('Y-m-d', time());
           $users = DB::table('members')
            ->where('tanggalberakhir','>=',$hari)
           ->whereNotExists(function ($query) {
            date_default_timezone_set('Asia/Jakarta');
            $hari = date('Y-m-d', time());
               $query->select(DB::raw(1))
                     ->from('absens')
                     ->where('tanggalabsen',$hari)
                     ->whereColumn('absens.kodemember', 'members.kodemember');
           })
           ->get();
             $response = [
                    'message' => 'sudah absen hari ini',
                    'data' => $users ];    
            return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $th) {
            $response = [
                    'message' => 'sudah absen hari ini',
                    'data' => $th->errorInfo ];    
            return response()->json($response,Response::HTTP_OK);
        }

    }

     public function sudahabsen(Request $request)
    {
        try {
            date_default_timezone_set('Asia/Jakarta');
            $hari = date('Y-m-d', time());
            $absen = DB::table('absens')->where('tanggalabsen',$hari)
            ->join('members', 'absens.kodemember', '=', 'members.kodemember')
            ->get();
            $response = [
                    'message' => 'sudah absen hari ini',
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
