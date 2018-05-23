<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/2/6
 * Time: 17:48
 */
namespace App\Services;

use App\Models\Device;
use Modules\Device\Models\DevicePassword;

/** @method registerPushUrl($clientId, $url) */
interface LockInterface {

	/**
	 * 开
	 * @param $id
	 * @param $password
	 * @return mixed
	 */
	function unlock($id, $password);

	/**
	 * 关
	 * @return mixed
	 */
	function lock();

	/**
	 * 创建密码
	 * @param Device $device
	 * @param $data
	 * @return mixed
	 */
	function createPwd(Device $device, $data);

	/**
	 * 获取密码列表
	 * @param $id
	 * @return mixed
	 */
	function getPwdList($id);

	function getAttendanceRecords($lockId, $params=[]);
	function getAttendanceUsers($lockId);
	function rmAttendanceUser($lockOriginId, $userPin);

	/**
	 * 获取日志
	 * @param $id
	 * @return mixed
	 */
	function getLog($id);

	public function delPwd(Device $lock, DevicePassword $password);

	public function updatePwd(Device $lock, DevicePassword $password, $params);

    /**
     * 获取设备状态
     * @param Device $device
     * @return mixed
     */
	public function getStatus(Device $device);

}