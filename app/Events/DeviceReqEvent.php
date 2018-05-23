<?php

namespace App\Events;

use App\Extensions\Traits\ClientTrait;
use App\Models\Device;
use App\Models\DeviceReqLog;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Support\Facades\Log;

/**
 * Class DeviceReqEvent
 * 设备请求事件
 * @package Modules\Device\Events
 */
class DeviceReqEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    use ClientTrait;


    public $logData;

    private $_action = [
        'create-pwd' => '创建密码',
        'unlock' => '远程开锁',
        'del-pwd' => '删除密码',
        'update-pwd' => '更新密码'
    ];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($action='', Device $device = null)
    {
        //设备请求事件触发时记录当前请求参数
		$request = request();

		$this->logData = [
			'input' => json_encode($request->all()),
			'path' => $request->getPathInfo(),
			'method' => $request->method(),
			'ip' => $request->ip(),
			'client_id' => $this->getClientId(),
			'action' => $action,
		];
		if ($device) {
			$this->logData['device'] = [
				'id' => $device->id,
				'cate_id' => $device->cate_id,
			];
		}

    }

    function saveLog() {
    	//保存设备请求日志到数据库（用队列处理），此动作在队列中由DeviceReqSubscriber.onDeviceReq触发
    	try {
			$log = new DeviceReqLog();
			$log->input = $this->logData['input'];
			$log->path = $this->logData['path'];
			$log->method = $this->logData['method'];
			$log->ip = $this->logData['ip'];
			$log->client_id = $this->logData['client_id'];
			$log->action = $this->logData['action'];
			$log->operator_type = $this->_action[$this->logData['action']] ?? '';
			if (isset($this->logData['device']) && $device = $this->logData['device']) {
				$log->device_category_id = $device['cate_id'];
				$log->device_id = $device['id'];
			}
			$saved = $log->save();
//			Log::info('save', [$saved, $log]);
		} catch (\Exception $e) {
//			file_put_contents(base_path().'/c.txt', $e->getMessage().date('Y-m-d H:i:s')."\n", FILE_APPEND);
			Log::error('device req log saving from queue failed.', [$e->getMessage()]);

		}

	}

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
