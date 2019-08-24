<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Recipe; 
use App\SocialNetwork; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Collection;

class SocialNetworkController extends Controller
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
		//$input['user_id'] = 1;
		//Recipe::find($input['recipe_id'])
		$validator = Validator::make($input, [
            'type' => 'required',
            'link' => 'required',
            'recipe_id' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
		$SocialNetwork = new SocialNetwork;
        $SocialNetwork->type = $input['type'];
        $SocialNetwork->link = $input['link'];
        $SocialNetwork->recipe_id = $input['recipe_id'];
        $SocialNetwork->user_id = Auth::user()->id;
        $SocialNetwork->save();
		
		return response()->json(['success' => $SocialNetwork], $this-> successStatus);
	}
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $SocialNetwork = SocialNetwork::find($id);


        if (is_null($SocialNetwork)) {
            return $this->sendError('SocialNetwork not found.');
        }


        return $this->sendResponse($SocialNetwork->toArray(), 'SocialNetwork retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SocialNetwork $SocialNetwork)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $SocialNetwork->name = $input['name'];
        $SocialNetwork->detail = $input['detail'];
        $SocialNetwork->save();


        return $this->sendResponse($SocialNetwork->toArray(), 'SocialNetwork updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialNetwork $SocialNetwork)
    {
        $SocialNetwork->delete();


        return $this->sendResponse($SocialNetwork->toArray(), 'SocialNetwork deleted successfully.');
    }
}

