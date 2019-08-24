<?php

use Illuminate\Database\Seeder;
use App\Ring;
use App\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
		$this->call(PermissionSeed::class);
        $this->call(RoleSeed::class);
        $this->call(UserSeed::class);

        for ($j = 0; $j <= 10; $j++) {
		 factory(Category::class)->create();
       }
		
		
        for ($x = 0; $x <= 100; $x++) {
	     factory(Ring::class)->create();
	   }
	   /*
	   for ($x = 0; $x <= 1000; $x++) {
		factory(Ingredient::class)->create();
		factory(Recipe::class)->create();
       }
	   
	   for ($x = 1; $x <= 1000; $x++) {
		//factory(Recipe::class)->create();
		$rRecipe = Recipe::find($x);
		if($rRecipe){
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Prime", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Secondary", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Secondary", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Secondary", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Secondary", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Secondary", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Mandatory", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Mandatory", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Prime", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Prime", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Secondary", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Prime", 'quantity' => rand(1, 10)]);
		$rRecipe->ingredients()->attach(rand(1, 999), ['ingredient_type' => "Prime", 'quantity' => rand(1, 10)]);
		}
       }
	   
	   for ($x = 0; $x <= 1000; $x++) {
	   factory(Rating::class)->create();
	   factory(SocialNetwork::class)->create();
	   }
	   
	   //$shop->ingredients()->attach(1, ['ingredients_amount' => 100, 'price' => 49.99]);
	   */
	}
}
