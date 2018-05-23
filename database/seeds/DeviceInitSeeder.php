<?php

use Illuminate\Database\Seeder;
use Modules\Device\Models\Device;
use Modules\Device\Models\Vendor;

class DeviceInitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //client: id: 1, secret:..
		//vendor: code:pstone
		//device: client_id: 1, origin_id, vendor_id

        $data = [
            '1'=>[
                [
                    'code'=>'pstone',
                    'originId'=>'767ea41334b14df4b35733949fc2241a',
                    'name'=>'pstone-lock001',
                ],
            ],
            '2'=>[
                [
                    'code'=>'zk',
                    'originId'=>'AIO9180160472',
                    'name'=>'ZK-AIO9180160472',
                ]
            ]
        ];
        $created = $this->createData($data);
        var_dump($created);
    }

    function createData($data) {

        $devices = [];

        foreach ($data as $clientId=>$arr) {

            foreach ($arr as $d) {
                $client = \Laravel\Passport\Client::find($clientId);
                if (!$client) {
                    exit('client not exist');
                }

                $vendor = Vendor::where('code', '=', $d['code'])->first();

                if (!$vendor) {
                    $vendor = new Vendor();
                    $vendor->code = $d['code'];
                    $vendor->name = $d['code'];
                    $vendor->save();
                }

                $lockOriginId = $d['originId'];
                $device = Device::where('origin_id', '=', $lockOriginId)->first();

                if (!$device) {
                    $device = new Device();
                    $device->origin_id = $lockOriginId;
                    $device->name = $d['name'];
                    $device->vendor_id = $vendor->id;
                    $device->client_id = $clientId;
                    $device->save();

                    $devices[] = $device;
                }
            }
        }
        return $devices;
    }
}
