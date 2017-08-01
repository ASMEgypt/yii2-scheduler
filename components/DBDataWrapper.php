<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 11/30/16
 * Time: 4:02 PM
 */

namespace execut\scheduler\components;

use Dhtmlx\Connector\DataStorage\ArrayDBDataWrapper;
use Dhtmlx\Connector\DataStorage\ArrayQueryWrapper;

class DBDataWrapper extends ArrayDBDataWrapper {

    public function select($source) {
        $sourceData = $source->get_source();
        if(is_array($sourceData))	//result of find
            $res = $sourceData;
        else {
            $query = $sourceData::find();
            foreach ($source->get_filters() as $filter) {
                $query->andWhere([
                    $filter['operation'],
                    $filter['name'],
                    $filter['value'],
                ]);
            }

            $res = $query->all();
        }

        $temp = array();
        if(sizeof($res)) {
            foreach($res as $obj)
                $temp[] = $obj->getAttributes();
        }
        return new ArrayQueryWrapper($temp);
    }

    protected function getErrorMessage() {
        $errors = $this->connection->getErrors();
        $text = array();
        foreach($errors as $key => $value)
            $text[] = $key." - ".$value[0];

        return implode("\n", $text);
    }
    public function insert($data, $source) {
        $sourceObject = $source->get_source();
        if (is_array($sourceObject)) {
            $sourceObject = current($sourceObject);
        }

        $name = $sourceObject::className();
        $obj = new $name();
        $this->fill_model_and_save($obj, $data);
    }

    public function delete($data, $source) {
        $s = $source->get_source();
        $obj = $s::findOne($data->get_id());
        if($obj->delete()) {
            $data->success();
            $data->set_new_id($obj->getPrimaryKey());
        }
        else {
            $data->set_response_attribute("details", $this->errors_to_string($obj->getErrors()));
            $data->invalid();
        }
    }

    public function update($data, $source) {
        $s = $source->get_source();
        $obj = $s::findOne($data->get_id());
        $this->fill_model_and_save($obj, $data);
    }

    protected function fill_model_and_save($obj, $data) {
        //Map data to model object.
        for($i=0; $i < sizeof($this->config->text); $i++) {
            $step=$this->config->text[$i];
            $obj->setAttribute($step["name"], $data->get_value($step["name"]));
        }

        if($relation = $this->config->relation_id["db_name"])
            $obj->setAttribute($relation, $data->get_value($relation));

        //Save model.
        if($obj->save()) {
            $data->success();
            $data->set_new_id($obj->getPrimaryKey());
        }
        else {
            $data->set_response_attribute("details", $this->errors_to_string($obj->getErrors()));
            $data->invalid();
        }
    }

    protected function errors_to_string($errors) {
        $text = array();
        foreach($errors as $value)
            $text[] = implode("\n", $value);

        return implode("\n",$text);
    }

    public function escape($str) {
        throw new Exception("Not implemented");
    }

    public function query($str) {
        throw new Exception("Not implemented");
    }

    public function get_new_id() {
        throw new Exception("Not implemented");
    }
}