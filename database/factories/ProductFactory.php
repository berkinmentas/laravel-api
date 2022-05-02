<?php

namespace Database\Factories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $product_name = $this->faker->sentence(3);
        return [
            'name' => $product_name,
            'slug' => Str::slug($product_name),
            'description' => $this->faker->paragraph(5),
            'price' => mt_rand(10, 100)/10,
        ];
    }
}
