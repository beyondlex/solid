<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 06/03/2018
 * Time: 22:06
 */

namespace App\Extensions;

use League\Fractal\Serializer\ArraySerializer;

class DataSerializer extends ArraySerializer
{

	/**
	 * Serialize a collection.
	 *
	 * @param string $resourceKey
	 * @param array $data
	 *
	 * @return array
	 */
	public function collection($resourceKey, array $data)
	{
		if ($resourceKey) {
			return [$resourceKey => $data];
		}
		return $data;
	}

	/**
	 * Serialize an item.
	 *
	 * @param string $resourceKey
	 * @param array $data
	 *
	 * @return array
	 */
	public function item($resourceKey, array $data)
	{
		return $data;
	}

	/**
	 * Serialize null resource.
	 *
	 * @return array
	 */
	public function null()
	{
		return [];
	}

}