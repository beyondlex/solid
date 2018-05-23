<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2018/4/26
 * Time: 14:25
 */
namespace App\Repositories;

use App\Models\Vendor;

class VendorRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Vendor::class;
    }
}