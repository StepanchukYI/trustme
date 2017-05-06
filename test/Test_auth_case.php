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
    public function test_Auth_null_login(){
        $array = array('error' => "Failed email or phone number");
    $this->assertEquals($array, Auth("", "samepass"));
}
    public function test_Auth_null_pass(){
        $array = array('error' => "Failed password");
        $this->assertEquals($array, Auth("Somelogin", ""));
    }
    public function test_Auth_error_login(){
        $array = array('error' => 'Failed password');
        $this->assertEquals($array, Auth("Somelogin", "somepass"));
    }
    public function test_Auth_error_pass(){
        $array = array('error' => "Failed password");
        $this->assertEquals($array , Auth("bodunjo855@gmail.com", "somepass"));
    }
    public function test_Auth_ok(){
        $array = array('user_id' => '1');
        $this->assertEquals($array['user_id'] , Auth("bodunjo855@gmail.com", "rootttt")['user_id']);
    }
    public function test_Registration_min_Inc_email(){
        $array = array('error' => "Incorrect email");
        $this->assertEquals($array, Registration_min("email", "+38400", "somepass"));
    }
    public function test_Registration_min_Inc_email2(){
        $array = array('error' => "Incorrect email");
        $this->assertEquals($array, Registration_min("email@", "+38400", "somepass"));
    }
    public function test_Registration_min_Inc_email3(){
        $array = array('error' => "Incorrect email");
        $this->assertEquals($array, Registration_min("", "+38400", "somepass"));
    }
    public function test_Registration_min_Inc_pass(){
        $array = array('error' => "Incorrect password");
        $this->assertEquals($array, Registration_min("1@mail.ru", "+123456789", ""));
    }
    public function test_Registration_min_Inc_pass2(){
        $array = array('error' => "Incorrect password");
        $this->assertEquals($array, Registration_min("1@mail.ru", "+123456789", "some"));
    }
    public function test_Registration_min_Inc_pass3(){
        $array = array('error' => "Incorrect password");
        $this->assertEquals($array, Registration_min("1@mail.ru", "+123456789",
            "123456789012345678901234567890123"));
    }
    public function test_Registration_min_Inc_phone(){
        $array = array('error' => "Incorrect phone");
        $this->assertEquals($array, Registration_min("1@mail.ru", "+38400", "somepass"));
    }
    public function test_Registration_min_Inc_phone2(){
        $array = array('error' => "Incorrect phone");
        $this->assertEquals($array, Registration_min("1@mail.ru",
            "+1234567890123456", "somepass"));
    }
    public function test_Registration_min_Inc_phone3(){
        $array = array('error' => "Incorrect phone");
        $this->assertEquals($array, Registration_min("1@mail.ru",
            "", "somepass"));
    }
    public function test_Registration_min_use_email(){
        $array = array('error' => "Email already using");
        $this->assertEquals($array, Registration_min("bodunjo855@gmail.com",
            "01234567890", "somepass"));
    }
    public function test_Registration_min_use_email2(){
        $array = array('error' => "Email already using");
        $this->assertEquals($array, Registration_min("one@gmail.com",
            "123456789012", "somepass"));
    }
    public function test_Registration_min_use_email3(){
        $array = array('error' => "Email already using");
        $this->assertEquals($array, Registration_min("two@qwe.com",
            "0123456789012", "somepass"));
    }
    public function test_Registration_min_use_phone1(){
        $array = array('error' => "Phone already using");
        $this->assertEquals($array, Registration_min("1@qwe.com",
            "380993414821", "somepass"));
    }
    public function test_Registration_min_use_phone2(){
        $array = array('error' => "Phone already using");
        $this->assertEquals($array, Registration_min("2@qwe.com",
            "+380222222222", "somepass"));
    }
    public function test_Registration_min_use_phone3(){
        $array = array('error' => "Phone already using");
        $this->assertEquals($array, Registration_min("3@qwe.com",
            "+380333333333", "somepass"));
    }
    public function test_Quit_ok(){
        $array = array('user_id' => '1');
        $this->assertEquals($array['user_id'] , Quit(1)['user_id']);
    }
    public function test_Quit_ok2(){
        $array = array('user_id' => '6');
        $this->assertEquals($array['user_id'] , Quit(6)['user_id']);
    }
    public function test_Quit_ok3(){
        $array = array('user_id' => '17');
        $this->assertEquals($array['user_id'] , Quit(17)['user_id']);
    }

}
