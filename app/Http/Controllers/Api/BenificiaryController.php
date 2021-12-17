<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Benificiary;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BenificiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Benificiary::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public  function store(Array $data)
    {
        try {
            $done = Benificiary::create($data);
            if($done){
                return ['status'=>true,'response'=>$done];
            }else{
                return ['status'=>false];
            }
        } catch (\Throwable $th) {
            return ['status'=>false];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Benificiary  $benificiary
     * @return \Illuminate\Http\Response
     */
    public  function show(String $uuid)
    {
        try {
            $ben =  Benificiary::where('uuid',$uuid)->get()->first();
            if($ben){
               return ["status"=> true,"response"=> $ben];
            }else{
                return ["status"=>false];
            }
        } catch (\Throwable $th) {
            return ["status"=>false];
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Benificiary  $benificiary
     * @return \Illuminate\Http\Response
     */
    public function update($data, String $uuid)
    {
        if($this->show($uuid)["status"] == true){
            try {
                Benificiary::where('uuid',$uuid)->get()->first()->update(
                    $data
                );
                return ["status" => true];
               } catch (\Throwable $th) {
                return ["status" => false];
               }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Benificiary  $benificiary
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $uuid)
    {

        if($this->show($uuid)["status"] == true){
           try {
            Benificiary::where('uuid',$uuid)->get()->first()->delete();
            return ["status"=>true];
           } catch (\Throwable $th) {
            return ["status"=>false];
           }
        }
    }
   /* private function lastSync()
   * {
        $user = User::where('uuid',auth()->user()->uuid)->first();
        return  $user->lastSync()->orderBy('last_sync_at','asc')->first()->last_sync_at;
    }
    */

}
