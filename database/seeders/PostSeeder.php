<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 5; $i++) { 
            $post = \App\Models\Post::factory([
                'title' => 'Lorem Ipsum'.$i,
                'content' => $i.'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod consequat ex, nec tincidunt nunc efficitur id. Sed tristique tristique erat, eu tempor velit posuere et. Nunc bibendum libero ac lectus ullamcorper, sit amet aliquam tortor commodo. Nulla facilisi. In ultrices mi id dolor ultricies, non faucibus justo dignissim. Etiam commodo dapibus mauris, et pulvinar arcu bibendum eget. Aliquam aliquet rhoncus quam, id posuere turpis feugiat in. Donec varius, tortor eu ultrices gravida, ex neque rhoncus metus, sed iaculis erat enim at sem. Phasellus condimentum faucibus congue. Duis pretium odio lectus, eu posuere justo luctus in. Quisque vulputate elit nec cursus faucibus. In posuere iaculis turpis nec viverra.',
                'category_id' => Category::first()->id,
                'user_id' => User::where('role', 'blog')->first()->id,
            ])->create();
            $post->tags()->attach([1,2,3]);
        }
    }
}
