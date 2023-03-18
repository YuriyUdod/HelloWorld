<?php
class GeoPRequest {
 
    public $userIp = '';
    public $city = 'unknown';
    public $state = 'unknown';
    public $country = 'unknown';
    public $countryCode = 'unknown';
    public $continent = 'unknown';
    public $continentCode = 'unknown';
 
    public function infoByIp() {
 
        if (filter_var($this->userIp, FILTER_VALIDATE_IP) === false) {
            $this->userIp = $_SERVER["REMOTE_ADDR"];
        }
 
        if ($this->userIp == '127.0.0.1') {
            $this->city = $this->state = $this->country = $this->countryCode = $this->continent = $this->countryCode = 'local machine';
        }
 
        if (filter_var($this->userIp, FILTER_VALIDATE_IP)) {
            $ipData = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $this->userIp));
 
            if (strlen(trim($ipData->geoplugin_countryCode)) == 2) {
                $this->city = $ipData->geoplugin_city;
                $this->state = $ipData->geoplugin_regionName;
                $this->country = $ipData->geoplugin_countryName;
                $this->countryCode = $ipData->geoplugin_countryCode;
                $this->continent = $ipData->geoplugin_continentName;
                $this->continentCode = $ipData->geoplugin_continentCode;
            }
 
        }
 
        return $this;
    }

   public function getIp() {
 
        if (getenv('HTTP_CLIENT_IP')) {
            $this->userIp = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $this->userIp = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED')) {
            $this->userIp = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $this->userIp = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $this->userIp = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $this->userIp = getenv('REMOTE_ADDR');
        } else {
            $this->userIp = 'UNKNOWN';
        }
 
        return $this;
    }
}

$userLocationData = new GeoPRequest();
$userLocationData->getIp()->infoByIp();


//   $host = 'localhost';
//   $db_name = 'ipcount';
//   $user = '';
//   $password = '';
//   $ipa = $userLocationData->userIp;
//   $kol = 0;

//   $connection = mysqli_connect($host, $user, $password, $db_name);
//   $query = "SELECT ipa, kol, dl  FROM iplist where ipa='$ipa'";
//   $result = mysqli_query($connection, $query);

//   if (mysqli_num_rows($result) > 0) 
//   {
//     mysqli_query($connection, "update iplist set kol=kol+1 where ipa='$ipa'");
//     while($row = mysqli_fetch_array($result)){ $kol = $row['kol']+1;}
//   } else 
//   {
//     mysqli_query($connection, "insert into iplist (ipa,kol) values ('$ipa',1)");
//     $kol = 1;
//   }
//   mysqli_close($connection);

//function plural_form($number, $after) {
//    if ($number % 10 == 1 && $number % 100 != 11) {
//        return $number . ' раз';
//    } elseif (in_array($number % 10, array(2, 3, 4)) && !in_array($number % 100, array(12, 13, 14))) {
//        return $number . ' рази' . $after;
//    } else {
//        return $number . ' разів' . $after;
//    }
//}

?>
 
<p>
  <table border="1">
   <caption>Відвідувач</caption>
   <tr>
    <th>Параметр</th>
    <th>Значення</th>
   </tr>
   <tr><td align="center">IP       </td><td align="center"> <?php echo $userLocationData->userIp; ?>  </td></tr>
   <tr><td align="center">Місто    </td><td align="center"> <?php echo  $userLocationData->city; ?>  </td></tr>
   <tr><td align="center">Регіон   </td><td align="center"> <?php echo  $userLocationData->state; ?>  </td></tr>
   <tr><td align="center">Країна   </td><td align="center"> <?php echo  $userLocationData->country; ?>  </td></tr>
   <tr><td align="center">Континент</td><td align="center"> <?php echo  $userLocationData->continent; ?>  </td></tr>
   </table>
   <br>

   <img src="http://www.rtdesigngroup.com/wp-content/uploads/2014/04/php-programming.jpg" alt="PHP Programming">
</p>
