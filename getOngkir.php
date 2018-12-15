<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "origin=".$_POST['city']."&destination=".$_POST['city2']."&weight=".$_POST['berat']."&courier=jne",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
   "key: 37068c4174315a0b794bf6ba9d55e1f2"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $response_decode = json_decode($response,true);

  $dari = $response_decode['rajaongkir']['origin_details']['province']." (".$response_decode['rajaongkir']['origin_details']['city_name'].")";
  $ke = $response_decode['rajaongkir']['destination_details']['province']." (".$response_decode['rajaongkir']['destination_details']['city_name'].")";
  $berat = $response_decode['rajaongkir']['query']['weight'];

  echo "<h1>Ongkir JNE : $dari ke $ke  Dengan Berat $berat Kg</h1>";
  echo "<ol>";
  
  foreach ($response_decode['rajaongkir']['results'][0]['costs'] as $key => $value) {
     echo "<li>Service : $value[service] ( $value[description] )</li>";
     echo "<ol>";
      echo "<li>Biaya : ".$value['cost']['0']['value']."</li>";
      echo "<li>Estimasi : ".$value['cost']['0']['etd']." Hari</li>"; 
     echo "</ol>";
  }
  echo "</ol>";
  
}

?>