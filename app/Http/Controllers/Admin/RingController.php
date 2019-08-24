<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Ring;
use App\Category;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;


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
		if (! Gate::allows('rings_manage')) {
            return abort(401);
        }

		$rings = Ring::all();
		$categories = Category::all();
		return view('admin.rings.index', compact('rings','categories'));
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		if (! Gate::allows('rings_manage')) {
            return abort(401);
        }
		$categories = Category::all();
		return view('admin.rings.create',compact('categories'));
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
		if (! Gate::allows('rings_manage')) {
            return abort(401);
        }

      $request->validate([
        'name'=>'required',
        'link'=> 'required',
        'image'=> 'required'
      ]);
	  $category = Category::find($request->get('categories_id'));
	  $input = $request->all();
	  $category->rings()->create($input);
      
      return redirect()->back()->with('success', 'Ring has been added');
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
		if (! Gate::allows('rings_manage')) {
            return abort(401);
        }

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
		if (! Gate::allows('rings_manage')) {
            return abort(401);
        }
		$ring = Ring::find($id);
		return view('admin.rings.edit', compact('ring'));
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
		if (! Gate::allows('rings_manage')) {
            return abort(401);
        }

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
		if (! Gate::allows('rings_manage')) {
            return abort(401);
        }
		$ring = Ring::findOrFail($id);
        $ring->delete();

        return redirect()->route('admin.rings.index');

    }
	
	/**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('rings_manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Ring::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
	
}

