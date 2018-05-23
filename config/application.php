<?php
/**
 * Created by PhpStorm.
 * User: doudou
 * Date: 2017/12/7
 * Time: 15:05
 */

return [
	'devices'=>[
		'locks'=>[
			'pstone'=>[//vendor code
				'base_url'=>env('PSTONE_BASE_URL'),
				'sid'=>env('PSTONE_SID'),
				'secret'=>env('PSTONE_SECRET'),
				'aes_secret'=>env('PSTONE_AES_SECRET'),
				'aes_iv'=>env('PSTONE_AES_IV'),

				//common configs for every device of each vendor:
//				'api_class'=>\App\Services\Device\Lock\PStone::class,
				'api_class'=> \Api\Pstone\Services\PStone::class,
			],
            'pstone2'=>[
                'base_url'=>env('PSTONE2_BASE_URL'),
                'sid'=>env('PSTONE2_SID'),
                'secret'=>env('PSTONE2_SECRET'),
                'aes_secret'=>env('PSTONE2_AES_SECRET'),
                'aes_iv'=>env('PSTONE2_AES_IV'),
                'api_class'=> \Api\Pstone\Services\PStone2::class,
            ],
            'zk'=>[
                'api_class'=> \Api\Zk\Services\Zk::class,
            ],
            'seal'=>[
                'server_ip'=>env('SEAL_SERVER_IP'),
                'mqtt_port'=>env('SEAL_MQTT_PORT', '8119'),
                'api_class'=> \Api\Seal\Services\Seal::class,
            ],
            'ywj'=>[
                'api_class'=> \Api\Ywj\Services\Ywj::class,
                'base_url'=> env('YWJ_BASE_URL'),
                'account'=> env('YWJ_ACCOUNT'),
                'secret'=> env('YWJ_SECRET')
            ],
            'hik'=>[
                'api_class'=> \Api\Hik\Services\FaceService::class,
                'base_url'=> env('HIK_BASE_URL'),
                'appkey'=> env('HIK_APPKEY'),
                'secret'=> env('HIK_SECRET')
            ]
		],
        'vendors'=>[

            'hik'=>[
                'server_ip'=>env('HIK_SERVER_IP'),
                'mqtt_port'=>env('HIK_MQTT_PORT', '1883'),
            ]
        ]
	],


    'face' => [

    	//client_id => [api_key, api_secret, faceset_code]

        '1' => [//curato
            'api_key' => 'C_T2KS3cCmxiyqBkS2TyvL-hlUJ1_sxP',
            'api_secret' => '6GTDdvnXIJS4s0WxqrqKPS5IwkutgIr4',
            'faceset_code' => 'Curato_Saas_',
        ],
        '2' => [//oola
            'api_key' => 'C_T2KS3cCmxiyqBkS2TyvL-hlUJ1_sxP',
            'api_secret' => '6GTDdvnXIJS4s0WxqrqKPS5IwkutgIr4',
            'faceset_code' => 'Oola_',
        ],
        '3' => [//zz
            'api_key' => 'C_T2KS3cCmxiyqBkS2TyvL-hlUJ1_sxP',
            'api_secret' => '6GTDdvnXIJS4s0WxqrqKPS5IwkutgIr4',
            'faceset_code' => 'Zz_',
        ],
        '4' => [//sy
            'api_key' => 'C_T2KS3cCmxiyqBkS2TyvL-hlUJ1_sxP',
            'api_secret' => '6GTDdvnXIJS4s0WxqrqKPS5IwkutgIr4',
            'faceset_code' => 'Sy_',
        ],
    ]
];