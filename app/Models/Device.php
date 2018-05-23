<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;

/**
 * Class Device
 * @property mixed id
 * @property mixed name
 * @property Vendor vendor
 * @property mixed origin_id
 * @property mixed client_id
 * @property mixed status
 * @property mixed vendor_id
 * @property mixed category_id
 * @package Modules\Device\Models
 * @property mixed info
 *
 */
class Device extends MongodbModel implements Transformable
{
    use SoftDeletes;

    const STATUS_ON = 'online';
    const STATUS_OFF = 'offline';

	protected $fillable = [
		'name', 'origin_id',
	];

	function vendor() {
		return $this->belongsTo(Vendor::class);
	}

	function category() {
	    return $this->belongsTo(DeviceCategory::class);
    }

	function transform()
	{
		$data = [
			'id'=>$this->id,
			'sn'=>$this->origin_id,
			'name'=>$this->name,
			'status'=> $this->getStatus(),
            'vendor_code'=> isset($this->vendor->code) ? $this->vendor->code : '',
		];
		if ($this->info) {
		    $data['info'] = $this->info;
        }
		return $data;
	}

	function getStatus()
    {
        return '';
    }

}
