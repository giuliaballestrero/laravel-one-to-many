<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Type;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //definisco i types
        $types = ['Front-end', 'Back-end', 'Full-stack'];

        foreach ($types as $typeName) {
            $type = new Type();
            $type->name = $typeName;
            $type->color = $faker->unique()->hexColor();
            $type->save();
        }
    }
}
