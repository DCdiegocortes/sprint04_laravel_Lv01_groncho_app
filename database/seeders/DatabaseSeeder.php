<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tu usuario principal para hacer login
        $me = User::factory()->create([
            'name' => 'dedee',
            'email' => 'dedee@test.com',
        ]);
        $me->universe()->create([
            'name' => 'Mermaidcore Dreamland',
            'description' => 'Texturas acuáticas, nácar y rosa perla.',
            'style' => 'mermaidcore',
        ]);
        Item::factory(5)->create(['user_id' => $me->id]);

        // 10 usuarios más, cada uno con universo y prendas
        User::factory(10)->create()->each(function ($user) {
            $user->universe()->create(
                \App\Models\Universe::factory()->make()->toArray()
            );
            Item::factory(rand(3, 6))->create(['user_id' => $user->id]);
        });
    }
}
