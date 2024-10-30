<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Tarik</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('image.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #000000;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        .container {
            background: rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 25px;
            color: #808080; /* تغيير اللون إلى الرمادي */
        }

        form {
            margin-bottom: 25px;
        }

        input[type="text"] {
            padding: 15px;
            width: calc(100% - 30px);
            border-radius: 30px;
            border: none;
            outline: none;
            margin-bottom: 15px;
            font-size: 1.1em;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        button {
            padding: 15px 30px;
            background: linear-gradient(to right, #56ccf2, #2f80ed);
            color: #000000;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1.1em;
            transition: transform 0.3s ease, background 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        button:hover {
            transform: scale(1.05);
            background: linear-gradient(to right, #2f80ed, #56ccf2);
        }

        .weather-result {
            background: rgba(255, 255, 255, 0.3);
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
        }

        .weather-result p {
            margin: 15px 0;
            font-size: 1.3em;
            color: #808080; /* تغيير اللون إلى الرمادي */
        }

        .weather-result p span {
            font-weight: bold;
            color: #ffd700;
        }

        .moving-image {
            position: absolute;
            width: 100px;
            height: auto;
            opacity: 1;
            animation: move 30s linear infinite;
        }

        @keyframes move {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(100vw, 100vh);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>جو بحال زب شنو بغي تعرف فيه</h1>
        <p>Created by Tarik</p>
        <form method="POST" action="">
            <input type="text" name="city" placeholder="كتب سمية لمدينة الزامل">
            <button type="submit">انا بغيت نعرف جو</button>
        </form>
        
        <?php
        if (isset($_SERVER['REQUEST_METHOD'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $city = htmlspecialchars($_POST['city']);
                $apiKey = "e054efe1ec4a13a5f6e8354dc04b27bc";
                $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($city) . "&appid=" . $apiKey . "&units=metric&lang=en";
                
                echo "<p>API URL: " . htmlspecialchars($apiUrl) . "</p>"; // طباعة رابط API للمساعدة في التصحيح
                
                $weatherData = @file_get_contents($apiUrl);
                
                if ($weatherData) {
                    $weatherArray = json_decode($weatherData, true);
                    if ($weatherArray['cod'] == 200) {
                        $temp = $weatherArray['main']['temp'];
                        $description = $weatherArray['weather'][0]['description'];
                        $humidity = $weatherArray['main']['humidity'];
                        
                        echo "<div class='weather-result'>";
                        echo "<p><span>City:</span> " . htmlspecialchars($city) . "</p>";
                        echo "<p><span>Temperature:</span> " . $temp . " &deg;C</p>";
                        echo "<p><span>Description:</span> " . ucfirst($description) . "</p>";
                        echo "<p><span>Humidity:</span> " . $humidity . "%</p>";
                        
                        if ($temp >= 20 && $temp <= 40) {
                            echo "<p style='color: #ff9800; font-weight: bold;'>جو مقود</p>";
                            echo "<img src='nabil.jpg' alt='nabil' class='moving-image' />";
                        } elseif ($temp >= 10 && $temp < 20) {
                            echo "<p style='color: #4caf50; font-weight: bold;'>جو مزيان</p>";
                            echo "<img src='tarik.jpg' alt='tarik' class='moving-image' />";
                        } elseif ($temp >= 0 && $temp < 10) {
                            echo "<p style='color: #2196f3; font-weight: bold;'>جو مقود عليه لبس تقود</p>";
                            echo "<img src='mehdi.jpg' alt='mehdi' class='moving-image' />";
                        } elseif ($temp >= -20 && $temp < 0) {
                            echo "<p style='color: #2196f3; font-weight: bold;'>ولقودااا</p>";
                            echo "<img src='badr.jpg' alt='badr' class='moving-image' />";
                        }
                        
                        echo "</div>";
                    } else {
                        echo "<p>No results found, please check the city name.</p>";
                    }
                } else {
                    echo "<p>An error occurred while fetching the data, please try again later.</p>";
                }
            }
        }
        ?>
    </div>
</body>
</html>