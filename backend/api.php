<?php
set_time_limit(600);

require_once __DIR__."/functions.php";

$functions=new functions();

if (isset($_POST["startDate"])) {
    if (!empty($_POST["startDate"])) {
        $apiLink = "https://seffaflik.epias.com.tr/transparency/service/market/intra-day-trade-history?endDate=" . $_POST["startDate"] . "&startDate=" . $_POST["startDate"];
    } else {
        $apiLink = "https://seffaflik.epias.com.tr/transparency/service/market/intra-day-trade-history?endDate=2022-01-26&startDate=2022-01-26";
    }
} else {
    $apiLink = "https://seffaflik.epias.com.tr/transparency/service/market/intra-day-trade-history?endDate=2022-01-26&startDate=2022-01-26";
}
$connect = file_get_contents($apiLink);


$conractUniq = $functions->conractUniq($connect);



echo json_encode($functions->dataList($conractUniq,$connect));
exit();
