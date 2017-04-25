<?php

require_once '../Classss.php';
require_once '../phpunit.phar';

class TestClass extends PHPUnit_Framework_TestCase
{
    public function test(){
        $new = new Classss();
        $this->assertEquals($new->Test(), 'test');
    }
}