<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ring;
use App\Category;

class RingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$rings = Ring::all();
		return view('admin.rings.list', compact('rings'));
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		return view('admin.rings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
      $request->validate([
        'name_ar'=>'required',
        'name_en'=> 'required',
        'quantity'=> 'required|integer',
        'calories'=> 'required|integer'
      ]);
      $rings = new rings([
        'name_ar' => $request->get('name_ar'),
        'name_en'=> $request->get('name_en'),
        'quantity'=> $request->get('quantity'),
        'calories'=> $request->get('calories')
      ]);
      $rings->save();
      return redirect()->back()->with('success', 'rings has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

