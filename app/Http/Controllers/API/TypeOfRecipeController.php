<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\TypeOfRecipe; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Collection;
use App\Recipe; 

class TypeOfRecipeController extends Controller
{
public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
		$TypeOfRecipe = Auth::user()->typeofrecipes()->create($input);
		return response()->json(['success' => $TypeOfRecipe], $this-> successStatus);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(!empty(request('ids'))){
		$TypeOfRecipe = TypeOfRecipe::whereIn('id',json_decode(request('ids')))->with('recipes')->with(array('user'=>function($query){
        $query->select('id','name');
        }))->get();
		$Recipes = $TypeOfRecipe->filter(function ($item){
        //$Recipes = Recipe::whereIn('type_of_recipes_id',json_decode(request('ids'))->with('ratings')->with('socialnetworks')->with('ingredients')->get();
		return Recipe::find($item->id)->with(array('user'=>function($query){
        $query->select('id','name');
        }))->with('ratings')->with('socialnetworks')->with('ingredients')->get();
		});
        if (is_null($TypeOfRecipe)) {
			return response()->json(['Error' => 'TypeOfRecipe not found.']);
        }
		$TypeOfRecipe->Recipes = $Recipes;
       return response()->json(['success' => $TypeOfRecipe], $this-> successStatus);
	   }
	   else{
			return response()->json(['success' => "not items received"], $this-> successStatus);
		}
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeOfRecipe $TypeOfRecipe)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $TypeOfRecipe->name = $input['name'];
        $TypeOfRecipe->detail = $input['detail'];
        $TypeOfRecipe->save();


        return $this->sendResponse($TypeOfRecipe->toArray(), 'TypeOfRecipe updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeOfRecipe $TypeOfRecipe)
    {
        $TypeOfRecipe->delete();


        return $this->sendResponse($TypeOfRecipe->toArray(), 'TypeOfRecipe deleted successfully.');
    }
}

