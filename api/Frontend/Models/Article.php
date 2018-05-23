<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/5/21
 * Time: 13:56
 */
namespace Api\Frontend\Models;

use App\Models\MongodbModel;

class Article extends MongodbModel
{

    public function transform()
    {
        return [
            'id' => $this->id,
            'thumb' => $this->thumb,
            'title' => $this->title,
            'author' => $this->author,
            //'content' => $this->content,
            'published_at' => $this->published_at,
            'description' => $this->description,
        ];

    }
}