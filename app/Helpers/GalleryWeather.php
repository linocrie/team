<?php

    namespace App\Helpers;

    use Illuminate\Support\Facades\Http;

    class GalleryWeather {

        public function getWeather() {
            return Http::acceptJson()->get('http://api.openweathermap.org/data/2.5/weather?q=Yerevan&appid=9638c0cc9efbbfc00e4493a1effc4199&units=metric');
        }
    }
