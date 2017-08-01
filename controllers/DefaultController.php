<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 11/23/16
 * Time: 9:08 AM
 */

namespace execut\scheduler\controllers;


use Dhtmlx\Connector\SchedulerConnector;
use Dhtmlx\Connector\Tools\LogMaster;
use DHTMLX_Scheduler\SchedulerHelperConnector;
use execut\actions\Action;
use execut\importScheduler\models\ImportSettingsVsSchedulerEvents;
use execut\scheduler\actions\adapter\Schedule;
use execut\scheduler\components\DBDataWrapper;
use execut\scheduler\models\SchedulerEvents;
use execut\navigation\behaviors\Navigation;
use execut\navigation\behaviors\navigation\Page;
use yii\web\Controller;
use yii\filters\AccessControl;

class DefaultController extends Controller
{
//    protected $_roles = ['schedule_manager'];
//    public function behaviors()
//    {
//        $pages = [
//            [
//                'class' => Page::className(),
//                'params' => [
//                    'url' => [
//                        '/'
//                    ],
//                    'name' => 'Home page',
//                    'header' => 'Home page',
//                    'title' => 'Home page',
//                ],
//            ],
//            [
//                'class' => Page::className(),
//                'params' => [
//                    'url' => [
//                        '/' . $this->getUniqueId() . '/index',
//                    ],
//                    'name' => 'Schedule',
//                    'header' => 'Schedule',
//                    'title' => 'Schedule',
//                ],
//            ],
//        ];
//
//        return array_merge([
//            'navigation' => [
//                'class' => Navigation::className(),
//                'pages' => $pages,
//            ],
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['@'],
//                        'matchCallback' => function () {
//                            $hasAccess = false;
//                            foreach ($this->_roles as $role) {
//                                if (\yii::$app->authManager->checkAccess(\yii::$app->user->identity->id, $role)) {
//                                    $hasAccess = true;
//                                    break;
//                                }
//                            }
//
//                            return $hasAccess;
//                        }
//                    ],
//                ],
//            ],
//        ],
//            parent::behaviors()
//        );
//    }

    public function actions()
    {
        return [
            'index' => [
                'class' => Action::className(),
                'adapter' => [
                    'class' => Schedule::className(),
                ],
            ],
        ];
    }

    protected static $ids = [];
    public function actionData()
    {
        LogMaster::enable_log(\yii::getAlias('@runtime/scheduler.log'));
        $relatedAttributes = [
            'importSettingId' => [
                'class' => ImportSettingsVsSchedulerEvents::className(),
                'key' => 'import_setting_id',
            ],
        ];

        $relatedAttributesString = implode(',', array_keys($relatedAttributes));

        new DBDataWrapper();
        $scheduler = new SchedulerConnector(SchedulerEvents::className(), DBDataWrapper::class);
        $scheduler->configure(SchedulerEvents::className(), "id", "start_date,end_date,text,rec_type,scheduler_event_id,event_length,color,$relatedAttributesString");
        foreach ($relatedAttributes as $attribute) {
            $relatedValues = \yii::$app->getRequest()->getQueryParam($attribute['key']);
            if (empty($relatedValues)) {
                continue;
            }

            $class = $attribute['class'];
            $subQuery = $class::find()->where([
                $attribute['key'] => $relatedValues,
            ]);
            $scheduler->filter('id', $subQuery->queryAttribute('scheduler_event_id'), 'IN');
        }

        $scheduler->render();
    }
}