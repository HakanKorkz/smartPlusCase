<?php
require_once __DIR__ . "/connect.php";
date_default_timezone_set('Europe/Istanbul');
$con = file_get_contents("https://seffaflik.epias.com.tr/transparency/service/market/intra-day-trade-history?endDate=2022-01-26&startDate=2022-01-26");
$json = json_decode($con, true);
$totalSales = [];
$TotalTransactionAmount = [];
$WeightedAveragePrice = [];
foreach ($json["body"]["intraDayTradeHistoryList"] as $Item) { // veriler dönülüyor
    echo "<pre>";
    if (!strstr($Item["conract"], "PB")) { // PB koda sahib veriler listeden çıkartıldı..
        if (strstr($Item["conract"], "PH22012603")) { // belli tarih te ki veri alınıyor
            echo "Fiyat: " . $price = $Item["price"]; // ürün fiyatı
            echo "<br>";
            echo "Adet: " . $quantity = $Item["quantity"]; // adeti
            echo "<br>";
            echo "<hr>";
            echo "Toplam İşlem Tutarı: " . $total = ($price * $quantity) / 10; // toplama işlemi sırası öncelikle fiyatı ile adet çarpılarak kalan sonuç 10 bölünüyor
            echo "<br>";
            echo "Toplam İşlem Miktarı: " . $total2 = $quantity / 10; // toplam işlem miktarı adetin 10 bölünen sonucu
            echo "<br>";
            echo "Ağırlıklı Ortalama Fiyat: " . $total3 = $total2 / $total; // toplam işlem miktarını  toplam tutar sonucuna böldük
            echo "<hr>";
            $totalSales[] = $total; // toplam işlem tutarı foreach  döngsü dışına alındı
            $TotalTransactionAmount[] = $total2; // toplam işlem Miktarı foreach  döngsü dışına alındı
            $WeightedAveragePrice[] = $total3; // Ağırlıklı Ortalama Fiyat foreach  döngsü dışına alındı
        }
    }

    echo "</pre>";
}
echo "<pre>";
//print_r($r);

print_r(array_sum($totalSales)); // tüm adet ve fiyat toplamlarının sonucu alındı
echo "<br>";
print_r(array_sum($TotalTransactionAmount)); // tüm işlem miktarı sonucu toplandı
echo "<br>";
print_r(array_sum($WeightedAveragePrice)); // tüm ağırlıklı ortalama fiyat sonucu toplandı
//print_r(array_sum($r)/83);

//echo $r[0]+$r[1];


//
//$con = connect("https://seffaflik.epias.com.tr/transparency/service/market/intra-day-trade-history?endDate=2022-01-26&startDate=2022-01-26");
//
//
//$xml = simplexml_load_string($con) or die("Error: Cannot create object");
//
//
//print_r($xml);

//exit();
//$xml=simplexml_load_string("https://seffaflik.epias.com.tr/transparency/service/market/intra-day-trade-history?endDate=2022-01-26&startDate=2022-01-26") or die("Error: Cannot create object");
//print_r($xml);
//foreach ($xml as $x) {
//    echo $x;
//    echo "<hr>";
//}
