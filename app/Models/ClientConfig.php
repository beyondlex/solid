<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/4/2
 * Time: 12:13
 */
namespace App\Models;

use Prettus\Repository\Contracts\Transformable;

/**
 * @property mixed client_id
 * @property mixed push_urls
 */
class ClientConfig extends MongodbModel implements Transformable
{


}