<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 11/29/16
 * Time: 2:11 PM
 */

namespace execut\scheduler\widget;

use yii\web\AssetBundle;
use yii\web\View;

class SchedulerAsset extends AssetBundle
{
    public $sourcePath = '@vendor/execut/yii2-scheduler/src';
    public $css = [
        'codebase/dhtmlxscheduler.css',
    ];

    public $js = [
        'codebase/dhtmlxscheduler.js',
        'codebase/ext/dhtmlxscheduler_recurring.js',
        'codebase/ext/dhtmlxscheduler_multiselect.js',
        'codebase/ext/dhtmlxscheduler_editors.js',
    ];
}