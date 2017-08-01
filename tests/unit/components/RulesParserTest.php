<?php
/**
 * Created by PhpStorm.
 * User: execut
 * Date: 2/20/17
 * Time: 4:37 PM
 */

namespace execut\scheduler\components;


class RulesParserTest extends \execut\TestCase
{
    public function testTest() {
        $rules = [
            'day_1___#no',
            'week_1___1,2,3,4,5,6#no',
        ];
        foreach ($rules as $rule) {
            $parser = new RulesParser([
                'rule' => $rule,
                'duration' => 3600,
                'startDate' => '2016-11-01 14:00:00',
                'currentDate' => '2016-12-02 16:00:00',
            ]);

            $parser->checkDate = '2016-12-02 14:30:00';
            $this->assertEquals(0, $parser->check());

            $parser->checkDate = '2016-12-02 13:30:00';
            $this->assertEquals(-1, $parser->check());

            $parser->checkDate = '2016-12-02 15:30:00';
            $this->assertEquals(1, $parser->check());
        }
    }
}