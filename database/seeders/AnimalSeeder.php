<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Category;
use App\Models\Characteristic;
use Illuminate\Database\Seeder;

class AnimalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure core categories exist
        $dogCategory   = Category::firstOrCreate(['name' => 'Dogs']);
        $catCategory   = Category::firstOrCreate(['name' => 'Cats']);
        $rabbitCategory = Category::firstOrCreate(['name' => 'Rabbits']);

        // 2. Core characteristics
        $friendly = Characteristic::firstOrCreate(['name' => 'Friendly']);
        $energetic = Characteristic::firstOrCreate(['name' => 'Energetic']);
        $calm     = Characteristic::firstOrCreate(['name' => 'Calm & Quiet']);
        $trained  = Characteristic::firstOrCreate(['name' => 'House-trained']);

        // 3. Seed Dogs
        $buddy = Animal::create([
            'name'        => 'Buddy',
            'category_id' => $dogCategory->id,
            'breed'       => 'Golden Retriever',
            'age'         => 3,
            'description' => 'A very playful dog who loves playing fetch and running around in large open yards.', // 🌟 Added description
        ]);
        $buddy->characteristics()->sync([$friendly->id, $energetic->id, $trained->id]);

        $bella = Animal::create([
            'name'        => 'Bella',
            'category_id' => $dogCategory->id,
            'breed'       => 'German Shepherd',
            'age'         => 2,
            'description' => 'A loyal and intelligent protective companion who excels at learning advanced tricks.', // 🌟 Added description
        ]);
        $bella->characteristics()->sync([$friendly->id, $calm->id]);

        // 4. Seed Cats
        $milo = Animal::create([
            'name'        => 'Milo',
            'category_id' => $catCategory->id,
            'breed'       => 'Siamese Cat',
            'age'         => 1,
            'description' => 'An active, curious kitten who loves tracking toy mice and climbing up high cat towers.', // 🌟 Added description
        ]);
        $milo->characteristics()->sync([$energetic->id]);

        $whiskers = Animal::create([
            'name'        => 'Whiskers',
            'category_id' => $catCategory->id,
            'breed'       => 'Tabby Cat',
            'age'         => 5,
            'description' => 'A relaxed, independent lap cat content with sleeping next to sun-lit windows all day.', // 🌟 Added description
        ]);
        $whiskers->characteristics()->sync([$calm->id, $trained->id]);

        // 5. Seed Rabbit
        $snowball = Animal::create([
            'name'        => 'Snowball',
            'category_id' => $rabbitCategory->id,
            'breed'       => 'Angora Rabbit',
            'age'         => 1,
            'description' => 'An incredibly soft, calm bunny who loves snacking on fresh leafy greens and carrots.', // 🌟 Added description
        ]);
        $snowball->characteristics()->sync([$friendly->id, $calm->id]);
    }
}