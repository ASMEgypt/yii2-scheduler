<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 11/29/16
 * Time: 2:11 PM
 */

namespace execut\scheduler\widget;


use execut\yii\web\AssetBundle;
use yii\jui\JuiAsset;

class ScheduleAsset extends AssetBundle
{
    public $depends = [
        JuiAsset::class,
        SchedulerAsset::class,
    ];
}