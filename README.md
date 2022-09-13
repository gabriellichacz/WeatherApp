<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# About
Weather app using OpenWeatherApi with Polish cities, created in PHP/Laravel 9 and Chart.js

</br>

# Usage
**!! User has to use their own API key from OpenWeather in *APIController.php* and *HomeController.php* !!**

Server start
```
php artisan serve
```

Run schedule to save weather data in 30 min intervals
```
php artisan schedule:work
```

# Features
User can search a list of polish towns/cities and follow 10 of them. App wiill save weather data to database and display historical values of temperature and humidity charts.