<?php
require_once '../auth_class/RAQ.php';
//require_once '../../model/Product.php';
require_once  __DIR__.'/../phpunit-5.7.19.phar';
/**
 * Created by PhpStorm.
 * User: b0dun
 * Date: 25.04.2017
 * Time: 22:46
 */
class Test_auth_case extends PHPUnit_Framework_TestCase
{
    /**@test */
    /**
     * @test
     * @dataProvider providerAuth
     */
    public function test_Auth($login,$password,$message){
        $this->assertEquals($message, Auth($login, $password));
    }

    public function providerAuth()
    {
        $array = array("Failed email or phone number", "Failed password");
        return array(
            array('', 'samepass', $arr = array('error' =>$array[0])),
            array('Somelogin', '', $arr = array('error' =>$array[1])),
            array("bodunjo855@gmail.com", "somepass",$arr = array('error' =>$array[1])),
            array("Somelogin", "somepass",$arr = array('error' =>$array[1])),
            array("bodunjo855@gmail.com", "rootttt1", $arr = array(   'user_id' => '1',
    'email' => 'bodunjo855@gmail.com',
    'email_2' => 'fsdfsd@mads.ru',
    'phone' => '80953866616',
    'password' => 'rootttt1',
    'name' => 'Evgeniy',
    'surname' => 'Stepanchuk',
    'birth_day' => '30',
    'birth_month' => '09',
    'birth_year' => '1996',
    'sex' => '1',
    'facebook_id' => '',
    'google_id' => '',
    'multi_photo' => 'http://37.57.92.40/trustme/class/picture/user_photo/id6_large.jpeg',
    'mid_photo' => 'http://37.57.92.40/trustme/class/picture/user#_photo/id6#_medium.jpeg',
    'single_photo' => 'http://37.57.92.40/trustme/class/picture/user#_photo/id6#_small.jpeg',
    'loc_coords' => '',
    'time_zone' => '',
    'online_status' => '1',
    'reg_date' => '0000-00-00 00:00:00',
    'last_visit' => '2017-05-06 04:05:58',
    'balance' => '0',
    'rate' => '0',
    'country' => 'Ucraine',
    'city' => 'Dnepro',
    'temp_code' => '964490')),

        );
    }

    /**
     * @test
     * @dataProvider providerRegistration_min
     */
    public function test_Registration_min_($login, $phone,$password,$message){
        $this->assertEquals($message, Registration_min($login, $phone,$password));
    }

    public function providerRegistration_min()
    {
        $array = array("Incorrect email", "Incorrect password","Incorrect phone","Email already using",
            "Phone already using");
        return array(
            array("email", "+38400", "somepass", $arr = array('error' =>$array[0])),
            array("email@", "+38400", "somepass", $arr = array('error' =>$array[0])),
            array("1@mail.ru", "+123456789", "",$arr = array('error' =>$array[1])),
            array("1@mail.ru", "+123456789", "some",$arr = array('error' =>$array[1])),
            array("1@mail.ru", "+123456789", "123456789012345678901234567890123", $arr = array('error' =>$array[1])),
            array("1@mail.ru", "+38400", "somepass",$arr = array('error' =>$array[2])),
            array("1@mail.ru", "+123456789", "some",$arr = array('error' =>$array[1])),
            array("1@mail.ru", "+1234567890123456", "somepass",$arr = array('error' =>$array[2])),
            array("bodunjo855@gmail.com",
                "01234567890", "somepass",$arr = array('error' =>$array[3])),
            array("one@gmail.com",
                "123456789012", "somepass",$arr = array('error' =>$array[3])),
            array("two@qwe.com",
                "0123456789012", "somepass",$arr = array('error' =>$array[3])),
            array("1@qwe.com", "380993414821", "somepass",$arr = array('error' =>$array[4])),
            array("2@qwe.com", "+380222222222", "somepass",$arr = array('error' =>$array[4])),
            array("3@qwe.com", "+380333333333", "somepass",$arr = array('error' =>$array[4]))
        );
    }

    /**
     * @test
     * @dataProvider providerQuit
     */
    public function test_Quit($id,$message){
        $this->assertEquals($message['user_id'], Quit($id)['user_id']);
    }

    public function providerQuit()
    {
        return array(
            array('1', array('user_id' => '1')),
            array('6', array('user_id' => '6')),
            array('17',array('user_id' => '17')),
         );
    }

}
