<?php
require_once '../../auth_class/RAQ.php';
//require_once '../../model/Product.php';
//require_once '../phpunit.phar';
/**
 * Created by PhpStorm.
 * User: b0dun
 * Date: 25.04.2017
 * Time: 22:46
 */
class Test_auth_case extends PHPUnit_Framework_TestCase
{
    /**@test */
    public function test_Auth_null_login(){
    $this->assertEquals("Failed email or phone number", Auth("", "samepass"));
}
    public function test_Auth_null_pass(){
        $this->assertEquals("Failed password", Auth("Somelogin", ""));
    }
    public function test_Auth_error_login(){
        $this->assertEquals("Failed email or phone number", Auth("Somelogin", "somepass"));
    }
    public function test_Auth_error_pass(){
        $this->assertEquals("Failed password", Auth("bodunjo855@gmail.com", "somepass"));
    }
    public function test_Auth_ok(){
        $array = array(
    'user_id' => '1',
    'email' => 'bodunjo855@gmail.com',
    'email_2' => 'fsdfsd@mads.ru',
    'phone' => '80953866616',
    'password' => 'rootttt',
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
    'last_visit' => '2017-04-27 09:04:26',
    'balance' => '0',
    'rate' => '0',
    'country' => 'Ucraine',
    'city' => 'Dnepro',
    'temp_code' => '964490');
        $this->assertEquals($array['user_id'] , Auth("bodunjo855@gmail.com", "rootttt")[0]['user_id']);
    }
    public function test_Registration_min_Inc_email(){
        $this->assertEquals("Incorrect email", Registration_min("email", "+38400", "somepass"));
    }
    public function test_Registration_min_Inc_email2(){
        $this->assertEquals("Incorrect email", Registration_min("email@", "+38400", "somepass"));
    }
    public function test_Registration_min_Inc_email3(){
        $this->assertEquals("Incorrect email", Registration_min("", "+38400", "somepass"));
    }
    public function test_Registration_min_Inc_pass(){
        $this->assertEquals("Incorrect password", Registration_min("1@mail.ru", "+123456789", ""));
    }
    public function test_Registration_min_Inc_pass2(){
        $this->assertEquals("Incorrect password", Registration_min("1@mail.ru", "+123456789", "some"));
    }
    public function test_Registration_min_Inc_pass3(){
        $this->assertEquals("Incorrect password", Registration_min("1@mail.ru", "+123456789",
            "123456789012345678901234567890123"));
    }
    public function test_Registration_min_Inc_phone(){
        $this->assertEquals("Incorrect phone", Registration_min("1@mail.ru", "+38400", "somepass"));
    }
    public function test_Registration_min_Inc_phone2(){
        $this->assertEquals("Incorrect phone", Registration_min("1@mail.ru",
            "+1234567890123456", "somepass"));
    }
    public function test_Registration_min_Inc_phone3(){
        $this->assertEquals("Incorrect phone", Registration_min("1@mail.ru",
            "", "somepass"));
    }
    public function test_Registration_min_use_email(){
        $this->assertEquals("Email already using", Registration_min("bodunjo855@gmail.com",
            "01234567890", "somepass"));
    }
    public function test_Registration_min_use_email2(){
        $this->assertEquals("Email already using", Registration_min("one@gmail.com",
            "123456789012", "somepass"));
    }
    public function test_Registration_min_use_email3(){
        $this->assertEquals("Email already using", Registration_min("two@qwe.com",
            "0123456789012", "somepass"));
    }
    public function test_Registration_min_use_phone1(){
        $this->assertEquals("Phone already using", Registration_min("1@qwe.com",
            "380993414821", "somepass"));
    }
    public function test_Registration_min_use_phone2(){
        $this->assertEquals("Phone already using", Registration_min("2@qwe.com",
            "+380222222222", "somepass"));
    }
    public function test_Registration_min_use_phone3(){
        $this->assertEquals("Phone already using", Registration_min("3@qwe.com",
            "+380333333333", "somepass"));
    }
    public function test_Quit_ok(){
        $array = array('user_id' => '1');
        $this->assertEquals($array['user_id'] , Quit(1)[0]['user_id']);
    }
    public function test_Quit_ok2(){
        $array = array('user_id' => '6');
        $this->assertEquals($array['user_id'] , Quit(6)[0]['user_id']);
    }
    public function test_Quit_ok3(){
        $array = array('user_id' => '17');
        $this->assertEquals($array['user_id'] , Quit(17)[0]['user_id']);
    }


}
