<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller; 
use App\User; 
use App\Recipe; 
use App\Ingredient; 
use App\RecipeIngredients; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\Support\Collection;

class RecipeController extends Controller 
{
public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        if(!empty(request('ingredients_id'))){
		$ingreds_ids_for = json_decode(request('ingredients_id'));
		$recipesids = array_unique(RecipeIngredients::whereIn('ingredient_id',$ingreds_ids_for)->pluck('recipe_id')->toArray());
		$Recipes = Recipe::whereIn('id',$recipesids)->with(array('user'=>function($query){
        $query->select('id','name');
        }))->with('ratings')->with('socialnetworks')->with('typeofrecipe')->with('ingredients')->get();
		//$RecipesResult =  [];
		$Recipes = $Recipes->filter(function ($item) use($ingreds_ids_for) {
		//foreach($Recipes as $item){
        $recipe_ingred_ids = RecipeIngredients::where('recipe_id','=',$item->id)->get();
		$recipe_ingred_ids_Prime = RecipeIngredients::where('recipe_id','=',$item->id)->where('ingredient_type','=',"Prime")->pluck('ingredient_id')->toArray();//pluck('ingredient_id','ingredient_type','quantity')->toArray();
			$recipe_ingred_ids_Secondary = RecipeIngredients::where('recipe_id','=',$item->id)->where('ingredient_type','=',"Secondary")->pluck('ingredient_id')->toArray();//pluck('ingredient_id','ingredient_type','quantity')->toArray();
			$recipe_ingred_ids_Mandatory = RecipeIngredients::where('recipe_id','=',$item->id)->where('ingredient_type','=',"Mandatory")->pluck('ingredient_id')->toArray();//pluck('ingredient_id','ingredient_type','quantity')->toArray();
			$Prime_count = count($recipe_ingred_ids_Prime);
			$Mandatory_count = count($recipe_ingred_ids_Mandatory);
			$Secondary_count = count($recipe_ingred_ids_Secondary);
			
			$resultPrime = array_intersect($ingreds_ids_for, $recipe_ingred_ids_Prime);
			$resultSecondary = array_intersect($ingreds_ids_for, $recipe_ingred_ids_Secondary);
			$resultMandatory = array_intersect($ingreds_ids_for, $recipe_ingred_ids_Mandatory);
			
			$resultMandatorycal = 0;
			$resultPrimecal = 0;
			$resultSecondarycal = 0;
			
			if($Mandatory_count >0)
			$resultMandatorycal = floatval((floatval(100/$Mandatory_count)*(count($resultMandatory))));
			
			if($Prime_count >0)
			$resultPrimecal = floatval((floatval(10/$Prime_count)*(count($resultPrime))));
			
			if($Secondary_count >0)
			$resultSecondarycal = floatval((floatval(50/$Secondary_count)*(count($resultSecondary))));
			
			if(count($resultSecondary) >1 ||count($resultMandatory)>1){
				$item->resultalgorithim = ($resultMandatorycal+$resultPrimecal+$resultSecondarycal);
		        //return ["Reciep"=>$item,"resultalgorithim"=>$resultalgorithim] ;
		        return $item;
			}
        });
		//$RecipesResult = collect($RecipesResult)->sortBy('resultalgorithim');
		$Recipes = $Recipes->sortByDesc('resultalgorithim');
		return response()->json(['success' => $Recipes->values()->all()], $this-> successStatus);
					
		}
		else{
			return response()->json(['success' => "not items received"], $this-> successStatus);
		}
		/*
		foreach($recipesids as $recipesid){
		$recipe_ingred_ids = RecipeIngredients::where('recipe_id','=',$recipesid)->get();
		$recipe_ingred_ids_Prime = RecipeIngredients::where('recipe_id','=',$recipesid)->where('ingredient_type','=',"Prime")->pluck('ingredient_id')->toArray();//pluck('ingredient_id','ingredient_type','quantity')->toArray();
			$recipe_ingred_ids_Secondary = RecipeIngredients::where('recipe_id','=',$recipesid)->where('ingredient_type','=',"Secondary")->pluck('ingredient_id')->toArray();//pluck('ingredient_id','ingredient_type','quantity')->toArray();
			$recipe_ingred_ids_Mandatory = RecipeIngredients::where('recipe_id','=',$recipesid)->where('ingredient_type','=',"Mandatory")->pluck('ingredient_id')->toArray();//pluck('ingredient_id','ingredient_type','quantity')->toArray();
			$Prime_count = count($recipe_ingred_ids_Prime);
			$Mandatory_count = count($recipe_ingred_ids_Mandatory);
			$Secondary_count = count($recipe_ingred_ids_Secondary);
			
			$resultPrime = array_intersect($ingreds_ids_for, $recipe_ingred_ids_Prime);
			$resultSecondary = array_intersect($ingreds_ids_for, $recipe_ingred_ids_Secondary);
			$resultMandatory = array_intersect($ingreds_ids_for, $recipe_ingred_ids_Mandatory);
			
			$resultMandatorycal = floatval(floatval(100/$Mandatory_count)*($Mandatory_count - count($resultMandatory)));
			$resultPrimecal = floatval(floatval(10/$Prime_count)*($Prime_count - count($resultPrime)));
			$resultSecondarycal = floatval(floatval(50/$Secondary_count)*($Secondary_count - count($resultSecondary)));
			if($resultMandatorycal+$resultPrimecal+$resultSecondarycal < 150){
				$Recipes = Recipe::where('id','=',$recipesid)->with('ingredients')->get();
		        return response()->json(['success' => $Recipes], $this-> successStatus);
			}
		
		}
		*/
        //return $this->sendResponse($Recipes->toArray(), 'Recipes retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
		$ingredients = json_decode($input['ingredients']);
		
		//return response()->json(['success' => $input], $this-> successStatus);
/*
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

*/
		$Recipe = new Recipe;
        $Recipe->title_ar = $input['title_ar'];
        $Recipe->title_en = $input['title_en'];
        $Recipe->totalCalories = $input['totalCalories'];
        $Recipe->time_to_make = $input['time_to_make'];
        $Recipe->type_of_recipe_id = $input['type_of_recipe_id'];
        $Recipe->user_id = Auth::user()->id;
        $Recipe->save();
		foreach($ingredients as $ingredient)
		$Recipe->ingredients()->attach($ingredient->id, ['ingredient_type' => $ingredient->ingredient_type, 'quantity' => $ingredient->quantity]);
		
		//$Recipe = Recipe::find($Recipe->id)->with('ingredients')->get();
        return response()->json(['success' => "Recipe stored successfully."], $this-> successStatus);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Recipe = Recipe::find($id);


        if (is_null($Recipe)) {
            return $this->sendError('Recipe not found.');
        }


        return $this->sendResponse($Recipe->toArray(), 'Recipe retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $Recipe)
    {
        $input = $request->all();


        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $Recipe->name = $input['name'];
        $Recipe->detail = $input['detail'];
        $Recipe->save();


        return $this->sendResponse($Recipe->toArray(), 'Recipe updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $Recipe)
    {
        $Recipe->delete();


        return $this->sendResponse($Recipe->toArray(), 'Recipe deleted successfully.');
    }

}

