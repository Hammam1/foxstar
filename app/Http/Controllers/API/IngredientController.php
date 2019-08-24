<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\Ingredient; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Collection;

class IngredientController extends Controller
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
		$Ingredient = Auth::user()->ingredients()->create($input);
		return response()->json(['success' => $Ingredient], $this-> successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Ingredient = Ingredient::find($id);


        if (is_null($Ingredient)) {
            return $this->sendError('Ingredient not found.');
        }


        return $this->sendResponse($Ingredient->toArray(), 'Ingredient retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ingredient $Ingredient)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $Ingredient->name = $input['name'];
        $Ingredient->detail = $input['detail'];
        $Ingredient->save();


        return $this->sendResponse($Ingredient->toArray(), 'Ingredient updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingredient $Ingredient)
    {
        $Ingredient->delete();


        return $this->sendResponse($Ingredient->toArray(), 'Ingredient deleted successfully.');
    }
}

