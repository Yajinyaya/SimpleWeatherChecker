<!doctype html>
<?php
$city = $_REQUEST['city'];
if (isset($_POST["OpenWeather"])){
    $OpenWeatherURL = "http://api.openweathermap.org/data/2.5/weather?q=".$city."&units=metric&lang=en&mode=xml&appid=108b0c5a4435980e4420031a3f04d25c";

    $readFromXML = simplexml_load_file($OpenWeatherURL);

    $getTemperature = $readFromXML->temperature['value'];
}
 else if (isset($_POST["WeatherBit"])){
    $WeatherbitURL = "https://api.weatherbit.io/v2.0/current?city=".$city."&key=96e5201d33634ae6a484ca215ca87303";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $WeatherbitURL);

    $response = curl_exec($ch);
    $readFromJSON = json_decode($response);
    $getTemperature = $readFromJSON->data[0]->temp;
}else if (isset($_POST["AccuWeather"])){
    $AccuWeatherKeyURL = "http://dataservice.accuweather.com/locations/v1/search?q=".$city."&apikey=bmnJiVA6vziUqQAWZZoiyASxSzONnr17";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $AccuWeatherKeyURL);
    $response = curl_exec($ch);
    $readFromJSON = json_decode($response);
    $getKey = ($readFromJSON)[0]->Key;

    $AccuWeatherURL = "http://dataservice.accuweather.com/currentconditions/v1/".$getKey."?apikey=bmnJiVA6vziUqQAWZZoiyASxSzONnr17";
    curl_setopt($ch, CURLOPT_URL, $AccuWeatherURL);
    $response = curl_exec($ch);
    $readFromJSON = json_decode($response);
    $getTemperature = ($readFromJSON)[0]->Temperature->Metric->Value;
 }

?>
<html>
<head>
    <title>Weather at <?php echo($city)?></title>
</head>
<body>
    <h2>Weather at <?php echo($city)?></h2>
    <label>Temperature in Celsius: <?php echo($getTemperature)?>&deg;C </label><br><br>
    <label>More information about the weather in Shanghai to be added... </label><br>
</body>
</html>
