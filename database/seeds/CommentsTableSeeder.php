<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use App\Comment;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {   
        // Selecting only published posts
        $posts = Post::where("published", 1)->get();

        // Looping on posts
        foreach ($posts as $post) {

            // Looping n times to generate comments
            for ($i = 0; $i < rand(0, 5); $i++) {

                $newComment = new Comment();
                $newComment->post_id = $post->id;

                // In case of a nullable column
                if (rand(0, 1)) {
                    $newComment->name = $faker->name();
                }

                $newComment->content = $faker->text();
                $newComment->save();
            }
        }
    }
}