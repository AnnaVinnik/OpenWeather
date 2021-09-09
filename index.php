<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Weather</h1>
    <?
    //Получение данных
    $url = 'https://api.openweathermap.org/data/2.5/onecall';

    $options = array(
        'lat' => '55',
        'lon' => '83',
        'exclude' => 'current,minutely,hourly,alerts',
        'units' => 'metric',
        'appid' => 'f53307db7e43e8cb7e7d9a63499530dd'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($options));

    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);

    //Задание 3а.1
    $min_difference = abs($data['daily'][0]['temp']['night'] - $data['daily'][0]['feels_like']['night']);   //Вычисление разницы первого дня для сравненния
    for ($i = 0; $i < count($data['daily']); $i++) {
        $currently_difference = abs($data['daily'][$i]['temp']['night'] - $data['daily'][$i]['feels_like']['night']);   //Вычисление разницы для текущей итерации
        if ($currently_difference < $min_difference) {
            $min_difference = $currently_difference;
            $day = $i;
        }
    }
    echo '<pre>';
    print('<strong>min difference: ' . $min_difference . '&degC day: ' . date('d.m.Y', $data['daily'][$day]['dt']) . '</strong><br><br>');
    print_r($data);
    ?>
</body>

</html>