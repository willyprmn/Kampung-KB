<?php

namespace App\Services;

use Storage;
use Str;

class StaticConfig
{

    const DIR_NAME = 'config';

    public static function read($path)
    {

        try {
            $filepath = self::getFilepath($path);
            return json_decode(Storage::get($filepath));
        } catch (\Exception $e) {
            return json_decode(Storage::get(str_replace('.json', '_default.json', $filepath)));
        }
    }

    public static function write(string $path, array $value)
    {

        $filepath = self::getFilepath($path);
        Storage::put($filepath, json_encode($value, JSON_PRETTY_PRINT));

        return true;

    }

    protected static function getFilepath($path)
    {
        $dir = Str::of($path)->explode('.');
        $dir->prepend(self::DIR_NAME);
        return $dir->join(DIRECTORY_SEPARATOR) . ".json";
    }
}