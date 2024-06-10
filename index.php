<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Informasi Cuaca</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.css">
    <link rel="stylesheet" href="style.css">
</head>
<body id="myBody">
    <form method="post">
        <div class="card">
        <div class="search">
        <input type="text" class="seacrh-bar" placeholder="Masukkan nama kota:" name="kota" id="kota">
        <button type="submit" ><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        <div class="weather">
<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $kota = $_POST["kota"];

        // Menentukan API endpoint dan parameter permintaan
        $url = "https://api.openweathermap.org/data/2.5/weather";
        $params = [
            "q" => $kota,
            "appid" => "6637e3c07662b48f14ac34aa8e5f038a",
            "units" => "metric"
        ];

        // Mengirim permintaan ke API
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url . "?" . http_build_query($params));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        // Memeriksa apakah permintaan berhasil
        if ($response !== false) {
            // Mendapatkan data cuaca dari respons API
            $data = json_decode($response, true);
            if($data['cod'] == 200 && isset($data['name'])) {
                // Menampilkan informasi cuaca
                echo "<h2>Saat ini di " . $data['name'] .",".$data['sys']['country']. ":</h2>";       
                echo "<div style='display: flex; align-items: center;'>";
                echo "  <img src='https://openweathermap.org/img/wn/" . $data['weather'][0]['icon'] . ".png' width='150px' style='margin-right: 20px;'>";
                echo "  <h1 style='text-align: left; display: inline-block;'>" . $data['main']['temp'] . " &deg;C</h1>";
                echo "</div>";
                echo "  Kondisi Cuaca: " . $data['weather'][0]['description'] . "<br>";
                echo "  <span class='temp'>Suhu Min: " . $data['main']['temp_min'] . " &deg;C</span>";
                echo "  <span class='temp'>Suhu Max: " . $data['main']['temp_max'] . " &deg;C</span>";
                echo "  Kelembaban: " . $data['main']['humidity'] . "%<br>";
                echo "  Tekanan Atmosfer: " . $data['main']['pressure'] . " hPa<br>";
                echo "  Kecepatan Angin: " . $data['wind']['speed'] . " m/s<br>";
            } else {
                echo "Kota tidak ditemukan";
            }
        } 
    }
?>
        </div>
    </div>  
    </form>
</body>
</html>