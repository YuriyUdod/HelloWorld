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

   З адреси <?php echo $userLocationData->userIp; ?> цю сторінку відвідували <?php echo plural_form($kol,'.'); ?>

    <img src="https://www.countryflags.io/<?php echo strtolower($userLocationData->countryCode); ?>/flat/64.png" alt="">
    <br>
    <img src="http://www.rtdesigngroup.com/wp-content/uploads/2014/04/php-programming.jpg" alt="PHP Programming">
</p>
