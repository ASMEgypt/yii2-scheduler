<?php
class m161123_075459_createEventsTable extends \execut\yii\migration\Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function initInverter(\execut\yii\migration\Inverter $i)
    {
        $i->table('scheduler_events')->create([
            'id' => $this->primaryKey(),
            'start_date' => $this->dateTime()->notNull(),
            'end_date' => $this->dateTime()->notNull(),
            'event_name' => $this->string(),
            'text' => $this->text(),
            'rec_type' => $this->string(),
            'event_length' => $this->integer(),
        ])
            ->addForeignColumn('scheduler_events');
    }
}
