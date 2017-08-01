<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 11/29/16
 * Time: 2:10 PM
 */

namespace execut\scheduler\widget;


use execut\yii\jui\Widget;

class Schedule extends Widget
{
    public $clientOptions = [];

    public function run()
    {
        $this->_registerBundle();
        $this->registerWidget();
        echo $this->_renderContainer(<<<HTML
<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:600px;'>
    <div class="dhx_cal_navline">
        <div class="dhx_cal_prev_button">&nbsp;</div>
        <div class="dhx_cal_next_button">&nbsp;</div>
        <div class="dhx_cal_today_button"></div>
        <div class="dhx_cal_date"></div>
        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
    </div>
    <div class="dhx_cal_header">
    </div>
    <div class="dhx_cal_data">
    </div>
</div>
HTML
);
    }
}