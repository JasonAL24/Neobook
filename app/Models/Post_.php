<?php

namespace App\Models;

class Post_
{
    private static $blog_posts = [
        [
            "title" => "Judul Post Pertama",
            "slug" => "judul-post-pertama",
            "author" => "Jason Aldeo",
            "body" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus ad animi consectetur cupiditate doloribus exercitationem harum magni nihil pariatur, sapiente sit soluta ut voluptate. At cupiditate est itaque nihil nisi. A alias corporis doloribus exercitationem ipsa minima nisi sed soluta. Aliquam atque cupiditate dolores ea et explicabo, harum illum impedit inventore ipsam iste iure iusto labore laudantium libero magnam molestias nesciunt nostrum officiis optio possimus, praesentium quasi quis ratione repellat repudiandae saepe sequi sint sunt tempore temporibus tenetur unde vero?"
        ],
        [
            "title" => "Judul Post Kedua",
            "slug" => "judul-post-kedua",
            "author" => "Doddy",
            "body" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad dolorum ipsum voluptatem. Architecto asperiores consectetur culpa itaque nostrum quam, recusandae vero. A accusamus aspernatur consectetur culpa cum dolores earum eligendi eos est eveniet fugiat id illum ipsam iste iure iusto laboriosam, laborum laudantium minima mollitia neque nihil perferendis quas qui quis quod repellendus saepe! Aspernatur earum, eveniet inventore maxime necessitatibus repellendus tempore velit voluptatibus. Asperiores, at atque deserunt doloremque dolorum eius, enim exercitationem facilis incidunt minima minus possimus quae quaerat quibusdam, recusandae soluta tempora vero. Aut corporis cupiditate delectus eaque fugit hic id laboriosam minus, molestiae, natus porro quae, rerum?"
        ]
    ];

    public static function all()
    {
        return collect(self::$blog_posts);
    }

    public static function find($slug)
    {
        $posts = static::all();

        return $posts->firstWhere('slug', $slug);
    }
}
