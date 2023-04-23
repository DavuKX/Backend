<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected string $model = State::class;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::factory()
            ->count(32)
            ->create();
    }
}
