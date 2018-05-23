<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/5/21
 * Time: 13:55
 */
namespace Api\Frontend\Controllers;

use Api\Frontend\Models\Article;
use Api\Frontend\Repositories\ArticleRepository;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{

    /**
     * @var ArticleRepository
     */
    private $repository;

    public function __construct(ArticleRepository $repository) {

        $this->repository = $repository;
    }

    public function all()
    {
        return $this->pageResponse($this->repository->paginate(10));
    }

    public function detail($id)
    {
        $article = $this->repository->skipPresenter()->findWhere(['id'=>$id])->first();
        $article->content = html_entity_decode($article->content);

        return $this->objResponse($article);
    }
}