<?php

header("Content-Type:application/json");
require __DIR__ . "/../includes/functions.php";
if (!empty(filter_input(INPUT_GET, 'other'))) {
    $dbh = connect_to_db();
    $newsid = filter_input(INPUT_GET, 'newsid');

    $news = getOtherArticles($newsid, $dbh);
    deliver_response(200, "articles other found", $news);  
} else if (!empty(filter_input(INPUT_GET, 'newsid'))) {
    $dbh = connect_to_db();
    $newsid = filter_input(INPUT_GET, 'newsid');

    $news = getAnArticle($newsid, $dbh);
    deliver_response(200, "article found", $news);
} else {
    $dbh = connect_to_db();

    $news = fetchNews($dbh);
    deliver_response(200, "articles found", $news);
}

function deliver_response($status, $status_message, $data) {
    header("HTTP/1.1 $status $status_message");
    $response = array();
    $response["status"] = $status;
    $response["status_message"] = $status_message;
    $response["data"] = $data;

    $json_response = json_encode($response);
    echo $json_response;
}

?>