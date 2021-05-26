<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 15; $i++) {

            $newPost = new Post();
            $newPost->title = $faker->sentence();
            $newPost->date = $faker->date();
            $newPost->image = $faker->imageUrl(700, 530, "blog-post", true);
            $newPost->content = $faker->text();
            $newPost->published = rand(0, 1);
            $newPost->slug = Str::slug($newPost->title, "-");
            $newPost->save();
        }
    }
}