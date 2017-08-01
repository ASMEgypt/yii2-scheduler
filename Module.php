<?php
/**
 * User: execut
 * Date: 13.07.16
 * Time: 14:27
 */

namespace execut\scheduler;


use execut\importScheduler\models\Events;
use kartik\base\TranslationTrait;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'execut\scheduler\controllers';
    public $relatedModels = [
        'import_setting_id' => Events::class,
    ];
}