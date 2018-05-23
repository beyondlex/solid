<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 06/03/2018
 * Time: 21:28
 */
return [
    'pagination' => [
        'limit' => 10
    ],

	'fractal' => [
		'serializer' => \App\Extensions\DataSerializer::class,
	]
];