<?php

namespace App\Models;

use Prettus\Repository\Contracts\Transformable;

/**
 * @property mixed code
 * @property string name
 * @property Device[] devices
 */
class Vendor extends MongodbModel implements Transformable
{
    //

	protected $fillable = [
		'name', 'code'
	];

	public function devices() {
	    return $this->hasMany(Device::class);
    }

    public function transform()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
        ];
    }

}
