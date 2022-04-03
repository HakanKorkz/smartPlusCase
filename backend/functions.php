<?php

class functions
{

    /**
     * @param $code
     * @param $connect
     * @return array[]
     */
  private  function dates($code, $connect): array
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

    }

    /**
     * @param $connect
     * @return array
     */
    public function conractUniq($connect): array
    {
        $json = json_decode($connect, true);
        $conract = [];
        foreach ($json["body"]["intraDayTradeHistoryList"] as $Item) { // veriler dönülüyor
            if (!strstr($Item["conract"], "PB")) { // PB koda sahib veriler listeden çıkartıldı..
                $conract[] .= $Item["conract"];
            }
        }

        return array_unique($conract);
    }

    /**
     * @param $conractUniq
     * @param $connect
     * @return array
     */
   public function dataList ($conractUniq,$connect): array
    {
        $pack = [];
        if (count($conractUniq) > 0) {
            foreach ($conractUniq as $Item) {
                $data = $this->dates($Item, $connect);
                $date = "$Item[6]$Item[7]/$Item[4]$Item[5]/20$Item[2]$Item[3] $Item[8]$Item[9]:00";
                $pack[] = ["date" => $date, "totalSales" => $data[$Item]["totalSales"], "TotalTransactionAmount" => $data[$Item]["TotalTransactionAmount"], "WeightedAveragePrice" => $data[$Item]["WeightedAveragePrice"]];


            }

        } else {

            $pack[] = ["date" => "veri bulunamadı", "totalSales" => "veri bulunamadı", "TotalTransactionAmount" => "veri bulunamadı", "WeightedAveragePrice" => "veri bulunamadı"];

        }

        return $pack;

    }

}