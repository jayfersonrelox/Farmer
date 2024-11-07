<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Information</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 10px 15px;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Weather Information</h1>

        @if(isset($weatherData) && count($weatherData) > 0)
            @foreach($weatherData as $data)
                <h2>{{ $data['name'] }}</h2>
                <p>Location: {{ $data['location'] }}</p>
                <p>Air Temperature: {{ $data['temp'] ?? 'N/A' }}°C</p>
                <p>Soil Temperature: {{ $data['soil_temp'] ?? 'N/A' }}°C</p>
                <p>Weather: {{ $data['description'] ?? 'N/A' }}</p>
                <hr>
            @endforeach
        @else
            <p>No weather data available.</p>
        @endif

        <a href="{{ url()->previous() }}">Back</a>
    </div>
</body>
</html>
