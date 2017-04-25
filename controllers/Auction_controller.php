<?php
require "../model/Auction.php";

$command = $_REQUEST['command'];
$product_id = "";
$user_id = "";
$user_bid = "";

switch ($command) {
    case "makeBid": //http://37.57.92.40/trustme/controllers/auction_controller.php?command=makeBid&product_id=2&user_id=2&user_bid=50
        $product_id = $_REQUEST['product_id'];
        $user_id = $_REQUEST['user_id'];
        $user_bid = $_REQUEST['user_bid'];

        if ($product_id != "" && $user_id != "" && $user_bid != "") {

            $response = makeBid($product_id, $user_id, $user_bid);
        } else {
            $response = "null field";
        }
        break;
    case "showBidsByUser": //http://37.57.92.40/trustme/controllers/auction_controller.php?command=showBidsByUser&user_id=2
        $user_id = $_REQUEST['user_id'];

        if ($user_id != "") {
            $response = showBidsByUser($user_id);
        } else {
            $response = "null field";
        }
        break;
    case "showBidsByProduct": //http://37.57.92.40/trustme/controllers/auction_controller.php?command=showBidsByProduct&product_id=1
        $product_id = $_REQUEST['product_id'];

        if ($product_id != "") {
            $response = showBidsByProduct($product_id);
        } else {
            $response = "null field";
        }
        break;
    case "removeBid": //http://37.57.92.40/trustme/controllers/auction_controller.php?command=removeBid&product_id=2
        $product_id = $_REQUEST['product_id'];

        if ($product_id != "") {
            $response = removeBid($product_id);
        } else {
            $response = "null field";
        }
        break;
    default:
        $response = "failed command";
        break;
}
logging($product_id." ".$user_id." ".$user_bid." ",json_encode($response),$command);
echo json_encode($response);