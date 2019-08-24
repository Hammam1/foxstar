<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory ['name', 'image', 'link'] */
$factory->define(App\Ring::class, function (Faker\Generator $faker) {
    
	return [
        'name' => $faker->word,
        'image' => 'adminlte/img/photo3.jpg',
        'link' =>  $faker->url,
        'categories_id' =>  rand(1, 10),
    ];
});

$factory->define(App\Category::class, function (Faker\Generator $faker) {
    
	return [
        'name' => $faker->word,
        'category' => $faker->word,
        'directed_by' => $faker->word,
        'championship' =>  $faker->word,
        'in_conjunction_with' =>  $faker->word,
        'image' =>  'adminlte/img/photo1.png',
        'author' =>  $faker->word,
    ];
});
