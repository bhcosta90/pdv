<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\{Register, Store};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RegisterFactory extends Factory
{
    protected $model = Register::class;

    public function definition(): array
    {
        return [
            'store_id'   => Store::factory(),
            'code'       => str()->uuid(),
            'name'       => str($this->faker->unique()->lexify('???-??????'))->upper(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
