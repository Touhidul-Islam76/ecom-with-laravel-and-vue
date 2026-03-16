<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->name();
        return [
            'category_id' => rand(1,10),
            'brand_id' => rand(1,10),
            'title' => $title,
            'slug' => Str::slug($title),
            'short_desc' => $this->faker->text(),
            'price' => rand(100,1000),
            'image'=> 'https://imgs.search.brave.com/n9E4WZN5ZrFV7FDagbbYzEjUrasw6s2Aw7hvYTPjCpI/rs:fit:500:0:1:0/g:ce/aHR0cHM6Ly90NC5m/dGNkbi5uZXQvanBn/LzA1LzgwLzExLzQz/LzM2MF9GXzU4MDEx/NDMyMF9QQ3RLYXFM/Qm1kZ3JCeWQ5bnJh/ZVZLdkZoemIyV3lM/MC5qcGc',
            'star' => rand(1,5),
            'remarks' => $this->faker->randomElement(['popular','featured','new','bestseller','trending']),
        ];
    }
}
