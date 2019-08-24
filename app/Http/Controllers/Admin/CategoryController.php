<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Category;
use App\SeriesCategory;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		if (! Gate::allows('categories_manage')) {
            return abort(401);
        }
		$categories = Category::all();
		return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		if (! Gate::allows('categories_manage')) {
            return abort(401);
        }
		
		$seriescategories = SeriesCategory::all();
		return view('admin.categories.create', compact('seriescategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //['category', 'directed_by', 'championship', 'in_conjunction_with','image','author']
		if (! Gate::allows('categories_manage')) {
            return abort(401);
        }		
      $request->validate([
        'name'=>'required',
        'category'=>'required',
        'directed_by'=> 'required',
        'championship' => 'required',
        'in_conjunction_with' => 'required',
        'image' => 'required'
      ]);
      $category = new Category([
        'name' => $request->get('name'),
        'category' => $request->get('category'),
        'directed_by'=> $request->get('directed_by'),
        'championship'=> $request->get('championship'),
        'in_conjunction_with'=> $request->get('in_conjunction_with'),
        'image'=> $request->get('image'),
        'author'=> $request->get('author')
      ]);
      $category->save();
      return redirect()->back()->with('success', 'Stock has been added');
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
		if (! Gate::allows('categories_manage')) {
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
		if (! Gate::allows('categories_manage')) {
            return abort(401);
        }
		$ring = Category::find($id);
		return view('admin.categories.edit', compact('ring'));
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
		if (! Gate::allows('categories_manage')) {
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
		if (! Gate::allows('categories_manage')) {
            return abort(401);
        }
		$ring = Category::findOrFail($id);
        $ring->delete();

        return redirect()->route('admin.categories.index');

    }
	
	/**
     * Delete all selected Role at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if (! Gate::allows('categories_manage')) {
            return abort(401);
        }
        if ($request->input('ids')) {
            $entries = Category::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }
}

