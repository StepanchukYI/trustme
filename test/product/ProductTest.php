<?php

require_once __DIR__.'/../../model/Product.php';
require_once __DIR__.'/../phpunit.phar';
/**
 * Created by PhpStorm.
 * User: b0dun
 * Date: 24.04.2017
 * Time: 14:20
 */
class ProductTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider product_add_perfect_providerPower
     */
    /*
     * Тест на идеальные условия
     * */
    public function test_add_product_perfect($u_id, $p_name, $p_category, $p_price, $p_made_in, $p_description, $p_country, $p_city, $p_photo)
    {
        $product = new Product();
        $this->assertEquals(95, $product->Add_product($u_id, $p_name, $p_category, $p_price, $p_made_in, $p_description, $p_country, $p_city, $p_photo)['product_id']);
    }
    /*
     * Здесь нужно будет ещё дописать тесты, когда будут регулярки на вводимые непонятные спец символы в поля и всякую другую хрень
     * */
    public function product_add_perfect_providerPower()
    {
        return array(
            array(1, 'machine', 'texnika', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', ''),
        );
    }

    /**
     * @test
     * @dataProvider product_add_errors_providerPower
     */
    /*
     * Тест на ОШИБКИ при добавлении продукта
     * */
    public function test_add_product_errors($u_id, $p_name, $p_category, $p_price, $p_made_in, $p_description, $p_country, $p_city, $p_photo, $message)
    {
        $product = new Product();
        $this->assertEquals($message, $product->Add_product($u_id, $p_name, $p_category, $p_price, $p_made_in, $p_description, $p_country, $p_city, $p_photo));
    }

    /*
     * Здесь нужно будет ещё дописать тесты, когда будут регулярки на вводимые непонятные спец символы в поля и всякую другую хрень
     * */
    public function product_add_errors_providerPower()
    {
        $errArray = array('Incorrect product name','Incorrect product category','Incorrect product made in','Incorrect product description','Incorrect product country','Incorrect product city','Incorrect product price');
        return array(
            array(1, '', '', '', '', '', '', '', '', $errArray[0]),
            array(1, '', 'texnika', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', '', $errArray[0]),
            array(1, 'machine', '', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', '', $errArray[1]),
            array(1, 'machine', 'texnika', '', 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', '', $errArray[6]),
            array(1, 'machine', 'texnika', 10000, '', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', '', $errArray[2]),
            array(1, 'machine', 'texnika', 10000, 'Italy', '', 'ukraine', 'dnipro', '', $errArray[3]),
            array(1, 'machine', 'texnika', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '', 'dnipro', '', $errArray[4]),
            array(1, 'machine', 'texnika', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', '', '', $errArray[5])
        );
    }

    /**
     * @test
     * @dataProvider product_delete_providerPower
     */

    public function test_product_delete($p_id,$message){
        $product = new Product();
        $this->assertEquals($message,$product->Product_delete($p_id));
    }

    public function product_delete_providerPower()
    {
        $arr = array('Product successfully deleted','Failed to delete product');
        return array(
            array(174,$arr[0]),
            array(175,$arr[0]),
            array(176,$arr[0]),
        );
    }

    /**
     * @test
     */
    public function test_product_to_lot_perfect(){
        $arr = 'active';
        $product = new Product();
        $arrP_2_lot = array($product->Product_to_lot(42));
        $this->assertEquals($arr,$arrP_2_lot[0]['status']);
    }

    /**
     * @test
     */
    public function  test_product_to_lot_error(){
        $err = array('Failed to up product in auction');
        $product = new Product();
        $this->assertEquals($err,$product->Product_to_lot(null));
    }



    /**
     * @test
     * @dataProvider product_edit_providerPower
     */

    public function test_product_edit_perfect($product_id, $product_name, $category, $price, $made_in, $description, $product_country, $product_city, $product_photo, $message)
    {
        $product = new Product();
        $this->assertEquals($message, $product->Product_edit($product_id, $product_name, $category, $price, $made_in, $description, $product_country, $product_city, $product_photo));
    }

    public function product_edit_providerPower()
    {
        $message = 'Product_update';
        return array(
            array(42, 'machine', 'texnika', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', '', $message),
        );
    }

    /**
     * @test
     * @dataProvider product_edit_errors_providerPower
     */
    /*
     * Тест на ОШИБКИ при добавлении продукта
     * */
    public function test_product_edit_errors_0($p_id, $p_name, $p_category, $p_price, $p_made_in, $p_description, $p_country, $p_city, $p_photo, $message)
    {
        $product = new Product();
        $this->assertEquals($message, $product->Product_edit($p_id, $p_name, $p_category, $p_price, $p_made_in, $p_description, $p_country, $p_city, $p_photo));
    }

    /*
     * Здесь нужно будет ещё дописать тесты, когда будут регулярки на вводимые непонятные спец символы в поля и всякую другую хрень
     * */
    public function product_edit_errors_providerPower()
    {
        $errArray = array('Incorrect product name','Incorrect product category','Incorrect product made in','Incorrect product description','Incorrect product country','Incorrect product city','Incorrect product price');
        return array(
            array(1, '', '', '', '', '', '', '', '', $errArray[0]),
            array(1, '', 'texnika', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', '', $errArray[0]),
            array(1, 'machine', '', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', '', $errArray[1]),
            array(1, 'machine', 'texnika', '', 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', '', $errArray[6]),
            array(1, 'machine', 'texnika', 10000, '', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', 'dnipro', '', $errArray[2]),
            array(1, 'machine', 'texnika', 10000, 'Italy', '', 'ukraine', 'dnipro', '', $errArray[3]),
            array(1, 'machine', 'texnika', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '', 'dnipro', '', $errArray[4]),
            array(1, 'machine', 'texnika', 10000, 'Italy', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'ukraine', '', '', $errArray[5])
        );
    }

    /**
     * @test
     */
    public function test_owner_buyer_status(){
        $status = 'owner';
        $product = new Product();
        $this->assertEquals($status,$product->Owner_buyer_status(10));
    }

    /**
     * @test
     */
    public function test_owner_buyer_status_error(){
        $err = array('Failed to get owner/buyer status');
        $product = new Product();
        $this->assertEquals($err,$product->Owner_buyer_status(null));
    }

    /**
     * @test
     */
    public function test_product_singleview_perfect(){
        $arr = 'machine';
        $product = new Product();
        $arrP_2_lot = array($product->Product_singleview(10,42));
        $this->assertEquals($arr,$arrP_2_lot[0]['product_name']);
    }












}
