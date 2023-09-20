<?php

namespace Renatoxm\LaravelTicket\Tests\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Renatoxm\LaravelTicket\Models\Category;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name'       => $name = $this->faker->name(),
            'slug'       => Str::slug($name),
            'is_visible' => $this->faker->randomElement([true, false]),
        ];
    }
}
