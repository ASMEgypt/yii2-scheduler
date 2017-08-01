<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 11/25/16
 * Time: 10:25 AM
 */

namespace execut\scheduler\controllers;


use DHTMLX_Scheduler\Helper;
use yii\console\Controller;

class ConsoleController extends Controller
{
    public function actionIndex() {
        $helper = new Helper();
    }
}