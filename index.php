<?php
set_time_limit(60000);

//$connect = file_get_contents("https://seffaflik.epias.com.tr/transparency/service/market/intra-day-trade-history?endDate=2022-02-07&startDate=2022-02-07");
$connect = file_get_contents("https://seffaflik.epias.com.tr/transparency/service/market/intra-day-trade-history?endDate=2022-01-26&startDate=2022-01-26");

function dates($code, $connect): array
{
    $json = json_decode($connect, true);

    $totalSales = [];
    $TotalTransactionAmount = [];
    $WeightedAveragePrice = [];
    foreach ($json["body"]["intraDayTradeHistoryList"] as $Item) { // veriler dönülüyor
        if (!strstr($Item["conract"], "PB")) { // PB koda sahib veriler listeden çıkartıldı..
            if (strstr($Item["conract"], "$code")) { // belli tarih te ki veri alınıyor
                $price = $Item["price"]; // ürün fiyatı
                $quantity = $Item["quantity"]; // adeti
                $total = ($price * $quantity) / 10; // toplama işlemi sırası öncelikle fiyatı ile adet çarpılarak kalan sonuç 10 bölünüyor
                $total2 = $quantity / 10; // toplam işlem miktarı adetin 10 bölünen sonucu
                $total3 = $total / $total2; // toplam işlem miktarını  toplam tutar sonucuna böldük
                $totalSales[] = $total; // toplam işlem tutarı foreach  döngsü dışına alındı
                $TotalTransactionAmount[] = $total2; // toplam işlem Miktarı foreach  döngsü dışına alındı
                $WeightedAveragePrice[] = $total3; // Ağırlıklı Ortalama Fiyat foreach  döngsü dışına alındı

            }
        }
    }

    return ["$code" => ["totalSales" => array_sum($totalSales), "TotalTransactionAmount" => array_sum($TotalTransactionAmount), "WeightedAveragePrice" => array_sum($WeightedAveragePrice)]];

//    print_r($data);
//
//    print_r(array_sum($totalSales)); // tüm adet ve fiyat toplamlarının sonucu alındı
//    echo "<br>";
//    print_r(array_sum($TotalTransactionAmount)); // tüm işlem miktarı sonucu toplandı
//    echo "<br>";
//    print_r(array_sum($WeightedAveragePrice)); // tüm ağırlıklı ortalama fiyat sonucu toplandı
//
//print_r(array_sum($totalSales)); // tüm adet ve fiyat toplamlarının sonucu alındı
//echo "<br>";
//print_r(array_sum($TotalTransactionAmount)); // tüm işlem miktarı sonucu toplandı
//echo "<br>";
//print_r(array_sum($WeightedAveragePrice)); // tüm ağırlıklı ortalama fiyat sonucu toplandı

}

function conractUniq($connect): array
{
    $json = json_decode($connect, true);
    $conract = [];
    foreach ($json["body"]["intraDayTradeHistoryList"] as $Item) { // veriler dönülüyor
        if (!strstr($Item["conract"], "PB")) { // PB koda sahib veriler listeden çıkartıldı..
            $conract[] .= $Item["conract"];
        }
    }

    return  array_unique($conract);
}



//$connract=["PH22012603","PH22012608","PH22012607","PH22012604"];
//echo "<pre>";
//$uniqArray=array_unique($connract);
//foreach ($uniqArray as $item) {
//
//    $data=array_unique(dates($item,$connect));
//    print_r($data);
//
//}


//exit();
//$data=dates("PH22012603",$connect);
//print_r($data);
//exit();

$conractUniq=conractUniq($connect);

foreach ($conractUniq as $Item) {
$data=dates($Item,$connect);

echo "<hr>";
echo "<h1> $Item </h1>";
print_r($data[$Item]["totalSales"]);
echo "<br>";
print_r($data[$Item]["TotalTransactionAmount"]);
echo "<br>";
print_r($data[$Item]["WeightedAveragePrice"]);
echo "<hr>";

}
