<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/4/25
 * Time: 16:02
 */
namespace App\Repositories;

use App\Models\DeviceCategory;

class DeviceCategoryRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return DeviceCategory::class;
    }
}