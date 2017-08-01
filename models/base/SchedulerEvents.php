<?php

namespace execut\scheduler\models\base;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "scheduler_events".
 *
 * @property integer $id
 * @property string $start_date
 * @property string $end_date
 * @property string $event_name
 * @property string $text
 * @property string $rec_type
 * @property integer $event_length
 * @property integer $scheduler_event_id
 *
 * @property \execut\scheduler\models\ImportSettingsVsSchedulerEvents[] $importSettingsVsSchedulerEvents
 * @property \execut\scheduler\models\SchedulerEvents $schedulerEvent
 * @property \execut\scheduler\models\SchedulerEvents[] $schedulerEvents
 */
class SchedulerEvents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scheduler_events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['start_date', 'end_date'], 'required'],
            [['start_date', 'end_date'], 'safe'],
            [['text'], 'string'],
            [['event_length', 'scheduler_event_id'], 'integer'],
            [['event_name', 'rec_type'], 'string', 'max' => 255],
            [['scheduler_event_id'], 'exist', 'skipOnError' => true, 'targetClass' => SchedulerEvents::className(), 'targetAttribute' => ['scheduler_event_id' => 'id']],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'id' => Yii::t('execut.scheduler.models.base.SchedulerEvents', 'ID'),
            'start_date' => Yii::t('execut.scheduler.models.base.SchedulerEvents', 'Start Date'),
            'end_date' => Yii::t('execut.scheduler.models.base.SchedulerEvents', 'End Date'),
            'event_name' => Yii::t('execut.scheduler.models.base.SchedulerEvents', 'Event Name'),
            'text' => Yii::t('execut.scheduler.models.base.SchedulerEvents', 'Text'),
            'rec_type' => Yii::t('execut.scheduler.models.base.SchedulerEvents', 'Rec Type'),
            'event_length' => Yii::t('execut.scheduler.models.base.SchedulerEvents', 'Event Length'),
            'scheduler_event_id' => Yii::t('execut.scheduler.models.base.SchedulerEvents', 'Scheduler Event ID'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImportSettingsVsSchedulerEvents()
    {
        return $this->hasMany(\execut\scheduler\models\ImportSettingsVsSchedulerEvents::className(), ['scheduler_event_id' => 'id'])->inverseOf('schedulerEvent');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedulerEvent()
    {
        return $this->hasOne(\execut\scheduler\models\SchedulerEvents::className(), ['id' => 'scheduler_event_id'])->inverseOf('schedulerEvents');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedulerEvents()
    {
        return $this->hasMany(\execut\scheduler\models\SchedulerEvents::className(), ['scheduler_event_id' => 'id'])->inverseOf('schedulerEvent');
    }
}
