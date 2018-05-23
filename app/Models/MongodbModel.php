<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/22
 * Time: 下午2:20
 */
namespace App\Models;

use App\Database\Traits\UuidForKey;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Eloquent\Model;
use Prettus\Repository\Contracts\Presentable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\PresentableTrait;

/**
 * Class BaseModel
 * @package App\Models
 *
 * @property mixed deleted_at
 * @property mixed updated_at
 * @property mixed created_at
 */
class MongodbModel extends Model implements Transformable , Presentable {


//	use UuidForKey;
	use PresentableTrait;
//	use SoftDeletes;

	protected $connection = 'mongodb';

	/**
	 * @return array
	 */
	public function transform()
	{
		// TODO: Implement transform() method.
		return [
			'id'=>$this->getKey(),
		];

	}
}