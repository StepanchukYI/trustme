<?php
require_once '../model/User.php';
require_once 'phpunit.phar';


/**
 * Created by PhpStorm.
 * User: b0dun
 * Date: 25.04.2017
 * Time: 15:19
 */
class TestCase extends PHPUnit_Framework_TestCase
{

    public function test_case()
    {
        $user = new User();
        $arr = array(
            'user_id' => '6',
            'email' => 'kalashnyk.denys@gmail.com',
            'email_2' => 'denys',
            'phone' => '380993414821',
            'password' => 'password',
            'name' => 'kalashnyk',
            'surname' => 'second@gmail.com',
            'birth_day' => '25',
            'birth_month' => '12',
            'birth_year' => '87',
            'sex' => '0',
            'facebook_id' => '',
            'google_id' => '',
            'multi_photo' => 'http://37.57.92.40/trustme/class/picture/user_photo/id6_small.jpeg',
            'mid_photo' => 'http://37.57.92.40/trustme/class/picture/user_photo/id6_medium.jpeg',
            'single_photo' => 'http://37.57.92.40/trustme/class/picture/user_photo/id6_large.jpeg',
            'loc_coords' => '',
            'time_zone' => '',
            'online_status' => '1',
            'reg_date' => '2017-04-15 11:04:30',
            'last_visit' => '2017-04-24 05:04:17',
            'balance' => '0',
            'rate' => '0',
            'country' => 'ukraine',
            'city' => 'dnepr',
            'temp_code' => '785451');
        $this->assertEquals($arr['user_id'], $user->Single_view_user(1, 6)['user_id']);
    }

}
