<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/5/21
 * Time: 14:01
 */
namespace Api\Frontend\Repositories;

use Api\Frontend\Models\Article;
use App\Repositories\Repository;

class ArticleRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Article::class;
    }
}