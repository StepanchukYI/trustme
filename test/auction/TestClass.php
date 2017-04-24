<?php

require '../Classss.php';
require '../phpunit-5.7.19.phar';
/**
 * Created by PhpStorm.
 * User: b0dun
 * Date: 24.04.2017
 * Time: 14:20
 */
class TestClass extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function test(){
        $new = new Classss();
        $this->assertEquals($new->Test(), 'test');
    }
}