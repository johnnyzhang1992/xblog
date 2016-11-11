<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*\App\User::truncate();*/
        \App\Post::truncate();
        \App\Category::truncate();
        \App\Tag::truncate();
        Model::unguard();
        factory(App\Category::class)->create(['name' => 'Android']);
        factory(App\Category::class)->create(['name' => 'Java']);
        factory(App\Category::class)->create(['name' => 'Php']);
        factory(App\Category::class)->create(['name' => 'Spring']);
        factory(App\Category::class)->create(['name' => 'Laravel']);
        factory(App\Category::class)->create(['name' => 'Vue']);
        factory(App\Category::class)->create(['name' => 'Js']);
        factory(App\Tag::class, 10)->create();
        $tag_ids = \App\Tag::all();
        factory(App\User::class, 10)->create()->each(function ($u) use ($tag_ids) {
            factory(App\Post::class, mt_rand(0, 10))->make(
                ['category_id' => mt_rand(1, 7)]
            )->each(function ($post) use ($u, $tag_ids) {
                $p = $u->posts()->save($post);
                $count = mt_rand(1, 4);
                $ids = [];
                for ($i = 0; $i < $count; $i++) {
                    array_push($ids, $tag_ids[mt_rand(1, 9)]->id);
                }
                $p->tags()->sync($ids);
            });

        });
    }
}
