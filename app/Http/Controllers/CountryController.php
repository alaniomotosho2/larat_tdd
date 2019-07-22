<?php

namespace App\Http\Controllers;

use App\CountryModel;
use Illuminate\Http\Request;


use Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(CountryModel::get(),200);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' =>'required|min:3',
            'region' =>'required|min:5|max:20'
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        
        
        $country =  CountryModel::create($request->all());
        return response()->json($country,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\c  $c
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $country = CountryModel::find($id);
        if(is_null($country)){
            return response()->json(["message"=>"Not Found"],404);
        }
        return response()->json($country,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\c  $c
     * @return \Illuminate\Http\Response
     */
    public function edit(CountryModel $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\c  $c
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $world = CountryModel::findOrfail($id);
        $world->update($request->all());
        return response()->json($world,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\c  $c
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $world = CountryModel::findOrfail($id);
        $world ->delete();
        return response()->json(null,204);
    }
}
