<?php

if (!function_exists('photo')) {
    function photo ($path) {
        switch (true) {
            case !isset($path):
                return config('APP_URL') .  '/assets/images/default-intervensi.png';
            case strpos($path, 'uploads') !== false:
                return "https://kampungkb.bkkbn.go.id/$path";
            case strpos($path, 'public') !== false && Storage::exists($path):
                return url(Storage::url($path));
            case strpos($path, 'public') !== false:
                return 'https://kampungkb.bkkbn.go.id' . Storage::url($path);
            default:
                return 'https://kampungkb.bkkbn.go.id/assets/images/default-intervensi.png';
        }
    }
}

if (!function_exists('ext')) {
    function ext($filename) {
        $result = new finfo();

        if (is_resource($result) === true) {
            return $result->file($filename, FILEINFO_MIME_TYPE);
        }

        return false;
    }
}
