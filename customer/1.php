<?php
      $RG_Lat=14.072639750957997;
      $RG_Lon=120.63198957481873;
         $json = "https://nominatim.openstreetmap.org/reverse?format=json&lat=".$RG_Lat."&lon=".$RG_Lon."&zoom=29"; 
      $ch = curl_init($json);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0");
      $jsonfile = curl_exec($ch);
      curl_close($ch);
      $RG_array = json_decode($jsonfile,true);
      echo $RG_array['display_name'];
?>

<?php
include 'ReverseLatlong.php';

print_r (LatLongAddres('14.073310991460506','120.6353549731956'));



