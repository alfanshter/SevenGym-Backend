<?php

namespace App\Http\Controllers;

use App\Models\Ongkos;
use App\Http\Requests\StoreOngkosRequest;
use App\Http\Requests\UpdateOngkosRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

use function GuzzleHttp\Promise\all;

class OngkosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function insertongkos(Request $request)
     {
        $validator = Validator::make($request->all(),[
            'tipe' => ['required'],
            'harga' => ['required']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $cekongkos = Ongkos::where('tipe',$request->tipe)->first();
        if ($cekongkos!=null) {
            DB::table('ongkos')->where('id',$cekongkos->id)->update($request->all());
            $response = [
                'message' => 'Update berhasil',
                'status' => 1 ];    
            return response()->json($response,Response::HTTP_OK);

        }else{
            Ongkos::create($request->all());
            $response = [
                'message' => 'Input data sukses',
                'status' => 1 ];
    
            return response()->json($response,Response::HTTP_OK);
    
        }

        




     }
     
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOngkosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOngkosRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ongkos  $ongkos
     * @return \Illuminate\Http\Response
     */
    public function show(Ongkos $ongkos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ongkos  $ongkos
     * @return \Illuminate\Http\Response
     */
    public function edit(Ongkos $ongkos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOngkosRequest  $request
     * @param  \App\Models\Ongkos  $ongkos
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOngkosRequest $request, Ongkos $ongkos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ongkos  $ongkos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ongkos $ongkos)
    {
        //
    }
}
