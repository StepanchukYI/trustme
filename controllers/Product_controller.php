<?php
require "../model/Product.php";

$command = $_GET['command'];

switch ($command) {
    case "add_product": //http://localhost/trustme/controllers/product_controller.php?command=add_product&user_id=1&product_name=Kettle&category=home&price=500&made_in=china&description=here_must_be_description&product_country=ukraine&product_city=dnipro&product_photo=photo_link
        $user_id = $_GET['user_id'];
        $product_name = $_GET['product_name'];
        $category = $_GET['category'];
        $price = $_GET['price'];
        $made_in = $_GET['made_in'];
        $description = $_GET['description'];
        $product_country = $_GET['product_country'];
        $product_city = $_GET['product_city'];
        $product_photo = $_GET['product_photo'];

        if ($user_id != "" && $product_name != "" && $category != "" && $price != "" && $made_in != "" && $description != "" && $product_country != ""
            && $product_city != "" && $product_photo != ""
        ) {
            echo Add_product($user_id, $product_name, $category, $price, $made_in, $description, $product_country, $product_city, $product_photo);
        } else {
            logging($user_id . " " . $product_name . " " . $category . " " . $price . " " . $price . " " . $made_in . " " . $description
                . " " . $product_country . " " . $product_city . " " . $product_photo, "null field",$command);
            echo "null field";
        }
        break;
    case "product_to_lot": //http://localhost/trustme/controllers/product_controller.php?command=product_to_lot&product_id=1
        $product_id = $_GET['product_id'];

        if ($product_id != "") {
            echo Product_to_lot($product_id);
        } else {
            logging($product_id . " ", "null field",$command);
            echo "null field";
        }
        break;
    case "product_delete": //http://localhost/trustme/controllers/product_controller.php?command=product_delete&product_id=1
        $product_id = $_GET['product_id'];

        if ($product_id != "") {
            echo Product_delete($product_id);
        } else {
            logging($product_id . " ", "null field",$command);
            echo "null field";
        }
        break;
    case "edit_product": //http://localhost/trustme/controllers/product_controller.php?command=edit_product&user_id=1&product_id=1&product_name=Kettle&category=home&price=500&made_id=china&description=here_must_be_description&product_country=ukraine&product_city=dnipro&product_photo=here_must_be_photo
        $user_id = $_GET['user_id'];
        $product_id = $_GET['product_id'];
        $product_name = $_GET['product_name'];
        $category = $_GET['category'];
        $price = $_GET['price'];
        $made_in = $_GET['made_in'];
        $description = $_GET['description'];
        $product_country = $_GET['product_country'];
        $product_city = $_GET['product_city'];
        $product_photo = $_GET['product_photo'];

        if ($user_id != "" && $product_id != "" && $product_name != "" && $category != "" && $price != "" && $made_in != "" && $description != "" && $product_country != ""
            && $product_city != "" && $product_photo != ""
        ) {
            echo Product_edit($user_id, $product_id, $product_name, $category, $price, $made_in, $description, $product_country, $product_city, $product_photo);
        } else {
            echo "null field";
        }
        break;
    case "product_search": //http://localhost/trustme/controllers/product_controller.php?command=product_search&product_id=1&query=kettle
        $product_id = $_GET['product_id'];
        $query = $_GET['query'];

        if ($product_id != "" && $query != "") {
            echo Product_search($product_id, $query);
        } else {
            logging($product_id . " " . $query, "null field",$command);
            echo "null field";
        }
        break;
    case "owner_buyer_status": //http://localhost/trustme/controllers/product_controller.php?command=owner_buyer_status&user_id=1
        $user_id = $_GET['user_id'];

        if ($user_id != "") {
            echo Owner_buyer_status($user_id);
        } else {
            logging($user_id, "null field",$command);
            echo "null field";
        }
        break;
    case "product_singleview": //http://localhost/trustme/controllers/product_controller.php?command=product_singleview&user_id=1&product_id=1
        $user_id = $_GET['user_id'];
        $product_id = $_GET['product_id'];

        if ($user_id != "" && $product_id != "") {
            echo Product_singleview($user_id, $product_id);
        } else {
            logging($product_id . " " . $product_id, "null field",$command);
            echo "null field";
        }
        break;
    case "product_multiview": //http://localhost/trustme/controllers/product_controller.php?command=product_multiview&user_id=1&product_id=1
        $user_id = $_GET['user_id'];
        $product_id = $_GET['product_id'];

        if ($user_id != "" && $product_id != "") {
            echo Product_multiview($user_id, $product_id);
        } else {
            logging($product_id . " " . $product_id, "null field",$command);
            echo "null field";
        }
        break;
    default:
        logging($command . " ", "failed command",$command);
        echo "failed command";
        break;
}