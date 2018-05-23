<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/5/21
 * Time: 13:54
 */

Route::get('/articles', 'ArticleController@all');
Route::get('/articles/{id}', 'ArticleController@detail');