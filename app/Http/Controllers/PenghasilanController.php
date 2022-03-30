<?php

namespace App\Http\Controllers;

use App\Models\Penghasilan;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PenghasilanController extends Controller
{

    public function penghasilan()
    {
        $getdata = Penghasilan::orderby('created_at','desc')->get();
        $response = [
            'message' => 'Checkout data berhasil',
            'data' => $getdata ];
        
            return response()->json($response,Response::HTTP_OK);     
    }

    public function totalpenghasilan()
    {
           try {
                $total = DB::table('penghasilans')->sum('harga');
                $response = [
                    'message' => 'Checkout data berhasil',
                    'data' => (int)$total ];   
            } catch (QueryException $th) {
                $response = [
                    'message' => 'Checkout data gagal',
                    'data' => $th->errorInfo ];   
            }
            
            return response()->json($response,Response::HTTP_OK);  
    }

    public function getpenghasilan(Request $request)
    {
        $getdata = Penghasilan::orderby('created_at','desc')->get();
        $response = [
            'message' => 'Checkout data berhasil',
            'data' => $getdata ];
        
            return response()->json($response,Response::HTTP_OK);     
    
    }


    public function totalhariini(Request $request)
    {
         try {
            $revenues = DB::table('penghasilans')->whereYear('updated_at', $request->input('tahun'))
            ->whereMonth('updated_at',$request->input('bulan'))->whereDay('updated_at',$request->input('hari'))->sum('harga');

            $response = [
                        'message' => 'Jumlah penghasilan hari ini',
                        'data' => (int)$revenues ];  
            } catch (QueryException $th) {
                $response = [
                    'message' => 'Checkout data gagal',
                    'data' => $th->errorInfo ];   
            }
            
            return response()->json($response,Response::HTTP_OK);   
    }

    public function totalbulanini(Request $request)
    {
         try {
            $revenues = DB::table('penghasilans')->whereYear('updated_at', $request->input('tahun'))
            ->whereMonth('updated_at',$request->input('bulan'))->sum('harga');

            $response = [
                        'message' => 'Jumlah penghasilan bulan ini',
                        'data' => (int)$revenues ];  
            } catch (QueryException $th) {
                $response = [
                    'message' => 'Checkout data gagal',
                    'data' => $th->errorInfo ];   
            }
            
            return response()->json($response,Response::HTTP_OK);   
    }

    
    public function totalmingguini(Request $request)
    {
         try {
             $week = Carbon::today()->subDays(7);
             $sum = Penghasilan::where('created_at','>=',$week)->sum('harga');
            $response = [
                        'message' => 'Jumlah penghasilan minggu ini',
                        // 'data' => (int)$revenues ];  
                        'data' => (int)$sum ];  
            } catch (QueryException $th) {
                $response = [
                    'message' => 'Checkout data gagal',
                    'data' => $th->errorInfo ];   
            }
            
            return response()->json($response,Response::HTTP_OK);   
    }

    public function totaltransaksi(Request $request)
    {
        try {
            $total = DB::table('penghasilans')->sum('harga');
            $totalhariini = DB::table('penghasilans')->whereYear('updated_at', $request->input('tahun'))
            ->whereMonth('updated_at',$request->input('bulan'))->whereDay('updated_at',$request->input('hari'))->sum('harga');
            $totalbulanini = DB::table('penghasilans')->whereYear('updated_at', $request->input('tahun'))
            ->whereMonth('updated_at',$request->input('bulan'))->sum('harga');
            $week = Carbon::today()->subDays(7);
            $totalmingguini = Penghasilan::where('created_at','>=',$week)->sum('harga');

            $response = [
                'message' => 'Checkout data berhasil',
                'total' => (int)$total,
                'hari_ini' => (int)$totalhariini,
                'minggu_ini' => (int)$totalmingguini,
                'bulan_ini' => (int)$totalbulanini
            ];   
        } catch (QueryException $th) {
            $response = [
                'message' => 'Checkout data gagal',
                'data' => $th->errorInfo ];   
        }
        
        return response()->json($response,Response::HTTP_OK);  
    }

 
}
