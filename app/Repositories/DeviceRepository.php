<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 2017/12/15
 * Time: 上午11:58
 */

namespace App\Repositories;


use App\Criterias\RequestCriteria;
use App\Models\Device;
use Prettus\Repository\Presenter\ModelFractalPresenter;

class DeviceRepository extends Repository
{

    protected $fieldSearchable = [
        'name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Device::class;
    }

    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return ModelFractalPresenter::class;
    }
}