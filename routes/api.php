<?php

use Illuminate\Http\Request;
use Laravel\Passport\Client;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', function() {
	return 'Hi! world~';
});

Route::post('/sign', function() {
	$request = request();
	$post = $request->post();

	$path = $post['path'];
	unset($post['path']);

	$clientId = $request->header('clientId');
	$sign = $request->header('sign');

	$client = Client::find($clientId);

	$secret = $client->secret;
	$secret = 'hello';

	$params = $post;
	ksort($params);
	$str = '';
	foreach ($params as $k=>$v) {
		if (!$v) continue;
		if (!is_string($v)) continue;
		$str .= $k.'='.$v.';';
	}
//	        dd($str);
	$str = $secret. $str .$path;
//	dd($str);
	$signExpect = sha1($str);
	print_r($signExpect);


});
