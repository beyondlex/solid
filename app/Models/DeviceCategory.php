<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Lex\Mongotree\TreeTrait;
use Prettus\Repository\Contracts\Transformable;

/**
 * @property mixed id
 * @property mixed name
 * @property mixed code
 * @property mixed parent_id
 */
class DeviceCategory extends MongodbModel implements Transformable
{
    //
	use TreeTrait;

	protected $fillable = [
		'name', 'code', 'parent_id',
	];

	function getLftName()
	{
		return 'lft';
	}

	function getRgtName()
	{
		return 'rgt';
	}

	public function transform()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'parent_id' => $this->parent_id,
            'lft' => $this->lft,
            'rgt' => $this->rgt,
        ];
    }

}
