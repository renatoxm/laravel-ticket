<?php

namespace Renatoxm\LaravelTicket\Tests\Database\Factories;

use Renatoxm\LaravelTicket\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $name = $this->faker->name(),
            'slug' => Str::slug($name),
            'is_visible' => $this->faker->randomElement([true, false]),
        ];
    }
}