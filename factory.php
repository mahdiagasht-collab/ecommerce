<?php

class factory{
    private static $OBJAs = [];
    public static function factory(string $className){
        if (!isset(static::$OBJAs[$className])) {
            return static::$OBJAs[$className] = new $className;
        }
        return static::$OBJAs[$className];
    }
}