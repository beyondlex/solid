<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Jobs\TestJob;
use App\Mail\CommonMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});


\Laravel\Horizon\Horizon::auth(function(\Illuminate\Http\Request $request) {

    $auth = app(\Illuminate\Contracts\Auth\Factory::class);

    $auth->guard()->basic();

    return true;

});


Route::get('info', function () {
	echo phpinfo();exit;
});

Route::get('exception', function() {
	throw new \App\Exceptions\NotFoundException('h');
});

Route::get('mosquitto', function() {
	$c = new Mosquitto\Client;
	$reflection = new ReflectionClass(\Mosquitto\Client::class);
//	var_dump($reflection->getMethods());
	var_dump($reflection->getMethod('setWill')->__toString());
	exit;
	$c->onConnect(function() use ($c) {
		$c->publish('somebody_crying', 'a dog is crying', 0);
		$c->subscribe('somebody_laughing', 0);
		$c->disconnect();
	});

	$c->connect('127.0.0.1');
	$c->loopForever();

	echo "Finished\n";
});

Route::get('mail', function () {
	$body = "what life will \n be like 在未来";
	$to = 'beyondsnk@163.com';
	$subject = 'test';
	Mail::to($to)->send((new CommonMail($body))->subject($subject));
});


Route::get('queue', function() {
	dispatch(new \Modules\Device\Jobs\ClientReqLoggingJob());
});

Route::get('cat', function() {
	return Category::defaultOrder()->get()->toTree();
	$node = Category::where('name','=','root1-3')->first();
	$parent = Category::where('name','=','root1-2')->first();
	$parent->prependNode($node);
	Category::create([
		'name'=>'root1',
		'children'=> [
			[
				'name'=>'root1-1',
			],
			[
				'name'=>'root1-2',
				'children'=> [
					[
						'name'=>'1-2-1',
					],
					[
						'name'=>'1-2-2',
					]
				]
			],
			[
				'name'=>'root1-3',
			]
		]
	]);
});
Route::get('img', function() {
	$img = \Intervention\Image\Facades\Image::make('http://coolato:8080/storage/ads/0qbllw9BzZfZHynom11VjoKEEToyPnBBsTTbdfEr.jpeg');
	$img->resize(200, null, function ($constraint) {
		$constraint->aspectRatio();
	});
	return $img->response('jpeg');
});

