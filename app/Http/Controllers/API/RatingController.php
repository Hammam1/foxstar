<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Rating; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Collection;

class RatingController extends Controller
{
public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		$input = $request->all();
		$validator = Validator::make($input, [
            'rate' => 'required',
            'recipe_id' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		$Rating = new Rating;
        $Rating->rate = $input['rate'];
        $Rating->recipe_id = $input['recipe_id'];
        $Rating->user_id = Auth::user()->id;
        $Rating->save();
		return response()->json(['success' => $Rating], $this-> successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Rating = Rating::find($id);


        if (is_null($Rating)) {
            return $this->sendError('Rating not found.');
        }


        return $this->sendResponse($Rating->toArray(), 'Rating retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $Rating)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $Rating->name = $input['name'];
        $Rating->detail = $input['detail'];
        $Rating->save();


        return $this->sendResponse($Rating->toArray(), 'Rating updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $Rating)
    {
        $Rating->delete();


        return $this->sendResponse($Rating->toArray(), 'Rating deleted successfully.');
    }
}

