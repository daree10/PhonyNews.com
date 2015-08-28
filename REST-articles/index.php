<?php

header("Content-Type:application/json");
if (!empty($_GET['name'])) {
    $name = $_GET["name"];
    $price = get_price($name);

    if (empty($price)) {
        deliver_response(200,"book not found INDEX", NULL);
    } else {
        deliver_response(200,"book found INDEX", $price);
    }
} else {
    deliver_response(400,"invalid request INDEX", NULL);
}

function deliver_response($status,$status_message,$data) {
    header("HTTP/1.1 $status $status_message");
    $response["status"]=$status;
    $response["status_message"]=$status_message;
    $response["data"]=$data;
    
    $json_response = json_encode($response);
    echo $json_response;
}

function get_price($find) {
    $books = array("java" => 299, "c" => 348, "php" => 267);

    foreach ($books as $book => $price) {
        if ($book == $find) {
            return $price;
        }
    }
}

?>
