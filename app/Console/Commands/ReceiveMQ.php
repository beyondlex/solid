<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Api\Hik\Models\HkCallbacks;
use GuzzleHttp\Client;
use App\Models\Device;

class receiveMQ extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receiveMQ:face';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'monitor face events';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tcp = $this->ask('Please enter your TCP address (format:tcp://192.168.0.1:61613) :');
        // 确认输入的tcp是否正确
        if ($this->confirm('your TCP address is ' . $tcp . ' , ok? [y|N]')) {
            if ($device = Device::where(['tcp'=>$tcp])->first()) {
                $device_id = $device->_id;
            } else {
                echo "hey man，该tcp地址没有和任何设备绑定哦，你确定输入正确了吗？请找foven\n";exit;
            }
            try {
                $stomp = new \Stomp($tcp);
            } catch (StompException $e) {
                die('Connection failed: ' . $e->getMessage());
            }

            //订阅队列消息
            $stomp->subscribe('/topic/openapi.fas.topic');

            do {
                if ($stomp->hasFrame()) {
                    $frame = $stomp->readFrame();
                    //进行相应的业务逻辑
                    $data = $frame->body;

                    //人脸比对报警事件相关操作
                    if (strpos($data, '人脸比对报警')) {
                        //获取设备上的姓名和id图片地址
                        $data = trim($data);
                        $result = json_decode(substr($data, strpos($data, '{'), -1), true);
                        $fdId = $result['faces'][0]['fdId'];
                        $human_id = $result['faces'][0]['human_id'];
                        $person_name = $result['faces'][0]['humanAttr']['name'];
                        $person_sex = $result['faces'][0]['humanAttr']['sex'];
                        $person_certificateType = $result['faces'][0]['humanAttr']['certificateType'];
                        $person_certificateNumber = $result['faces'][0]['humanAttr']['certificateNumber'];
                        $person_birthDate = $result['faces'][0]['humanAttr']['birthDate'];
                        $provinceID = $result['faces'][0]['humanAttr']['provinceID'];
                        $cityID = $result['faces'][0]['humanAttr']['cityID'];
                        $face_img = $result['snap']['faceSnap'];
                        $big_img = $result['snap']['snapPic'];
                        //向所有订阅该事件的回调地址发送请求
                        $client = new Client();
                        $HKCallbacks_result = HkCallbacks::where('type','face')->get()->toArray();
                        $data = [
                            'action' => '001',
                            'message' => '人脸比对报警事件',
                            'device_id' => $device_id,
                            'data' => [
                                'group_id' => $fdId,
                                'human_id' => $human_id,
                                'person_name' => $person_name,
                                'person_sex' => $person_sex,
                                'person_certificateType' => $person_certificateType,
                                'person_certificateNumber' => $person_certificateNumber,
                                'person_birthDate' => $person_birthDate,
                                'provinceID' => $provinceID,
                                'cityID' => $cityID,
                                'face_img' => $face_img,
                                'big_img' => $big_img
                            ]
                        ];

                        foreach ($HKCallbacks_result as $v) {
                            if (($v['events'] & '001') != '001') continue;
                            $header = [
                                'Content-Type'=>'application/json',
                                'auth_code'=>$v['auth_code']
                            ];
                            try {
                                $client->post(
                                    $v['url'],
                                    [
                                        'headers'=> $header,
                                        'body'=>json_encode($data),
                                    ]
                                );
                            } catch (\Exception $e) {}
                        }
                        $stomp->ack($frame);
                        continue;
                    } elseif (strpos($data, '人脸抓拍')) { //人脸抓拍事件相关操作
                        $str = trim($data);
                        $start = strpos($str, '<PicUrl>') + 8;
                        $length = strpos($str, '</PicUrl>') - $start;
                        $result = substr($str, $start, $length);
                        $result = explode(';', $result);
                        $face_img = $result[0];
                        $big_img = $result[1];
                        $data = [
                            'action' => '100',
                            'message' => '人脸抓拍事件',
                            'device_id' => $device_id,
                            'data' => [
                                'face_img' => $face_img,
                                'big_img' => $big_img
                            ]
                        ];

                        //向订阅人脸抓拍的回调发送事件
                        $client = new Client();
                        $HKCallbacks_result = HkCallbacks::where('type','face')->get()->toArray();
                        foreach ($HKCallbacks_result as $v) {
                            if (($v['events'] & '100') != '100') continue;
                            $header = [
                                'Content-Type'=>'application/json',
                                'auth_code'=>$v['auth_code']
                            ];
                            try {
                                $client->post(
                                    $v['url'],
                                    [
                                        'headers'=> $header,
                                        'body'=>json_encode($data),
                                    ]
                                );
                            } catch (\Exception $e) {}
                        }
                        $stomp->ack($frame);
                        continue;
                    } elseif (strpos($data, '陌生人报警')) { //陌生人报警事件相关操作
                        //获取设备上的姓名和id图片地址
                        $data = trim($data);
                        $result = json_decode(substr($data, strpos($data, '{'), -1), true);
                        $face_img = $result['snap']['faceSnap'];
                        $big_img = $result['snap']['snapPic'];
                        //向所有订阅该事件的回调地址发送请求
                        $client = new Client();
                        $HKCallbacks_result = HkCallbacks::where('type','face')->get()->toArray();
                        $data = [
                            'action' => '010',
                            'message' => '陌生人报警事件',
                            'device_id' => $device_id,
                            'data' => [
                                'face_img' => $face_img,
                                'big_img' => $big_img
                            ]
                        ];

                        foreach ($HKCallbacks_result as $v) {
                            if (($v['events'] & '010') != '010') continue;
                            $header = [
                                'Content-Type'=>'application/json',
                                'auth_code'=>$v['auth_code']
                            ];
                            try {
                                $client->post(
                                    $v['url'],
                                    [
                                        'headers'=> $header,
                                        'body'=>json_encode($data),
                                    ]
                                );
                            } catch (\Exception $e) {}
                        }
                        $stomp->ack($frame);
                        continue;
                    } else {
                        //不是人脸抓拍、人脸比对报警、陌生人报警的人脸事件
                        $stomp->ack($frame);
                        continue;
                    }
                }
                //模拟延迟
                sleep(1);
            } while (true);

        } else {
            echo 'Please enter the correct TCP and try again';exit;
        }

        return;
    }

}
