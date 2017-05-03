<?php

require_once __DIR__.'/../../model/Auction.php';
require_once __DIR__.'/../phpunit.phar';

class AuctionTest extends PHPUnit_Framework_TestCase
{

    /** @test
     * @dataProvider providerMakeBid
     * */
    public function test_Make_bid($product_id, $user_id, $user_bid, $message)
    {
        $auction = new Auction();
        $this->assertEquals($message, $auction->Make_bid($product_id, $user_id, $user_bid));
    }

    public function providerMakeBid()
    {
        $array = array("Failed product id", "Failed user id", "Incorrect bid amount", "Lot created");
        return array(
            array('', '', '', $array[0]),
            array('', '', '30', $array[0]),
            array('', '1', '', $array[0]),
            array('', '1', '50', $array[0]),
            array(1, '', '', $array[1]),
            array(1, '', '40', $array[1]),
            array(1, '1', '', $array[2]),
            array(2, '1', '20', $array[3])
        );
    }


    /** @test
     * @dataProvider providerRemoveBid
     * */
    public function test_Remove_bid($product_id, $message)
    {
        $auction = new Auction();
        $this->assertEquals($message, $auction->Remove_bid($product_id));
    }

    public function providerRemoveBid()
    {
        return array(
            array(1, "Wrong lot id"),
            array('', "Wrong lot id"),
            array('asdf', "Wrong lot id")
        );
    }


    /** @test
     * @dataProvider providerPerfectShowBidsByUser
     * */
    public function test_Perfect_Show_Bids_By_User($user_id, $response)
    {
        $auction = new Auction();
        $this->assertEquals($response, $auction->Show_bids_by_user($user_id)[0]);
    }

    public function providerPerfectShowBidsByUser()
    {
        $responseText = array(
            array("product_id"=>"3","user_bid"=>"140","bid_date"=>"2017-04-27 18:35:19","pt_small_photo"=>"ln","product_name"=>"Kettle","price"=>"500","max_bid"=>"20","auction_end"=>"2017-04-26 16:44:25"),
            array("product_id"=>"3","user_bid"=>"150","bid_date"=>"2017-04-27 18:35:30","pt_small_photo"=>"ln","product_name"=>"Kettle","price"=>"500","max_bid"=>"20","auction_end"=>"2017-04-26 16:44:25"),
            array("product_id"=>"3","user_bid"=>"160","bid_date"=>"2017-04-27 18:35:41","pt_small_photo"=>"ln","product_name"=>"Kettle","price"=>"500","max_bid"=>"20","auction_end"=>"2017-04-26 16:44:25")
        );
        return array(
            array(1, $responseText[0]),
            array(2, $responseText[1]),
            array(3, $responseText[2])
        );
    }

    /** @test
     * @dataProvider providerFailedShowBidsByUser
     * */
    public function test_Failed_Show_Bids_By_User($user_id, $response)
    {
        $auction = new Auction();
        $this->assertEquals($response, $auction->Show_bids_by_user($user_id));
    }

    public function providerFailedShowBidsByUser()
    {
        return array(
            array(999999, "NOTHING"),
            array(null, "Failed id"),
            array("", "Failed id")
        );
    }

    /** @test
     * @dataProvider providerPerfectShowBidsByProduct
     * */
    public function test_Perfect_Show_Bids_By_Product($product_id, $response)
    {
        $auction = new Auction();
        $this->assertEquals($response, $auction->Show_bids_by_product($product_id)[0]);
    }

    public function providerPerfectShowBidsByProduct()
    {
        $responseText = array(
            array("product_id"=>"1","user_bid"=>"50","bid_date"=>"2017-04-28 11:04:27","pt_small_photo"=>"kjh","product_name"=>"one","price"=>"100","max_bid"=>"10","auction_end"=>"2017-04-15 00:00:00"),
            array("product_id"=>"2","user_bid"=>"30","bid_date"=>"2017-04-28 12:38:16","pt_small_photo"=>"khj","product_name"=>"Kettle","price"=>"500","max_bid"=>"20","auction_end"=>"2017-04-26 16:44:25"),
            array("product_id"=>"3","user_bid"=>"140","bid_date"=>"2017-04-27 18:35:19","pt_small_photo"=>"ln","product_name"=>"Kettle","price"=>"500","max_bid"=>"20","auction_end"=>"2017-04-26 16:44:25"),
        );
        return array(
            array(1, $responseText[0]),
            array(2, $responseText[1]),
            array(3, $responseText[2]),
        );
    }

    /** @test
     * @dataProvider providerFailedShowBidsByProduct
     * */
    public function test_Failed_Show_Bids_By_Product($user_id, $response)
    {
        $auction = new Auction();
        $this->assertEquals($response, $auction->Show_bids_by_product($user_id));
    }

    public function providerFailedShowBidsByProduct()
    {
        return array(
            array(999999, "NOTHING"),
            array(null, "Failed id"),
            array("", "Failed id")
        );
    }
}