/** @var \Dingo\Api\Routing\Router $api */
//$api = app('Dingo\Api\Routing\Router');
//
//$api->version('v1', function ($api) {
//
//	/** @var \Dingo\Api\Routing\Router $api */
//
//	$api->group(['prefix'=>'app'], function() use ($api) {
//		$api->group(['prefix'=>'devices/locks'], function() use ($api) {
//			$api->get('/', LockController::class.'@myLocks');
//			$api->post('{id}/actions/setPwd', LockController::class.'@setPwd');
//			$api->post('{id}/actions/unlock', LockController::class.'@unlock');
////			$api->get('{id}/passwords', LockController::class.'@pwdList');
//		});
//	});
//
//	$api->group(['prefix'=>'api'], function () use ($api) {
//
//		$api->post('mail', MsgController::class. '@sendMail');
//
//
//		$api->group(['prefix'=>'logs'], function() use ($api) {
//            $api->get('/', \App\Http\Controllers\MonologController::class.'@getAll');
//        });
//
//        //多媒体广告
//        $api->get('ads', AdController::class.'@all');//列表
//        $api->get('ads/{id}', AdController::class.'@one');//详情
//        $api->post('ads', AdController::class.'@create');//新增
//        $api->put('ads/{id}', AdController::class.'@update');//更新
//        $api->delete('ads/{id}', AdController::class.'@delete');//删除
//
//		//人脸
//        $api->post('faceset', FaceController::class.'@createFaceSet');//创建人脸库
//		$api->delete('faceset/{id}', FaceController::class.'@deleteFaceSet');//删除人脸库
//		$api->get('faceset/{id}', FaceController::class.'@faceSet');//人脸库详情
//		$api->post('faceset/{id}/face', FaceController::class.'@addFace');//添加人脸数据
//		$api->delete('faceset/{id}/face/{face_oken}', FaceController::class.'@removeFace');//抹除人脸数据
//        $api->post('faceset/{id}/actions/search', FaceController::class.'@searchFace');//匹配人脸
//
//		//签到
//		$api->post('signin', SignInController::class.'@signIn');//签到
//		$api->get('signin', SignInController::class.'@getSignInList');//签到列表
//		$api->get('signin/{id}', SignInController::class.'@getSignInInfo');//签到详情
//		$api->put('signin/{id}', SignInController::class.'@updateSignInInfo');//更新签到
//
//		//company
//		$api->post('companies', CompanyController::class.'@create');
//		$api->get('companies', CompanyController::class.'@all');
//		$api->get('companies/{id}', CompanyController::class.'@find');
//		$api->put('companies/{id}', CompanyController::class.'@update');
//		$api->delete('companies/{id}', CompanyController::class.'@delete');
//
//		//department
//		$api->post('departments', DepartmentController::class.'@create');
//		$api->get('departments', DepartmentController::class.'@all');
//		$api->get('departments/{id}', DepartmentController::class.'@find');
//		$api->put('departments/{id}', DepartmentController::class.'@update');
//		$api->delete('departments/{id}', DepartmentController::class.'@delete');
//
//		//level
//		$api->post('levels', LevelController::class.'@create');
//		$api->get('levels', LevelController::class.'@all');
//		$api->get('levels/{id}', LevelController::class.'@find');
//		$api->put('levels/{id}', LevelController::class.'@update');
//		$api->delete('levels/{id}', LevelController::class.'@delete');
//
//		//level
//		$api->post('roles', RoleController::class.'@create');
//		$api->get('roles', RoleController::class.'@all');
//		$api->get('roles/{id}', RoleController::class.'@find');
//		$api->put('roles/{id}', RoleController::class.'@update');
//		$api->delete('roles/{id}', RoleController::class.'@delete');
//
//		//staff
//		$api->post('staff', StaffController::class.'@create');
//		$api->get('staff', StaffController::class.'@all');
//		$api->get('staff/{id}', StaffController::class.'@find');
//		$api->put('staff/{id}', StaffController::class.'@update');
//		$api->delete('staff/{id}', StaffController::class.'@delete');
//
//
//
//
//    });
//
//});

////多媒体广告
//Route::get('/api/ads', function() {return 'hi';});//列表
//Route::get('/api/ads/{id}', 'AdController@one');//详情
//Route::post('/api/ads', 'AdController@create');//新增
//Route::put('/api/ads/{id}', 'AdController@update');//更新
//Route::delete('/api/ads/{id}', 'AdController@delete');//删除
Route::get('mongo', function () {
//	$model = new Category();
//	$model->name = 'cate1';
//	$model->depth = 0;
//	$model->path = null;
//	$model->save();
//	$cate = Category::find('5a4f272190c47a020713afb8');
//	$id = $cate->createSub('cate111');
//	dd($id);

//	$tree = Category::get()->toTree();
//	return $tree;

//	Category::create([
//		'name'=>'hi'
//	]);
//	exit();

	/** @var Category $cat */
//	$cat = Category::where('name', 'hi')->first();
//	$sub = new Category();
//	$sub->name = 'hi2';
//	$cat->appendNode($sub);
//	$cat->children()->create(['name'=>'hichildren']);
//	$cat->saveAsRoot();
//	$sub = new Category();
//	$sub->name = 'world';
//
//	$cat->appendNode($sub);

});
Route::get('log', function (\Faker\Generator $faker) {
//	    $mongodb = \Illuminate\Support\Facades\DB::connection('mongodb');
//	    $list = $mongodb->collection('monologs')->get();
//	    dd(unserialize($list[2]['context'][0]['data']['command']));
//	    $db = $mongodb->collection('products');
//	    $db->insert([
//	        'name'=>'Robot 3178',
//	        'power'=>13098,
//	        'age'=>384,
//	        'birth_day'=>'2099-01-09',
//	    ]);
//	    dd($db->get());

	//    $log = new \App\Monolog();
	//    $log->name = 'Robot 31';
	//    $log->save();

	//    var_dump(app('request')->get('hi'));
//	$class = new ReflectionClass(Log::class);
//	$methods = $class->getMethods();
//	dd($methods);

	Log::notice($faker->name(), ['name'=>$faker->name()]);
	Log::debug($faker->name(), ['name'=>$faker->name()]);

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
