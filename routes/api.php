<?php
/*
Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

});
*/

Route::post('provider/login', 'API\UserController@providerlogin');
Route::post('login', 'API\UserController@login');
//Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'API\UserController@details');
});
/*
Route::post('/recipes/search', 'API\RecipeController@search');
Route::post('/recipes/store', 'API\RecipeController@store');
Route::post('/ratings/store', 'API\RatingController@store');
Route::post('/ingredients/store', 'API\IngredientController@store');
Route::post('/socialnetworks/store', 'API\SocialNetworkController@store');
Route::post('/typeofrecipes/store', 'API\TypeOfRecipeController@store');
Route::post('/typeofrecipes/search', 'API\TypeOfRecipeController@show');

*/